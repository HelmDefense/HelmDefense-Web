<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "HeaderController.php";

class HeaderComponent extends Component {
	public function __construct() {
		parent::__construct(new HeaderController());
	}

	protected function calculateRender() {
		$this->controller->generateHeader();
	}
}
