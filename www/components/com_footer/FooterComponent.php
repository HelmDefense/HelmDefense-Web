<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "FooterController.php";

class FooterComponent extends Component {
	public function __construct() {
		parent::__construct(new FooterController());
	}

	protected function calculateRender() {
		$this->controller->generateFooter();
	}
}
