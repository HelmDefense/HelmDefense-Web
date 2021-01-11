<?php
namespace Component;

class MarkdownTextController extends Controller {
	public function __construct() {
		parent::__construct(new MarkdownTextModel(), new MarkdownTextView());
	}

	public function generateMarkdown($text) {
		$this->view->displayMarkdown($this->model->parseMarkdown($text));
	}
}
