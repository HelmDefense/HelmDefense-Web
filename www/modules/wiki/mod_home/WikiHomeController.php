<?php
namespace Module;

class WikiHomeController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiHomeModel(), new WikiHomeView());
	}

	public function pageList($type) {
		if ($type == "entity") {
			$this->title = "Entités";
			$pages = $this->model->entities();
		} else {
			$this->title = "Niveaux";
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
}
