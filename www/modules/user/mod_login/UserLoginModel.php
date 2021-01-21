<?php
namespace Module;

use PDO;
use Utils;

class UserLoginModel extends Model {
	public function userConnect($name, $password) {
		$user = Utils::httpPostRequest("v1/users/auth/$name", array("password" => $password));
		if (Utils::isError($user))
			return 1;
		if (!$user)
			return 2;
		$_SESSION["login"] = $name;
		return 0;
	}

	public function getBan($name){
		return Utils::executeRequest(self::$bdd, "SELECT s.reason FROM hd_user_sanctions AS s INNER JOIN hd_user_users AS u ON s.user = u.id WHERE u.login = :login AND s.type = 2", array("login" => $name), false, PDO::FETCH_COLUMN);
	}

	public function userDisconnect() {
		unset($_SESSION["login"]);
	}
}
