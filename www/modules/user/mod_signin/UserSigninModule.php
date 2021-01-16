<?php
namespace Module;

use Utils;

include_once "modules/generic/Module.php";
include_once "UserSigninController.php";

class UserSigninModule extends Module {
	public function __construct() {
		parent::__construct(new UserSigninController());
	}

	protected function execute() {
		$action = Utils::get("action", "signin");
		switch ($action) {
		case "resetpassword":
			$code = Utils::extra(0);
			if (is_null($code)) {
				$data = Utils::postMany(array("check" => "invalid", "id", "password", "passwordconfirm"), true);
				if ($data->check == "invalid")
					$this->controller->resetPasswordPage();
				else
					$this->controller->resetPasswordRequest($data->id, $data->password, $data->passwordconfirm);
			} else
				$this->controller->resetPassword($code);
			break;
		case "signin":
			$data = Utils::postMany(array("id", "name", "password", "email", "passwordconfirm", "check" => "invalid"), true);
			if ($data->check == "invalid")
				$this->controller->signinPage();
			else
				$this->controller->signin($data->id, $data->name, $data->password, $data->email, $data->passwordconfirm);
			break;
		}
	}
}
