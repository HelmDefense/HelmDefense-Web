<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class UserProfileModel extends Model {
	
	function searchInfo() {
		return Utils::loggedInUser();
	}
}