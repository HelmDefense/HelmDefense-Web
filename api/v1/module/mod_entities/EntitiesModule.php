<?php
include_once "include/check_include.php";
include_once "EntitiesController.php";

class EntitiesModule {
	private $controller;

	public function __construct() {
		$this->controller = new EntitiesController();

		$action = Utils::get("action");
		if(is_null($action))
		    Utils::error(404, "action not found");

		switch ($action){
            case "list":
                $this->controller->list();
                break;

            case "get":
                $this->controller->get(Utils::get("id"));
                break;

            case "stat":
                $this->controller->stat();
                break;
        }

	}
}
