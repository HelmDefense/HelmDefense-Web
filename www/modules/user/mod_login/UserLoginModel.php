<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class UserLoginModel extends Model {
	public function userConnect($name, $password){
		$user = Utils::httpPostRequest("v1/user/auth/$name",array($password));
		return $user;
	}
}