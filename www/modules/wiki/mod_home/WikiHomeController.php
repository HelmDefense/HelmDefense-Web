<?php
namespace Module;

include_once "WikiHomeModel.php";
include_once "WikiHomeView.php";
include_once "modules/generic/Controller.php";

class WikiHomeController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiHomeModel(), new WikiHomeView());
		$this->setTitle(null);
	}

	public function pageList($type) {
		if ($type == "entity") {
			$this->setTitle("Entités");
			$pages = $this->model->entities();
		} else {
			$this->setTitle("Niveaux");
			$pages = $this->model->levels();
		}
		$this->view->pageList($pages, $type);
	}

	public function home() {
		$this->view->homePage(
				$this->model->homeText(),
				$this->model->recentPages(8),
				$this->model->entities(4),
				$this->model->levels(4)
		);
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return "<link rel='stylesheet' href='/data/css/wiki.css' />";
	}

	private function setTitle($title) {
		$this->title = (is_null($title) ? "" : "$title - ") . "Wiki";
	}
}
