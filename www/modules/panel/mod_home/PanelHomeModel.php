<?php
namespace Module;

use Utils;

class PanelHomeModel extends Model {
	public function ranks() {
		$user = Utils::loggedInUser();
		return is_null($user) ? false : $user->ranks;
	}
}
