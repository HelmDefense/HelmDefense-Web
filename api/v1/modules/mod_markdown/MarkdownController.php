<?php
include_once "include/check_include.php";
include_once "MarkdownModel.php";
include_once "MarkdownView.php";

class MarkdownController {
	private $model;
	private $view;

	public function __construct() {
		$this->model = new MarkdownModel();
		$this->view = new MarkdownView();
	}

	public function markdown($text) {
		$this->view->markdown($this->model->parseMarkdown($text));
	}
}
