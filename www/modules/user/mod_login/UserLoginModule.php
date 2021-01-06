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
		$this->controller->loginPage();
	}
}