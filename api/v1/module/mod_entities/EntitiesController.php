<?php
include_once "include/check_include.php";
include_once "EntitiesModel.php";
include_once "EntitiesView.php";

class EntitiesController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new EntitiesModel();
		$this->view = new EntitiesView();
	}

	public function list(){
        $this->view->list($this->model->list());
    }

    public function get(){

    }

    public function stat(){

    }




	public function test() {
		$this->view->test($this->model->test());
	}
}
