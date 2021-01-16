<?php
namespace Module;

use PDO;
use Utils;

class UserSigninModel extends Model{
	public function resetPasswordRequest($login, $password) {
		$data = Utils::executeRequest(self::$bdd, "SELECT id, email FROM hd_user_users WHERE login = :login", array("login" => $login), false);
		if (!is_null($data->id)) {
			$code = Utils::randomString(32);
			if (mail($data->email, "Mot de passe perdu - Helm Defense", "Bonjour,\r\nVous avez récemment perdu votre mot de passe ? Si oui rendez-vous à cette adresse pour valider le changement de mot de passe : " . Utils::SITE_URL . "user/signin/resetpassword/$code\r\nSi non ignorez ce mail", "From: Helm Defense <helmdefense@theoszanto.fr>")) {
				Utils::executeRequest(self::$bdd,"INSERT INTO hd_user_password_reset (user, code, reset_password) VALUES (:id, :code, :password)", array("id" => $data->id, "password" => password_hash($password, PASSWORD_DEFAULT), "code" => $code));
				return $data->email;
			}
		}
		return null;
	}

	public function resetPassword($code) {
		$result = Utils::executeRequest(self::$bdd, "SELECT user, reset_password, date FROM hd_user_password_reset WHERE code = :code", array("code" => $code), false);
		if ($result) {
			Utils::executeRequest(self::$bdd, "DELETE FROM hd_user_password_reset WHERE user = :user", array("user" => $result->user));
			if (time() - strtotime($result->date) < 900) {
				Utils::executeRequest(self::$bdd, "UPDATE hd_user_users SET password = :password WHERE id = :id", array("password" => $result->reset_password, "id" => $result->user));
				return true;
			}
		}
		return false;
	}

	public function userSignin($login, $name, $password, $email) {
		$result = Utils::executeRequest(self::$bdd, "SELECT count(1) from hd_user_users where login = :login OR email = :email", array("login" => $login, "email" => $email), false, PDO::FETCH_COLUMN);
		if ($result)
			return 1;
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_user_users (login, password, email, name, description) VALUES (:login, :password, :email, :name, :description)", array("login" => $login, "password" => password_hash($password, PASSWORD_DEFAULT), "email" => $email, "name" => $name, "description" => "Je suis la description par defaut. N'hésitez pas à me modifier !"));
		$_SESSION["login"] = $login;
		mail($email, "Nouveau compte Helm Defense", "Bonjour $name\r\n"."Nous vous confirmons la création de votre compte !", "From: Helm Defense <helmdefense@theoszanto.fr>");
		return 0;
	}
}
