<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "MarkdownTextModel.php";
include_once "MarkdownTextView.php";

class MarkdownTextController extends Controller {
	private $text;

	public function __construct($text) {
		parent::__construct(new MarkdownTextModel(), new MarkdownTextView());
		$this->text = $text;
	}

	public function generateMarkdown() {
		$this->view->generateMarkdown($this->text);
	}
}
