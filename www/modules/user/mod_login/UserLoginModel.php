<?php
namespace Module;

use Utils;

class UserLoginModel extends Model {
	public function userConnect($name, $password) {
		$user = Utils::httpPostRequest("v1/users/auth/$name", array("password" => $password));
		if (Utils::isError($user))
			return 1;
		if (is_null($user))
			return 5;
		if (!$user)
			return 2;
		$_SESSION["login"] = $name;
		return 0;
	}

	public function userDisconnect() {
		unset($_SESSION["login"]);
	}
}
