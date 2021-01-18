<?php
namespace Module;

use Utils;
use PDO;

class UserProfileModel extends Model {
	public function searchInfo() {
		return Utils::loggedInUser();
	}

	public function recupMail($user) {
		return Utils::executeRequest(self::$bdd, "SELECT email FROM hd_user_users WHERE login = :id", array("id" => $user->id), false, PDO::FETCH_COLUMN);
	}

	public function updatePassword($password, $user) {
		Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET password = :password WHERE login = :id", array("password" => password_hash($password, PASSWORD_DEFAULT), "id" => $user->id));
	}

	public function updateSettings($name, $email, $description, $user) {
		Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET `name` = :name, email = :email, description = :description WHERE login = :id", array("name" => $name, "email" => $email, "description" => $description, "id" => $user->id));
	}

	public function passwordCheck($password, $user){
		$result = Utils::httpPostRequest("v1/users/auth/$user->id",array("password" => $password));
		return !Utils::isError($result) && $result;
	}

	public function modifyAvatar($avatar, $user) {
		$avatarDir = $_SERVER["DOCUMENT_ROOT"] . "/data/img/avatar/";
		$oldAvatar = Utils::executeRequest(self::$bdd, "SELECT avatar FROM hd_user_users WHERE login = :id", array("id" => $user->id), false, PDO::FETCH_COLUMN);
		if (!is_null($oldAvatar))
			unlink($avatarDir . $oldAvatar);
		$newAvatar = basename($avatar->name);
		if (move_uploaded_file($avatar->tmp_name, $avatarDir . $newAvatar)) {
			Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET avatar = :avatar WHERE login = :id", array("id" => $user->id, "avatar" => $newAvatar));
			return true;
		}
		return false;
	}

	public function deleteAccount($password, $user) {
		$result = Utils::httpPostRequest("v1/users/auth/$user->name", array("password" => $password));
		if (Utils::isError($result) || !$result)
			return false;
		Utils::executeRequest(self::$bdd, "DELETE FROM hd_user_users WHERE login = :id", array("id" => $user->id));
		return true;
	}
}
