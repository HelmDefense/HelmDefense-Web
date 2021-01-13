<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class UserSigninModel extends Model{
	public function userSignin($name, $password, $email){
		$result = Utils::executeRequest(self::$bdd,"INSERT INTO hd_user_users (login ,password, email) VALUES (:login, :password, :email)", array("login" => $name, "password" => password_hash($password, PASSWORD_DEFAULT), "email" => $email), false);

		if (Utils::isError($result))
			return 1;
		return 0;
	}
}