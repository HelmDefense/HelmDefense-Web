<?php
namespace Component;

include_once "components/generic/Component.php";
include_once "WikiSidebarController.php";

class WikiSidebarComponent extends Component {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiSidebarController());
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		$this->controller->generateSidebar();
	}
}
