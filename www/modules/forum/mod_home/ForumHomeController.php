<?php
namespace Module;

use Utils;

class ForumHomeController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ForumHomeModel(), new ForumHomeView());
		$this->setTitle(null);
	}

	public function postList($type) {
		switch ($type) {
		case "talk":
			$this->setTitle("Discussions");
			break;
		case "rate":
			$this->setTitle("Avis sur les entités");
			break;
		case "strat":
			$this->setTitle("Stratégies");
			break;
		default:
			Utils::error(404, "Type de post inconnu");
		}
		$this->view->postList($type);
	}

	public function home() {
		$this->view->homePage($this->model->homeText(), 3);
	}

	private function setTitle($title) {
		$this->title = (is_null($title) ? "" : "$title - ") . "Forum";
	}
}
