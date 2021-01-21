<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "ForumController.php";

class ForumModule {
	private $controller;

	public function __construct() {
		$this->controller = new ForumController();

		$data = Utils::getMany(array("limit" => "10", "page" => "1"));
		switch (Utils::getRequired("action", "Not action specified")) {
		case "list":
			$type = Utils::get("type");
			if (is_null($type))
				$this->controller->types();
			else
				$this->controller->list($type, $data["limit"], $data["page"]);
			break;
		case "get":
			$this->controller->get(Utils::getRequired("type", "No type specified"), Utils::getRequired("id", "No id specified"), $data["limit"], $data["page"]);
			break;
		default:
			Utils::error(404, "Action not found");
		}
	}
}
