<?php
include_once "include/check_include.php";
include_once "EntitiesController.php";

class EntitiesModule {
	private $controller;

	public function __construct() {
		$this->controller = new EntitiesController();

		switch (Utils::getRequired("action", "No action specified")) {
			case "list":
			    $this->controller->list();
			    break;
			case "get":
			    $this->controller->get(Utils::getRequired("id", "No id specified"));
			    break;
			case "stat":
			    $this->controller->stat(Utils::getRequired("id", "No id specified"), Utils::getRequired("stat", "No stat specified"));
			    break;
			default:
				Utils::error(404, "Action not found");
        }
	}
}
