<?php
include_once "include/check_include.php";
include_once "UsersModel.php";
include_once "UsersView.php";

class UsersController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new UsersModel();
		$this->view = new UsersView();
	}

	public function get($id) {
		$this->view->get($this->model->get($id));
	}

	public function auth($id, $passwd) {
		$this->view->auth($this->model->auth($id, $passwd));
	}
}
