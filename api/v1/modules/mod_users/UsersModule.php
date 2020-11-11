<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "UsersController.php";

class UsersModule {
	private $controller;

	public function __construct() {
		$this->controller = new UsersController();

		switch (Utils::getRequired("action", "Not action specified")) {
			case "get":
				$this->controller->get(Utils::getRequired("id", "No id specified"));
				break;
			case "auth":
				$this->controller->auth(Utils::getRequired("id", "No id specified"), Utils::postRequired("password", "No password specified"));
				break;
			default:
				Utils::error(404, "Action not found");
		}
	}
}
