<?php
namespace Component;

class MarkdownEditorComponent extends Component {
	private $element;
	private $defaultText;
	private $options;

	public function __construct($element = "textarea", $defaultText = null, $options = array()) {
		parent::__construct(new MarkdownEditorController());
		$this->element = $element;
		$this->defaultText = $defaultText;
		$this->options = $options;
	}

	protected function calculateRender() {
		$this->controller->generateEditor($this->element, $this->defaultText, $this->options);
	}
}
