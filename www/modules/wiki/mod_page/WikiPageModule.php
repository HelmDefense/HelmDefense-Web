<?php
namespace Module;

use Utils;

include_once "WikiPageController.php";
include_once "modules/generic/Module.php";

class WikiPageModule extends Module {

	public function __construct() {
		parent::__construct(new WikiPageController());
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$action = Utils::get("action");

		switch ($action){
			case "entity":
				$this->controller->entityPage();

			case "level":

			case null:
				$this->controller->homePage();

			default:
		}

	}
}