<?php
namespace Module;

use Utils;

include_once "modules/generic/Module.php";
include_once "UserLoginController.php";

class UserLoginModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct(){
		parent::__construct(new UserLoginController());
	}

	/**
	 * @inheritDoc
	 */
	protected function execute(){
		$request = Utils::get("module", "login");

		if ($request == "logout") {
			$this->controller->logout();
		} else {
			$data = Utils::postMany(array("user", "password", "check" => "invalid"), true);
			if ($data->check == "invalid")
				$this->controller->loginPage();
			else if (is_null($data->user))
				$this->controller->loginPage(3);
			else if (is_null($data->password))
				$this->controller->loginPage(4);
			else
				$this->controller->login($data->user, $data->password);
		}
	}
}
