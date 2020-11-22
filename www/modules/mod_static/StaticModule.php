<?php
namespace Module;

use Utils;

include_once "modules/generic/Module.php";
include_once "StaticController.php";

class StaticModule extends Module {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new StaticController());
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		$this->controller->loadPage(Utils::get("page", "home"));
	}
}
