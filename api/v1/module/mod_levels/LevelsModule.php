<?php
include_once "include/check_include.php";
include_once "LevelsController.php";
include_once "include/Utils.php";


class LevelsModule {
    private $controller;

    public function __construct() {
        $this->controller = new LevelsController();

        $action=Utils::get("action");
        if(empty($action)){
            Utils::error(404,'Information manquante');
        }

        switch($action){
            case "list":
                $this->controller->liste();
                break;
            case "get":
                $id = Utils::get("id");
                if (empty($id)){
                    Utils::error(404,'Information Manquante');
                }
                else{
                    $this->controller->get($id);
                }
                break;
            default;
                Utils::error(404, 'Information incorrecte');
                break;
        }
    }
}