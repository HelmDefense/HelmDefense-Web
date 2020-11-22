<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class UsersModel extends Connection {
	public function get($id) {
		$user = Utils::executeRequest(self::$bdd, "SELECT login, `name`, avatar, description, joined_at, ranks FROM hd_user_users WHERE login = :id", array("id" => $id), false);

		if (!$user)
			Utils::error(404, "User not found");

		$ranks = $user->ranks;
		$user->ranks = array();
		if ($ranks & 0x01)
			$user->ranks[] = "administrator";
		if ($ranks & 0x02)
			$user->ranks[] = "developer";
		if ($ranks & 0x03)
			$user->ranks[] = "moderator";
		if ($ranks & 0x04)
			$user->ranks[] = "redactor";

		return $user;
	}

	public function auth($id, $passwd) {
		$user = Utils::executeRequest(self::$bdd, "SELECT password FROM hd_user_users WHERE login = :id", array("id" => $id), false);

		if (!$user)
			Utils::error(404, "User not found");

		$hash = $user->password;
		return password_verify($passwd, $hash);
	}
}
