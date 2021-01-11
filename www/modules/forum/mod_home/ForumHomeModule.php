<?php
namespace Module;

use Utils;

class ForumHomeModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ForumHomeController());
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$request = Utils::get("module", "home");

		switch ($request) {
		case "talk":
		case "rate":
		case "strat":
			$this->controller->postList($request);
			break;
		default:
			$this->controller->home();
			break;
		}
	}
}
