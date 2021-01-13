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

		$data = Utils::postMany(array("id","password","email","passwordConfirm","check" => "invalid"), true);
		if ($data->check == "invalid")
			$this->controller->signinPage();
		else if (is_null($data->id))
			$this->controller->signinPage(3);
		else if (is_null($data->password))
			$this->controller->signinPage(4);
		else if (is_null($data->email))
			$this->controller->signinPage(5);
		else if (is_null($data->passwordConfirm))
			$this->controller->signinPage(6);
		else if ($data->password != $data->passwordConfirm)
			$this->controller->signinPage(7);
		else
			$this->controller->signin($data->id, $data->password, $data->email);
	}
}