<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class UserSigninModel extends Model{
	public function userSignin($name, $password, $email){
		$result = Utils::executeRequest(self::$bdd,"INSERT INTO hd_user_users (login ,password, email, name, description) VALUES (:login, :password, :email, :login, :description)", array("login" => $name, "password" => password_hash($password, PASSWORD_DEFAULT), "email" => $email,"description" => "Je suis la description pas defaut. N'hésitez pas a me modifier !"), false);

		if (Utils::isError($result))
			return 1;
		$_SESSION["login"] = $name;
		return 0;
	}
}