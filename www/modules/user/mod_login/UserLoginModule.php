<?php
namespace Module;

use Utils;

include_once "modules/generic/Module.php";
include_once "UserLoginController.php";

class UserLoginModule extends Module {

	public function __construct(){
		parent::__construct(new UserLoginController());
	}

	protected function execute(){

	}
}