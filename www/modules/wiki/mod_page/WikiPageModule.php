<?php
namespace Module;

use Utils;

class WikiPageModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiPageController());
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$action = Utils::getRequired("action");

		switch ($action) {
		case "entity":
			$this->controller->entityPage(Utils::extraRequired(0));
			break;
		case "level":
			$this->controller->levelPage(Utils::extraRequired(0));
			break;
		default:
			$this->controller->page($action);
		}
	}
}
