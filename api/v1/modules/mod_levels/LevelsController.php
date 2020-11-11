<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "LevelsModel.php";
include_once "LevelsView.php";

class LevelsController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new LevelsModel();
        $this->view = new LevelsView();
    }

    public function list() {
        $this->view->list($this->model->list());
    }

    public function get($id) {
        $this->view->get($this->model->get($id));
    }
}
