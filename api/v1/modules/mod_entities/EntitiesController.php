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

	public function list() {
        $this->view->list($this->model->list());
    }

    public function get($id) {
	    $this->view->get($this->model->get($id));
    }

    public function stat($id, $stat) {
	    $this->view->stat($this->model->stat($id, $stat));
    }
}
