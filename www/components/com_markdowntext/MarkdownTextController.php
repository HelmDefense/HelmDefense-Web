<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "MarkdownTextModel.php";
include_once "MarkdownTextView.php";

class MarkdownTextController extends Controller {
	public function __construct() {
		parent::__construct(new MarkdownTextModel(), new MarkdownTextView());
	}

	public function generateMarkdown($text) {
		$this->view->displayMarkdown($this->model->parseMarkdown($text));
	}
}
