<?php
namespace Component;

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
