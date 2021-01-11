<?php
namespace Component;

class HeaderComponent extends Component {
	public function __construct() {
		parent::__construct(new HeaderController());
	}

	protected function calculateRender() {
		$this->controller->generateHeader();
	}
}
