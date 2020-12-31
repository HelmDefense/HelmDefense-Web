<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "MarkdownTextController.php";

class MarkdownTextComponent extends Component {
	public function __construct($data = "Empty text in MarkdownTextComponent") {
		parent::__construct(new MarkdownTextController($data));
	}

	protected function calculateRender() {
		$this->controller->generateMarkdown();
	}
}
