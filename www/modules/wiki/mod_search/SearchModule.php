<?php
namespace Module;

use Utils;

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
		$typeSearch = Utils::post("typeSearch");
		if(is_null($check) and is_null($typeSearch)) {
			$this->controller->generateSearchPage();
		}
		else {
			$this->controller->generateSearchResultPage(Utils::post("search"), $typeSearch);
		}
	}
}