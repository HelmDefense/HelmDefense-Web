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
		$this->title = "Résultat de recherche \"$search\" (" . $this->view->displayType($type) . ")";
		$result = $this->model->search($search, $type);
		$this->view->resultPage($result, $search, $type);
	}
}
