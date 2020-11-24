<?php
namespace Module;

use Utils;

include_once "WikiPageController.php";
include_once "modules/generic/Module.php";

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
		$action = Utils::get("action");

		switch ($action) {
			case "entity":
				$this->controller->entityPage();
				break;
			case "level":
				$this->controller->levelPage();
				break;
			case null: // Temporary home page
				$this->controller->homePage();
				break;
			default:
				$this->controller->page();
		}
	}
}
