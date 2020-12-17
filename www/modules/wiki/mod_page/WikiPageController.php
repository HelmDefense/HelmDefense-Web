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
		$this->setTitle(null);
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return "<link rel='stylesheet' href='/data/css/wiki.css' />";
	}

	public function page($id) {
		$page = $this->model->getClassicPage($id);
		if (!$page)
			Utils::error(404, "La page Wiki \"" . htmlspecialchars($id) . "\" que vous cherchez n'a pas été trouvée");
		else if (!$page->published) {
			$user = Utils::loggedInUser();
			if (is_null($user) || !in_array("redactor", $user->ranks))
				Utils::error(401, "Vous n'avez pas accès à cette page Wiki ! Connectez-vous avec un compte ayant des accès de rédacteur pour voir la page \"" . htmlspecialchars($id) . "\"");
		}
		$this->setTitle($page->title);
		$this->view->classicPage($page);
	}

	public function entityPage($entity) {
		$entity = $this->model->getEntityPage($entity);
		$this->setTitle($entity->name);
		$this->view->entityPage($entity);
	}

	public function levelPage($page) {
		echo "Niveau $page";
	}

	private function setTitle($title) {
		$this->title = (is_null($title) ? "" : "$title - ") . "Wiki";
	}
}
