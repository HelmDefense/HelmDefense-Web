<?php
namespace Module;

use Utils;

class PanelModoModule extends Module {
	public function __construct() {
		parent::__construct(new PanelModoController(), "Panel de modération");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$this->controller->verifyAccess();

		switch (Utils::get("action", "home")) {
		case "home":
			$this->controller->listUsers(Utils::extra(0, "1"), Utils::extra(1, "15"));
			break;
		case "warn":
			$this->controller->warn(Utils::extraRequired(0), Utils::postRequired("reason"));
			break;
		case "ban":
			$this->controller->ban(Utils::extraRequired(0), Utils::postRequired("reason"));
			break;
		default:
			Utils::error(404, "Action inconnue");
		}
	}
}
