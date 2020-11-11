<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "LevelsController.php";

class LevelsModule {
    private $controller;

    public function __construct() {
        $this->controller = new LevelsController();

        switch (Utils::getRequired("action", "No action specified")) {
            case "list":
                $this->controller->list();
                break;
            case "get":
                $this->controller->get(Utils::getRequired("id", "No id specified"));
                break;
            default;
	            Utils::error(404, "Action not found");
        }
    }
}
