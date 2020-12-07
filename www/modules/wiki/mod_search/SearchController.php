<?php
namespace Module;

include_once "modules/generic/Controller.php";
include_once "SearchModel.php";
include_once "SearchView.php";

class SearchController extends Controller {

	public function __construct() {
		parent::__construct(new SearchModel(), new SearchView());
		$this->title = "Résultat de recherche";
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return "<link rel='stylesheet' href='/data/css/wiki.css' />";
	}

	public function generateSearchPage() {
		$this->view->searchPage();
	}

	public function generateSearchResultPage($search, $typeSearch) {
		$result = $this->model->search($search, $typeSearch);
		$this->view->resultPage($result, $search, $typeSearch);
	}
}