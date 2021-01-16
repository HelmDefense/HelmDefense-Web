<?php
namespace Module;

use Utils;
use PDO;

include_once "modules/generic/Model.php";

class UserProfileModel extends Model {
	function searchInfo() {
		return Utils::loggedInUser();
	}

	function recupMail($user) {
		return Utils::executeRequest(self::$bdd, "SELECT email FROM hd_user_users WHERE login = :idUser", array("idUser" => $user->id), false, PDO::FETCH_COLUMN);
	}

	function updatePassword($passwd, $user) {
		Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET password = :passwd WHERE login = :id", array("passwd" => password_hash($passwd, PASSWORD_DEFAULT), "id" => $user->id));
	}

	function updateSettings($name, $email, $descritpion, $user) {
		Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET `name` = :name, email = :email, description = :descritpion WHERE login = :id", array("name" => $name, "email" => $email, "descritpion" => $descritpion, "id" => $user->id));
	}
}
