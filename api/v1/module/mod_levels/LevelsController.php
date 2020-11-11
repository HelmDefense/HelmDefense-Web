<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "LevelsModel.php";
include_once "LevelsView.php";


class LevelsController
{
    private $model;
    private $view;
    private $action;

    public function __construct() {
        $this->model = new LevelsModel();
        $this->view = new LevelsView();
    }

    public function liste()
    {
        $this->view->afficheListe($this->model->liste());
    }

    public function get($id){

        $this->view->afficheLevel($this->model->level($id));
    }



    // function test() {
    //    $this->view->Levels($this->model->mod_levels());
    //}
}