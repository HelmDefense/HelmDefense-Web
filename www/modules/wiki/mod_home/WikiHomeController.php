<?php
namespace Module;

include_once "WikiHomeModel.php";
include_once "WikiHomeView.php";
include_once "modules/generic/Controller.php";

class WikiHomeController extends Controller {
	private $title;

	public function __construct() {
		parent::__construct(new WikiHomeModel(), new WikiHomeView());
	}

	public function pageList($type) {
		$this->title = $type == "entity" ? "Entités" : "Niveaux";
		echo "$type";
	}

	public function home() {
		$this->title = null;
		$this->view->homePage($this->model->recentPages(), $this->model->entities(), $this->model->levels());
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return "<link rel='stylesheet' href='/data/css/wiki.css' />";
	}

	/**
	 * @inheritDoc
	 */
	public function getTitle() {
		return (is_null($this->title) ? "" : "$this->title - ") . "Wiki";
	}
}
