<?php
include_once "include/check_include.php";
include_once "TestController.php";

class TestModule {
	private $controller;

	public function __construct() {
		$this->controller = new TestController();

		$this->controller->test();
	}
}
