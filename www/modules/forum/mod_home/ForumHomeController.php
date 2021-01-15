<?php
namespace Module;

use Utils;

class ForumHomeController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ForumHomeModel(), new ForumHomeView());
	}

	public function postList($type) {
		switch ($type) {
		case "talk":
			$this->title = "Discussions";
			break;
		case "rate":
			$this->title = "Avis sur les entités";
			break;
		case "strat":
			$this->title = "Stratégies";
			break;
		default:
			Utils::error(404, "Type de post inconnu");
		}
		$this->view->postList($type);
	}

	public function home() {
		$this->view->homePage($this->model->homeText(), 3);
	}
}
