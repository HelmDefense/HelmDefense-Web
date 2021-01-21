<?php
namespace Module;

use PDO;
use Utils;

class ForumPostModel extends Model {
	public function post($name, $id, $limit, $page) {
		$post = Utils::httpGetRequest("v1/forum/$name/$id", array("limit" => $limit, "page" => $page));
		return Utils::isError($post) ? null : $post;
	}

	public function newTalk($title, $message) {
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_forum_topics (title) VALUES (:title)", array("title" => $title));
		$id = self::$bdd->lastInsertId();
		$this->postComment(1, $id, $message);
		return $id;
	}

	public function newRate($title, $message, $entity, $rate) {
		$num =  Utils::executeRequest(self::$bdd, "SELECT num FROM hd_game_entities WHERE id = :id", array("id" => $entity), false, PDO::FETCH_COLUMN);
		if (!$num)
			return false;
		Utils::executeRequest(self::$bdd,"INSERT INTO hd_forum_comments (title, entity, rate) VALUES (:title, :entity, :rate)", array("title" => $title, "entity" => $num, "rate" => $rate));
		$id = self::$bdd->lastInsertId();
		$this->postComment(2, $id, $message);
		return $id;
	}

	public function newStrat($title, $message, $level, $hero, $entities) {
		$numHero = Utils::executeRequest(self::$bdd, "SELECT num FROM hd_game_entities WHERE id = :id", array("id" => $hero), false, PDO::FETCH_COLUMN);
		$numLevel = Utils::executeRequest(self::$bdd, "SELECT num FROM hd_game_levels WHERE id = :id", array("id" => $level), false, PDO::FETCH_COLUMN);
		if (!$numHero || !$numLevel)
			return false;
		self::$bdd->beginTransaction();
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_forum_strats (title, level, hero) VALUES (:title, :level, :hero)", array("title" => $title, "level" => $numLevel, "hero" => $numHero));
		$id = self::$bdd->lastInsertId();
		$seenEntities = array();
		foreach ($entities->entity as $i => $entity) {
			if (in_array($entity, $seenEntities)) {
				self::$bdd->rollBack();
				return false;
			}
			$seenEntities[] = $entity;
			$count = $entities->count->$i;
			$numEntity = Utils::executeRequest(self::$bdd, "SELECT num FROM hd_game_entities WHERE id = :id", array("id" => $entity), false, PDO::FETCH_COLUMN);
			if (!$numEntity)
				return false;
			Utils::executeRequest(self::$bdd, "INSERT INTO hd_forum_strat_entities (strat, entity, count) VALUE (:strat, :entity, :count)", array("strat" => $id, "entity" => $numEntity, "count" => $count));
		}
		if (!count($seenEntities)) {
			self::$bdd->rollBack();
			return false;
		}
		$this->postComment(3, $id, $message);
		self::$bdd->commit();
		return $id;
	}

	public function isOpened($type, $id) {
		switch ($type) {
		case 1:
			$sql = "SELECT opened FROM hd_forum_topics WHERE id = :id";
			break;
		case 2:
			$sql = "SELECT opened FROM hd_forum_comments WHERE id = :id";
			break;
		case 3:
			$sql = "SELECT opened FROM hd_forum_strats WHERE id = :id";
			break;
		default :
			return false;
		}
		return Utils::executeRequest(self::$bdd, $sql, array("id" => $id), false, PDO::FETCH_COLUMN);
	}

	public function getId(){
		$user = Utils::loggedInUser();
        if (is_null($user))
            return false;
        $idAuthor = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_user_users where login = :login", array("login" => $user->id), false, PDO::FETCH_COLUMN);
        if ($idAuthor === false)
            return false;
        return $idAuthor;
	}

	public function postComment($type, $id, $comment) {
		$idAuthor = $this->getId();
		if (!$idAuthor)
			return false;
        Utils::executeRequest(self::$bdd, "INSERT INTO hd_forum_msgs (topic, type, content, author) VALUES (:id, :type, :comment, :author)", array("id" => $id, "type" => $type, "comment" => $comment, "author" => $idAuthor));
		return true;
	}

	public function entitiesWithRate() {
		return Utils::executeRequest(self::$bdd, "SELECT id, name, type FROM hd_game_entities ORDER BY type");
	}

	public function heroes() {
		return Utils::executeRequest(self::$bdd, "SELECT id, name FROM hd_game_entities WHERE type = 3");
	}

	public function levels() {
		return Utils::executeRequest(self::$bdd, "SELECT id, name FROM hd_game_levels");
	}

	public function defenders() {
		return Utils::executeRequest(self::$bdd, "SELECT id, name FROM hd_game_entities WHERE type = 1");
	}

	public function stratRating($id, $rate, $comment) {
		$idAuthor = $this->getId();
		if (!$idAuthor)
			return false;
		$exists = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_forum_strat_ratings WHERE strat = :strat AND user = :user", array("strat" => $id, "user" => $idAuthor), false, PDO::FETCH_COLUMN);
		if ($exists)
			return false;
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_forum_strat_ratings (strat, user, rate, comment) VALUES (:strat, :user, :rate, :comment)", array("strat" => $id, "user" => $idAuthor, "rate" => $rate, "comment" => $comment));
		return true;
	}

	public function getMsgAuthor($id) {
		$result = Utils::executeRequest(self::$bdd,"SELECT u.login FROM hd_forum_msgs AS m INNER JOIN hd_user_users AS u ON m.author = u.id WHERE m.id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
		if (!$result)
			return false;
		return $result;
	}

	public function modify($id, $message) {
		Utils::executeRequest(self::$bdd, "UPDATE hd_forum_msgs SET content = :message WHERE id = :id", array("message" => $message, "id" => $id));
	}
}
