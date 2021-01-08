<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "ForumController.php";

class ForumModule {
	private $controller;

	public function __construct() {
		$this->controller = new ForumController();

		switch (Utils::getRequired("action", "Not action specified")) {
		case "list":
			$this->controller->list(Utils::getRequired("type", "No type specified"), Utils::get("limit", "10"), Utils::get("offset", "0"));
			break;
		case "get":
			$this->controller->get(Utils::getRequired("type", "No type specified"), Utils::getRequired("id", "No id specified"));
			break;
		default:
			Utils::error(404, "Action not found");
		}
	}
}
