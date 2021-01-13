<?php
namespace Module;

use Utils;

include_once "modules/generic/Module.php";
include_once "UserSigninController.php";

class UserSigninModule extends Module {
	public function __construct(){
		parent::__construct(new UserSigninController());
	}

	protected function execute()
	{
		$this->controller->signinPage();
	}
}