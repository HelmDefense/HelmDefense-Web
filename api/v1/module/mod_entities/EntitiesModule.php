<?php
include_once "include/check_include.php";
include_once "EntitiesController.php";

class EntitiesModule {
	private $controller;

	public function __construct() {
		$this->controller = new EntitiesController();

		switch (Utils::get("action")) {
			case "list":
			    $this->controller->list();
			    break;
			case "get":
				$id = Utils::get("id");
				if (is_null($id))
					Utils::error(400, "No id specified");

			    $this->controller->get($id);
			    break;
			case "stat":
				$id = Utils::get("id");
				if (is_null($id))
					Utils::error(400, "No id specified");
				$stat = Utils::get("stat");
				if (is_null($stat))
					Utils::error(400, "No stat specified");

			    $this->controller->stat($id, $stat);
			    break;
			default:
				Utils::error(404, "Action not found");
        }
	}
}
