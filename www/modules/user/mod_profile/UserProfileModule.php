<?php
namespace Module;

use Utils;

include_once "UserProfileController.php";
include_once "modules/generic/Module.php";

class UserProfileModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new UserProfileController());
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$request = Utils::get("module", "profile");
		$action = Utils::get("action");

		if(is_null($action)) {
			$this->controller->displayProfileUser(false);
		}
		else {
			$loggedInUser = Utils::session("login");
			if (is_null($loggedInUser))
				Utils::error(404);

			$user = Utils::httpGetRequest("v1/users/$loggedInUser");
			if(Utils::isError($user))
				Utils::error(404);
			else
				$this->controller->displayProfileUser(false);
		}

		switch ($request) {
			case "settings":
				$this->controller->displaySettingsUser();
				break;
			case "profile":
			default:
				$this->controller->displayProfileUser(false);
				break;
		}
	}
}