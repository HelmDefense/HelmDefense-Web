<?php
namespace Component;

class ForumSidebarComponent extends Component {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ForumSidebarController());
	}

	/**
	 * @inheritDoc
	 */
	protected function calculateRender() {
		$this->controller->generateSidebar();
	}
}
