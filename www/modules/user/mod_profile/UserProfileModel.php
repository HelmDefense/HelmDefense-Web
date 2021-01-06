<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class UserProfileModel extends Model {
	function searchInfo($info, $idUser) {
		$sql = "SELECT :info FROM hd_user_users WHERE id = :idUser";
		return Utils::executeRequest(self::$bdd, $sql, array("info" => $info, "idUser" => $idUser), false);
	}
}