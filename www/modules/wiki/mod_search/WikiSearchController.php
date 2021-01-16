<?php
namespace Module;

use Utils;

class WikiSearchController extends Controller {
	public function __construct() {
		parent::__construct(new WikiSearchModel(), new WikiSearchView());
	}

	public function generateSearchPage() {
		$this->title = "Recherche";
		$this->view->searchPage();
	}

	public function generateSearchResultPage($search, $type) {
		if (strlen($search) < 3)
			Utils::error(400, "Le terme recherché doit faire au minimum 3 caractères");
		$result = $this->model->search($search, $type);
		if (is_null($result))
			Utils::error(404, "Le type de recherche est invalide");
		$this->title = "Résultat de recherche \"$search\" (" . $this->view->displayType($type) . ")";
		$this->view->resultPage($result, $search, $type);
	}
}
