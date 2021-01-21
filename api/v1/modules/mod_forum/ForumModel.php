<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class ForumModel extends Connection {
	public function types() {
		return array(
				"talk" => "/forum/talk",
				"rate" => "/forum/rate",
				"strat" => "/forum/strat",
				"msg" => "/forum/msg/{id}"
		);
	}

	public function list($type, $limit, $offset) {
		self::$bdd->beginTransaction();
		switch ($type) {
		case "talk":
			$posts = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS t.id, t.title, d.`date` AS last_activity, t.opened, (SELECT m.id FROM hd_forum_msgs AS m WHERE m.topic = t.id AND m.type = 1 ORDER BY m.created_at LIMIT 1) AS msg, (SELECT COUNT(m.id) FROM hd_forum_msgs AS m WHERE m.topic = t.id AND m.type = 1) AS message_count FROM hd_forum_topics AS t INNER JOIN (SELECT m.topic, MAX(IFNULL(m.edited_at, m.created_at)) AS `date` FROM hd_forum_msgs AS m WHERE m.type = 1 GROUP BY m.topic ORDER BY `date` DESC) AS d ON t.id = d.topic ORDER BY d.`date` DESC LIMIT $offset, $limit");
			break;
		case "rate":
			$posts = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS `c`.id, `c`.title, e.id AS entity_id, e.name AS entity_name, `c`.rate, d.`date` AS last_activity, `c`.opened, (SELECT m.id FROM hd_forum_msgs AS m WHERE m.topic = `c`.id AND m.type = 2 ORDER BY m.created_at LIMIT 1) AS msg, (SELECT COUNT(m.id) FROM hd_forum_msgs AS m WHERE m.topic = `c`.id AND m.type = 2) AS message_count FROM hd_forum_comments AS `c` INNER JOIN hd_game_entities AS e ON `c`.entity = e.num INNER JOIN (SELECT m.topic, MAX(IFNULL(m.edited_at, m.created_at)) AS `date` FROM hd_forum_msgs AS m WHERE m.type = 2 GROUP BY m.topic ORDER BY `date` DESC) AS d ON `c`.id = d.topic ORDER BY d.`date` DESC LIMIT $offset, $limit");
			if (!$posts)
				break;
			foreach ($posts as $post)
				$this->setProp($post, "entity", "id", "name");
			break;
		case "strat":
			$posts = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS s.id, s.title, l.id AS level_id, l.name AS level_name, e.id AS hero_id, e.name AS hero_name, d.`date` AS last_activity, s.opened, (SELECT m.id FROM hd_forum_msgs AS m WHERE m.topic = s.id AND m.type = 3 ORDER BY m.created_at LIMIT 1) AS msg, (SELECT COUNT(m.id) FROM hd_forum_msgs AS m WHERE m.topic = s.id AND m.type = 3) AS message_count FROM hd_forum_strats AS s INNER JOIN hd_game_entities AS e ON s.hero = e.num INNER JOIN hd_game_levels AS l ON s.level = l.num INNER JOIN (SELECT m.topic, MAX(IFNULL(m.edited_at, m.created_at)) AS `date` FROM hd_forum_msgs AS m WHERE m.type = 3 GROUP BY m.topic ORDER BY `date` DESC) AS d ON s.id = d.topic ORDER BY d.`date` DESC LIMIT $offset, $limit");
			if (!$posts)
				break;
			foreach ($posts as $post) {
				$this->setProp($post, "hero", "id", "name");
				$this->setProp($post, "level", "id", "name");
			}
			break;
		default:
			return null;
		}
		$total = Utils::executeRequest(self::$bdd, "SELECT FOUND_ROWS() AS total", array(), false)->total;
		self::$bdd->commit();
		if ($posts === false)
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
		return array("result" => $posts, "count" => $total);
	}

	public function get($type, $id, $limit, $offset) {
		switch ($type) {
		case "talk":
			$post = Utils::executeRequest(self::$bdd, "SELECT id, title, opened FROM hd_forum_topics WHERE id = :id", array("id" => $id), false);
			$type = 1;
			break;
		case "rate":
			$post = Utils::executeRequest(self::$bdd, "SELECT `c`.id, `c`.title, e.id AS entity_id, e.name AS entity_name, concat('https://helmdefense.theoszanto.fr/data/img/wiki/entity/', e.num, '.png') AS entity_image, `c`.rate, `c`.opened FROM hd_forum_comments AS `c` INNER JOIN hd_game_entities AS e ON `c`.entity = e.num WHERE `c`.id = :id", array("id" => $id), false);
			$type = 2;
			if (!$post)
				return null;
			$this->setProp($post, "entity", "id", "name", "image");
			break;
		case "strat":
			$post = Utils::executeRequest(self::$bdd, "SELECT s.id, s.title, l.id AS level_id, l.name AS level_name, concat('https://helmdefense.theoszanto.fr/data/img/wiki/level/', l.num, '.png') AS level_image, e.id AS hero_id, e.name AS hero_name, concat('https://helmdefense.theoszanto.fr/data/img/wiki/entity/', e.num, '.png') AS hero_image, s.opened FROM hd_forum_strats AS s INNER JOIN hd_game_entities AS e ON s.hero = e.num INNER JOIN hd_game_levels AS l ON s.level = l.num WHERE s.id = :id", array("id" => $id), false);
			$type = 3;
			if (!$post)
				return null;
			$this->setProp($post, "hero", "id", "name", "image");
			$this->setProp($post, "level", "id", "name", "image");
			$post->entities = Utils::executeRequest(self::$bdd, "SELECT e.id AS entity_id, e.name AS entity_name, concat('https://helmdefense.theoszanto.fr/data/img/wiki/entity/', e.num, '.png') AS entity_image, s.count FROM hd_forum_strat_entities AS s INNER JOIN hd_game_entities AS e ON s.entity = e.num WHERE s.strat = :id", array("id" => $id));
			foreach ($post->entities as $entity)
				$this->setProp($entity, "entity", "id", "name", "image");
			$post->ratings = Utils::executeRequest(self::$bdd, "SELECT u.login AS user_id, u.name AS user_name, concat('https://helmdefense.theoszanto.fr/data/img/avatar/', if(u.avatar IS NULL, 'default.png', concat(u.id, '-', u.avatar))) AS user_avatar, s.rate, s.comment, s.date FROM hd_forum_strat_ratings AS s INNER JOIN hd_user_users AS u ON s.user = u.id WHERE s.strat = :id ORDER BY s.date DESC", array("id" => $id));
			foreach ($post->ratings as $rating)
				$this->setProp($rating, "user", "id", "name", "avatar");
			break;
		case "msg":
			$msg = Utils::executeRequest(self::$bdd, "SELECT content FROM hd_forum_msgs WHERE id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
			if (!$msg)
				return false;
			return array("msg" => $msg);
		default:
			return null;
		}
		if (!$post)
			return null;

		self::$bdd->beginTransaction();
		$msgs = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS m.id, u.login AS author_id, u.name AS author_name, concat('https://helmdefense.theoszanto.fr/data/img/avatar/', if(u.avatar IS NULL, 'default.png', concat(u.id, '-', u.avatar))) AS author_avatar, m.content, m.created_at, m.edited_at FROM hd_forum_msgs AS m INNER JOIN hd_user_users AS u ON m.author = u.id WHERE m.topic = :id AND m.type = :type ORDER BY m.created_at LIMIT $offset, $limit", array("id" => $post->id, "type" => $type));
		$post->message_count = Utils::executeRequest(self::$bdd, "SELECT found_rows()", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		$lastActivity = "1970-01-01 00:00:00";
		foreach ($msgs as $msg) {
			$this->setProp($msg, "author", "id", "name", "avatar");
			if (is_null($msg->edited_at)) {
				unset($msg->edited_at);
				$date = $msg->created_at;
			} else
				$date = $msg->edited_at;
			if ($date > $lastActivity)
				$lastActivity = $date;
		}
		$post->messages = $msgs;
		$post->author = $msgs[0]->author;
		$post->created_at = $msgs[0]->created_at;
		$post->last_activity = $lastActivity;
		$post->opened = boolval($post->opened);
		return $post;
	}

	private function setProp($obj, $prop, ...$properties) {
		$val = new stdClass();
		foreach ($properties as $property) {
			$p = "{$prop}_$property";
			$val->$property = $obj->$p;
			unset($obj->$p);
		}
		$obj->$prop = $val;
	}
}
