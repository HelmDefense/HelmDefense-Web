<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class UsersModel extends Connection {

	public function get($id) {
		$query = self::$bdd->prepare("SELECT login, `name`, avatar, description, joined_at, ranks FROM hd_user_users WHERE login = :id");
		$params = array("id" => $id);

		if (!$query->execute($params))
			throw new PDOException();

		$return = $query->fetch(PDO::FETCH_ASSOC);
		$ranks = $return ["ranks"];
		$return ["ranks"] = array();

		if($ranks & 0x01)
			$return ["ranks"] [] = "administrator";
		if($ranks & 0x02)
			$return ["ranks"] [] = "developer";
		if($ranks & 0x03)
			$return ["ranks"] [] = "moderator";
		if($ranks & 0x04)
			$return ["ranks"] [] = "redactor";

		return $return;
	}

	public function auth($id, $passwd) {
		$query = self::$bdd->prepare("SELECT password FROM hd_user_users WHERE login = :id");
		$params = array(
			"id" => $id
		);

		if (!$query->execute($params))
			throw new PDOException();

		return password_verify($passwd ,$query->fetch(PDO::FETCH_ASSOC) ["password"]);
	}
}
