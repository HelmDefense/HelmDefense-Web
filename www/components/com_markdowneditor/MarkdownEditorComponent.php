<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "MarkdownEditorController.php";

class MarkdownEditorComponent extends Component {
	public function __construct($element = "textarea", $defaultText = null, $options = array()) {
		parent::__construct(new MarkdownEditorController($element, $defaultText, $options));
	}

	protected function calculateRender() {
		$this->controller->generateEditor();
	}
}
