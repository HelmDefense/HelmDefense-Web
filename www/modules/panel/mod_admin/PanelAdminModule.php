<?php
namespace Module;

Use Utils;

class PanelAdminModule extends Module {
	public function __construct() {
		parent::__construct(new PanelAdminController(), "Panel d'administration");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$this->controller->verifyAccess();

		switch (Utils::get("action", "home")) {
		case "home":
			$this->controller->list(Utils::extra(0, "1"), Utils::extra(1, "15"));
			break;
		case "edit":
			$id = Utils::extraRequired(0, "L'utilisateur à éditer n'a pas été précisé");
			$data = Utils::postMany(array("check" => "invalid", "login", "admin", "dev", "modo", "redac"), true);
			if ($data->check == "invalid")
				$this->controller->displayProfileRole($id);
			else
				$this->controller->editRole($id, $data->login, $data->admin, $data->dev, $data->modo, $data->redac);
			break;
		default:
			Utils::error(404, "Action inconnue");
		}
	}
}