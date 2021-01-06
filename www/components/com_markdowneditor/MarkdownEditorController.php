<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "MarkdownEditorModel.php";
include_once "MarkdownEditorView.php";

class MarkdownEditorController extends Controller {
	private $element;
	private $defaultText;
	private $options;

	public function __construct($element, $defaultText, $options) {
		parent::__construct(new MarkdownEditorModel(), new MarkdownEditorView());
		$this->element = $element;
		$this->defaultText = $defaultText;
		$this->options = $options;
	}

	public function generateEditor() {
		$this->view->displayEditor($this->element, $this->model->editorConfig($this->defaultText, $this->options));
	}
}
