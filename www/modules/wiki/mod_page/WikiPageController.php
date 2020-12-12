<?php
namespace Module;

use Utils;

include_once "WikiPageModel.php";
include_once "WikiPageView.php";
include_once "modules/generic/Controller.php";

class WikiPageController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiPageModel(), new WikiPageView());
		$this->title = "Wiki";
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return "<link rel='stylesheet' href='/data/css/wiki.css' />";
	}

	public function page($action){
		$this->view->classicPage($this->model->getClassicPage($action));
	}

	public function entityPage($entity){
		$this->view->entityPage($this->model->getEntityPage($entity));
	}

	public function levelPage($page) {
		echo "Niveau $page";
	}
}
