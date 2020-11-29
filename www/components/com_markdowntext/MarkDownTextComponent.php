<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "MarkDownTextController.php";

class MarkDownTextComponent extends Component {
	public function __construct($data = "Empty text in MarkDownComponent") {
		parent::__construct(new MarkDownTextController($data));
	}

	protected function calculateRender() {
		$this->controller->generateMarkDown();
	}
}
