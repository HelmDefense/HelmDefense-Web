<?php
namespace Module;

use PDO;
use stdClass;
use Utils;

class PanelAdminModel extends Model {

	public function users($p, $limit) {
		$offset = ($p - 1) * $limit;
		$users = new stdClass();
		self::$bdd->beginTransaction();
		$users->result = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS id, login, email, name, avatar, ranks, joined_at FROM hd_user_users LIMIT $offset, $limit");
		$users->count = Utils::executeRequest(self::$bdd, "SELECT found_rows() AS total", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		foreach ($users->result as $user)
			$this->defineRanks($user);
		return $users;
	}

	public function pages($p, $limit) {
		$offset = ($p - 1) * $limit;
		$pages = new stdClass();
		self::$bdd->beginTransaction();
		$pages->result = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS p.num, p.id, p.title, p.created_at, p.edited_at, u.login AS author, u.name AS author_name, p.published FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u on p.author = u.id WHERE p.title = '' LIMIT $offset, $limit");
		$pages->count = Utils::executeRequest(self::$bdd, "SELECT found_rows() AS total", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		return $pages;
	}

	public function defineRanks($user) {
		$ranks = $user->ranks;
		$user->ranks = array();
		if ($ranks & 0b0001)
			$user->ranks[] = "administrator";
		if ($ranks & 0b0010)
			$user->ranks[] = "developer";
		if ($ranks & 0b0100)
			$user->ranks[] = "moderator";
		if ($ranks & 0b1000)
			$user->ranks[] = "redactor";
	}

	public function getUser($id) {
		return Utils::executeRequest(self::$bdd, "SELECT login, name, avatar, email, ranks FROM hd_user_users WHERE id = :id", array("id" => $id), false);
	}

	public function editRole($id, $login, $admin, $dev, $modo, $redac) {
		$exists = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_user_users WHERE id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
		if (!$exists)
			return false;
		$ranks = 0;
		if (!is_null($admin))
			$ranks |= 0b0001;
		if (!is_null($dev))
			$ranks |= 0b0010;
		if (!is_null($modo))
			$ranks |= 0b0100;
		if (!is_null($redac))
			$ranks |= 0b1000;
		Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET ranks = :ranks, login = :login WHERE id = :id", array("ranks" => $ranks, "login" => $login, "id" => $id));
		return true;
	}
}