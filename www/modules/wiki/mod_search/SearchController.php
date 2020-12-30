<?php
namespace Module;

use Utils;

include_once "modules/generic/Controller.php";
include_once "SearchModel.php";
include_once "SearchView.php";

class SearchController extends Controller {
	public function __construct() {
		parent::__construct(new SearchModel(), new SearchView());
	}

	public function generateSearchPage() {
		$this->title = "Recherche";
		$this->view->searchPage();
	}

	public function generateSearchResultPage($search, $type) {
		if (strlen($search) < 3)
			Utils::error(400, "Le terme recherché doit faire au minimum 3 caractères");
		$this->title = "Résultat de recherche \"$search\" (" . $this->view->displayType($type) . ")";
		$result = $this->model->search($search, $type);
		$this->view->resultPage($result, $search, $type);
	}
}
