<?php
namespace Module;

include_once "modules/generic/Controller.php";
include_once "SearchModel.php";
include_once "SearchView.php";

class SearchController extends Controller {
	public function __construct() {
		parent::__construct(new SearchModel(), new SearchView());
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return "<link rel='stylesheet' href='/data/css/wiki.css' />";
	}

	public function generateSearchPage() {
		$this->title = "Recherche";
		$this->view->searchPage();
	}

	public function generateSearchResultPage($search, $type) {
		$this->title = "Résultat de recherche";
		$result = $this->model->search($search, $type);
		$this->view->resultPage($result, $search, $type);
	}
}
