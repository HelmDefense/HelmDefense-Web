<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class ForumModel extends Connection {
	public function list($type, $limit, $offset) {
		switch ($type) {
		case "topic":
			$posts = Utils::executeRequest(self::$bdd, "SELECT t.id, t.title, d.`date` AS last_activity, t.opened, (SELECT m.id FROM hd_forum_msgs AS m WHERE m.topic = t.id AND m.type = 1 ORDER BY m.created_at ASC LIMIT 1) AS msg, (SELECT count(m.id) FROM hd_forum_msgs AS m WHERE m.topic = t.id AND m.type = 1) AS message_count FROM hd_forum_topics AS t INNER JOIN (SELECT m.topic, MAX(IFNULL(m.edited_at, m.created_at)) AS `date` FROM hd_forum_msgs AS m WHERE m.type = 1 GROUP BY m.topic ORDER BY `date` DESC) AS d ON t.id = d.topic ORDER BY d.`date` DESC LIMIT $limit OFFSET $offset");
			break;
		case "comment":
			$posts = Utils::executeRequest(self::$bdd, "SELECT `c`.id, `c`.title, e.id AS entity_id, e.name AS entity_name, `c`.rate, d.`date` AS last_activity, `c`.opened, (SELECT m.id FROM hd_forum_msgs AS m WHERE m.topic = `c`.id AND m.type = 2 ORDER BY m.created_at ASC LIMIT 1) AS msg, (SELECT count(m.id) FROM hd_forum_msgs AS m WHERE m.topic = `c`.id AND m.type = 2) AS message_count FROM hd_forum_comments AS `c` INNER JOIN hd_game_entities AS e ON `c`.entity = e.num INNER JOIN (SELECT m.topic, MAX(IFNULL(m.edited_at, m.created_at)) AS `date` FROM hd_forum_msgs AS m WHERE m.type = 2 GROUP BY m.topic ORDER BY `date` DESC) AS d ON `c`.id = d.topic ORDER BY d.`date` DESC LIMIT $limit OFFSET $offset");
			if (!$posts)
				return null;
			foreach ($posts as $post)
				$this->setIdName($post, "entity");
			break;
		case "strat":
			$posts = Utils::executeRequest(self::$bdd, "SELECT s.id, s.title, l.id AS level_id, l.name AS level_name, e.id AS hero_id, e.name AS hero_name, d.`date` AS last_activity, s.opened, (SELECT m.id FROM hd_forum_msgs AS m WHERE m.topic = s.id AND m.type = 3 ORDER BY m.created_at ASC LIMIT 1) AS msg, (SELECT count(m.id) FROM hd_forum_msgs AS m WHERE m.topic = s.id AND m.type = 3) AS message_count FROM hd_forum_strats AS s INNER JOIN hd_game_entities AS e ON s.hero = e.num INNER JOIN hd_game_levels AS l ON s.level = l.num INNER JOIN (SELECT m.topic, MAX(IFNULL(m.edited_at, m.created_at)) AS `date` FROM hd_forum_msgs AS m WHERE m.type = 3 GROUP BY m.topic ORDER BY `date` DESC) AS d ON s.id = d.topic ORDER BY d.`date` DESC LIMIT $limit OFFSET $offset");
			if (!$posts)
				return null;
			foreach ($posts as $post) {
				$this->setIdName($post, "hero");
				$this->setIdName($post, "level");
			}
			break;
		default:
			return null;
		}
		if (!$posts)
			return null;
		foreach ($posts as $post) {
			$msg = Utils::executeRequest(self::$bdd, "SELECT u.login AS author, u.name AS author_name, m.created_at FROM hd_forum_msgs AS m INNER JOIN hd_user_users AS u ON m.author = u.id WHERE m.id = :id", array("id" => $post->msg), false);
			$post->author = new stdClass();
			$post->author->id = $msg->author;
			$post->author->name = $msg->author_name;
			$post->created_at = $msg->created_at;
			$post->opened = boolval($post->opened);
			unset($post->msg);
		}
		return $posts;
	}

	public function get($type, $id) {
		switch ($type) {
		case "topic":
			$post = Utils::executeRequest(self::$bdd, "SELECT id, title, opened FROM hd_forum_topics WHERE id = :id", array("id" => $id), false);
			$type = 1;
			break;
		case "comment":
			$post = Utils::executeRequest(self::$bdd, "SELECT `c`.id, `c`.title, e.id AS entity_id, e.name AS entity_name, `c`.rate, `c`.opened FROM hd_forum_comments AS `c` INNER JOIN hd_game_entities AS e ON `c`.entity = e.num WHERE `c`.id = :id", array("id" => $id), false);
			$type = 2;
			if (!$post)
				return null;
			$this->setIdName($post, "entity");
			break;
		case "strat":
			$post = Utils::executeRequest(self::$bdd, "SELECT s.id, s.title, l.id AS level_id, l.name AS level_name, e.id AS hero_id, e.name AS hero_name, s.opened FROM hd_forum_strats AS s INNER JOIN hd_game_entities AS e ON s.hero = e.num INNER JOIN hd_game_levels AS l ON s.level = l.num WHERE s.id = :id", array("id" => $id), false);
			$type = 3;
			if (!$post)
				return null;
			$this->setIdName($post, "hero");
			$this->setIdName($post, "level");
			$post->entities = Utils::executeRequest(self::$bdd, "SELECT e.id AS entity_id, e.name AS entity_name, s.count FROM hd_forum_strat_entities AS s INNER JOIN hd_game_entities AS e ON s.entity = e.num WHERE s.strat = :id", array("id" => $id));
			foreach ($post->entities as $entity)
				$this->setIdName($entity, "entity");
			$post->ratings = Utils::executeRequest(self::$bdd, "SELECT u.login AS user_id, u.name AS user_name, s.rate, s.comment FROM hd_forum_strat_ratings AS s INNER JOIN hd_user_users AS u ON s.user = u.id WHERE s.strat = :id", array("id" => $id));
			foreach ($post->ratings as $rating)
				$this->setIdName($rating, "user");
			break;
		default:
			return null;
		}
		if (!$post)
			return null;

		$msgs = Utils::executeRequest(self::$bdd, "SELECT u.login AS author_id, u.name AS author_name, m.content, m.created_at, m.edited_at FROM hd_forum_msgs AS m INNER JOIN hd_user_users AS u ON m.author = u.id WHERE m.topic = :id AND m.type = :type ORDER BY m.created_at ASC", array("id" => $post->id, "type" => $type));
		$lastActivity = "1970-01-01 00:00:00";
		foreach ($msgs as $msg) {
			$this->setIdName($msg, "author");
			if (is_null($msg->edited_at)) {
				unset($msg->edited_at);
				$date = $msg->created_at;
			} else
				$date = $msg->edited_at;
			if ($date > $lastActivity)
				$lastActivity = $date;
		}
		$post->messages = $msgs;
		$post->message_count = count($msgs);
		$post->author = $msgs[0]->author;
		$post->created_at = $msgs[0]->created_at;
		$post->last_activity = $lastActivity;
		$post->opened = boolval($post->opened);
		return $post;
	}

	private function setIdName($obj, $prop) {
		$prop_id = "{$prop}_id";
		$prop_name = "{$prop}_name";
		$val = new stdClass();
		$val->id = $obj->$prop_id;
		$val->name = $obj->$prop_name;
		unset($obj->$prop_id);
		unset($obj->$prop_name);
		$obj->$prop = $val;
	}
}
