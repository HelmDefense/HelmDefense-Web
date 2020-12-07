<?php
namespace Component;

use Utils;

include_once "components/generic/Model.php";

class HeaderModel extends Model {
	public function currentActiveNav() {
		$url = $_SERVER["REQUEST_URI"];
		$page = explode("/", $url)[1];
		return empty($page) ? "home" : $page;
	}

	public function loggedInUser() {
		$loggedInUser = Utils::session("login");
		if (is_null($loggedInUser))
			return null;

		$user = Utils::httpGetRequest("v1/users/$loggedInUser");
		$user->avatar = Utils::SITE_URL . "data/img/avatar/indyteo.png";
		return property_exists($user, "id") ? $user : null;
	}
}
