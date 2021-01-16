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
		$request = Utils::get("module", "home");

		switch ($request) {
		case "settings":
			$data = Utils::postMany(array("check" => "invalid", "name", "email", "password", "description"), true);
			if ($data->check == "invalid")
				$this->controller->displaySettingsUser();
			else
				$this->controller->modifySettings($data->name, $data->email, $data->password, $data->description);
			break;
		case "home":
			$this->controller->correctUrl();
		case "profile":
			$action = Utils::get("action");
			if (is_null($action)) {
				$this->controller->displayProfileUser();
			} else {
				$user = Utils::httpGetRequest("v1/users/$action");
				if (Utils::isError($user))
					Utils::error(404, "Utilisateur inconnu");
				else
					$this->controller->displayProfileUser($user);
			}
			break;
		default:
			Utils::error(404, "Action inconnue");
		}
	}
}
