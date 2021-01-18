<?php
namespace Module;

use PDO;
use stdClass;
use Utils;

class PanelModoModel extends Model {

	public function users($p, $limit) {
		$offset = ($p - 1) * $limit;
		$users = new stdClass();
		self::$bdd->beginTransaction();
		$users->result = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS id, login, name, avatar, joined_at FROM hd_user_users LIMIT $offset, $limit");
		$users->count = Utils::executeRequest(self::$bdd, "SELECT found_rows() AS total", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		return $users;
	}

	public function addSanction($id, $type, $reason) {
		$exists = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_user_users WHERE id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
		if(!$exists)
			return false;
		$mod = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_user_users WHERE login = :login", array("login" => Utils::session("login")), false, PDO::FETCH_COLUMN);
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_user_sanctions (type, user, reason, moderator) VALUES (:type, :user, :reason, :moderator)", array("type" => $type, "user" => $id, "reason" => $reason, "moderator" => $mod));
		return true;
	}
}
