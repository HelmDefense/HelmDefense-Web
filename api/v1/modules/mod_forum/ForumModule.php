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
			$data = Utils::getMany(array("type", "limit" => "10", "page" => "1"));
			if (is_null($data["type"]))
				$this->controller->types();
			else
				$this->controller->list($data["type"], $data["limit"], $data["page"]);
			break;
		case "get":
			$this->controller->get(Utils::getRequired("type", "No type specified"), Utils::getRequired("id", "No id specified"));
			break;
		default:
			Utils::error(404, "Action not found");
		}
	}
}
