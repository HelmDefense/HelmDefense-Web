<?php
namespace Module;

use Utils;

class PanelRedacModule extends Module {
	public function __construct() {
		parent::__construct(new PanelRedacController(), "Panel de rédaction");
	}

	/**
	 * @inheritDoc
	 */
	protected function execute() {
		$this->controller->verifyAccess();

		switch (Utils::get("action", "home")) {
		case "home":
			$this->controller->listPages(Utils::extra(0, "1"), Utils::extra(1, "15"));
			break;
		case "new":
			$data = Utils::postMany(array("check" => "invalid", "id", "title", "content", "published"), true);
			if ($data->check == "invalid")
				$this->controller->displayNewPage();
			else
				$this->controller->createNewPage($data->id, $data->title, $data->content, !is_null($data->published));
			break;
		case "edit":
			$page = Utils::extraRequired(0, "La page à éditer n'a pas été précisée");
			$data = Utils::postMany(array("check" => "invalid", "id", "title", "content", "published"), true);
			if ($data->check == "invalid")
				$this->controller->displayEditPage($page);
			else
				$this->controller->editPage($page, $data->id, $data->title, $data->content, !is_null($data->published));
			break;
		case "delete":
			$page = Utils::extraRequired(0, "La page à supprimer n'a pas été précisée");
			$this->controller->deletePage($page);
			break;
		default:
			Utils::error(404, "Action inconnue");
		}
	}
}
