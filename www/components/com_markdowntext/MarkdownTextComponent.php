<?php
namespace Component;

class MarkdownTextComponent extends Component {
	private $text;
	private $inverted;

	public function __construct($text = "No text in MarkdownTextComponent", $inverted = false) {
		parent::__construct(new MarkdownTextController());
		$this->text = $text;
		$this->inverted = $inverted;
	}

	protected function calculateRender() {
		$this->controller->generateMarkdown($this->text, $this->inverted);
	}
}
