<?php

include_once "modules/generic/Module.php";
include_once "SearchController.php";

class SearchModule extends Module {

	public function __construct() {
		parent::__construct(new SearchController());
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		$check = Utils::post("check");
		if(is_null($check)) {
			$this->controller->generateSearchPage();
		}
		else {
			$this->controller->generateSearchResultPage(Utils::post("search"), Utils::post("typeSearch"));
		}
	}
}