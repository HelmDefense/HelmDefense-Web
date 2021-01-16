<?php
namespace Component;

class FooterComponent extends Component {
	public function __construct() {
		parent::__construct(new FooterController());
	}

	protected function calculateRender() {
		$this->controller->generateFooter();
	}
}
