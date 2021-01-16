<?php
namespace Module;

use PDO;
use Utils;

include_once "modules/generic/Model.php";

class UserSigninModel extends Model{
/*
 * generer un code 32 caratère + insertion du code dans la BD + envoie par mail !
 * */
	public function resetPasswordRequest($login, $password){
		$data = Utils::executeRequest(self::$bdd, "SELECT id, email from hd_user_users where login = :login", array("login" => $login), false);
		if (!is_null($data->email)) {
			$code = Utils::randomString(32);
			Utils::executeRequest(self::$bdd,"INSERT INTO hd_user_password_reset (user, code, reset_password) VALUES (:id, :code, :password)",array("id" => $data->id, "password" => password_hash($password,PASSWORD_DEFAULT), "code" => $code));
			if (mail($data->email, "Mot de passe perdu - HelmDefense", "Bonjour,\r\nVous avez récemment perdu votre mot de passe ? Si oui rendez-vous à cette adresse pour valider le changement de mot de passe : " . Utils::SITE_URL . "user/signin/resetpassword/.$code\r\nSi non ignorez ce mail"))
				return $data->email;
		}
		return null;
	}

	public function resetPassword($code){
		$result = Utils::executeRequest(self::$bdd,"SELECT * from hd_user_password_reset where code = :code",array("code" => $code),false);
		if (!is_null($result)){
			Utils::executeRequest(self::$bdd,"UPDATE hd_user_users SET password = :password WHERE login = :login",array("password" => $result->reset_password, "login" => $result->user));
		}
	}

	public function userSignin($login, $name, $password, $email) {
		$result = Utils::executeRequest(self::$bdd, "SELECT count(1) from hd_user_users where login = :login OR email = :email", array("login" => $login, "email" => $email), false, PDO::FETCH_COLUMN);
		if ($result)
			return 1;
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_user_users (login, password, email, name, description) VALUES (:login, :password, :email, :name, :description)", array("login" => $login, "password" => password_hash($password, PASSWORD_DEFAULT), "email" => $email, "name" => $name, "description" => "Je suis la description par defaut. N'hésitez pas à me modifier !"));
		$_SESSION["login"] = $login;
		mail($email, "Nouveau compte HelmDefense", "Bonjour $name\r\n"."Nous vous confirmons la création de votre compte !", "From: HelmDefense <no-reply@helmdefense.theoszanto.fr>");
		return 0;
	}
}
