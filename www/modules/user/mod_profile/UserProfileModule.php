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

		switch ($request) {
			case "settings":
				echo "settings";
				break;
			case "profile":
			default:
				$this->controller->displayProfileUser(false);
				break;
		}
	}
}