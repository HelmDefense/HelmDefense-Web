<?php
namespace Component;

include_once "components/generic/Model.php";

class HeaderModel extends Model {
	public function currentActiveNav() {
		return "";
	}

	public function loggedInUsername() {
		return "indyteo";
	}

	public function panelAccess($username) {
		$user = json_decode(file_get_contents("https://api.helmdefense.theoszanto.fr/v1/users/$username", false, stream_context_create(array(
				"http" => array(
						"ignore_errors" => true
				)
		))));
		return property_exists($user, "ranks") ? $user->ranks : array();
	}
}
