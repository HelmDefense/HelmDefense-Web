<?php
namespace Module;

class PanelHomeModule extends Module {
	public function __construct() {
		parent::__construct(new PanelHomeController(), "Panel de contrôle");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$this->controller->panel();
	}
}
