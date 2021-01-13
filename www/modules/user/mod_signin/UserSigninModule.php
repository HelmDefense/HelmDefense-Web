<?php
namespace Module;

use Utils;

include_once "modules/generic/Module.php";
include_once "UserSigninController.php";

class UserSigninModule extends Module {
	public function __construct(){
		parent::__construct(new UserSigninController());
	}

	protected function execute(){

		$data = Utils::postMany(array("name","password","email","check" => "invalid"));
		if ($data->check == "invalid")
			$this->controller->signinPage();
		else if (is_null($data->name))
			$this->controller->signinPage(3);
		else if (is_null($data->password))
			$this->controller->signinPage(4);
		else if (is_null($data->email))
			$this->controller->signinPage(5);
		else
			$this->controller->signin($data->user, $data->password, $data->email);
	}
}