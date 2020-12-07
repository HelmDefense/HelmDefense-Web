<?php
namespace Module;

use Utils;

include_once "WikiHomeController.php";
include_once "modules/generic/Module.php";

class WikiHomeModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiHomeController());
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$request = Utils::get("module", "home");

		switch ($request) {
		case "entity":
		case "level":
			$this->controller->pageList($request);
			break;
		default:
			$this->controller->home();
			break;
		}
	}
}