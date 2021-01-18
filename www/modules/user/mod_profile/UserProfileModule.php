<?php
namespace Module;

use Utils;

class UserProfileModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new UserProfileController(), "Profil");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$request = Utils::get("module", "home");

		switch ($request) {
		case "settings":
			$action = Utils::get("action", "settings");
			switch ($action) {
			case "settings":
				$data = Utils::postMany(array("check" => "invalid", "name", "email", "oldpassword", "newpassword", "newpasswordconfirm", "description"), true);
				if ($data->check == "invalid")
					$this->controller->displaySettingsUser();
				else
					$this->controller->modifySettings($data->name, $data->email, $data->oldpassword, $data->newpassword, $data->newpasswordconfirm, $data->description);
				break;
			case "delete":
				$this->controller->deleteAccount(Utils::postRequired("password"));
				break;
			case "avatar":
				$this->controller->modifyAvatar(Utils::filesRequired("avatar"));
				break;
			default:
				Utils::error(404, "Action inconnue");
			}
			break;
		/* @noinspection PhpMissingBreakStatementInspection */
		case "home":
			$this->controller->correctUrl();
			// no break
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
