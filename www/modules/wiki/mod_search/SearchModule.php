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
		$type = Utils::get("action");
		if (is_null($type))
			$this->controller->generateSearchPage();
		else
			$this->controller->generateSearchResultPage(strtr(Utils::get("extra"), array("%2F" => "/", "%5C" => "\\")), $type);
	}
}
