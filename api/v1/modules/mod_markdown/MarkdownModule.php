<?php
include_once "include/check_include.php";
include_once "include/Utils.php";
include_once "MarkdownController.php";

class MarkdownModule {
	private $controller;

	public function __construct() {
		$this->controller = new MarkdownController();

		$this->controller->markdown(Utils::postRequired("text", "No text specified"));
	}
}
