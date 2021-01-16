<?php
namespace Component;

class MarkdownEditorController extends Controller {
	public function __construct() {
		parent::__construct(new MarkdownEditorModel(), new MarkdownEditorView());
	}

	public function generateEditor($element, $defaultText, $options) {
		$this->view->displayEditor($element, $this->model->editorConfig($defaultText, $options));
	}
}
