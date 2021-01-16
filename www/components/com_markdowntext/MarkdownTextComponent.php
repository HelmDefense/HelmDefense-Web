<?php
namespace Component;

class MarkdownTextComponent extends Component {
	private $text;

	public function __construct($text = "No text in MarkdownTextComponent") {
		parent::__construct(new MarkdownTextController());
		$this->text = $text;
	}

	protected function calculateRender() {
		$this->controller->generateMarkdown($this->text);
	}
}
