<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "UsersController.php";

class UsersModule {
	private $controller;

	public function __construct() {
		$this->controller = new UsersController();

		$action = Utils::get("action");

		switch ($action) {
			case "get":
				$id = Utils::get("id");
				if(is_null($id)) {
					Utils::error(404, "user not found");
				}
				$this->controller->get($id);
				break;

			case "auth":
				$id = Utils::get("id");
				$passwd = Utils::post("password");
				if(is_null($id)) {
					Utils::error(404, "user not found");
				}
				if(is_null($passwd)) {
					Utils::error(400, "no password given");
				}
				$this->controller->auth($id, $passwd);
				break;

			default:
				Utils::error(404, "action not found");
		}
	}
}
