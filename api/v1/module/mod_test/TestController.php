<?php
include_once "include/check_include.php";
include_once "TestModel.php";
include_once "TestView.php";

class TestController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new LevelsModel();
		$this->view = new TestView();
	}

	public function test() {
		$this->view->test($this->model->test());
	}
}
