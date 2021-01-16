<?php
namespace Module;

use Utils;

class WikiPageController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiPageModel(), new WikiPageView());
	}

	public function page($id) {
		$page = $this->model->getClassicPage($id);
		if (!$page)
			Utils::error(404, "La page Wiki \"" . htmlspecialchars($id) . "\" que vous cherchez n'a pas été trouvée");
		else if (!$page->published)
			Utils::restrictAccess(null,
					"Connectez-vous avec un compte ayant des accès de rédacteur pour voir la page \"" . htmlspecialchars($id) . "\"",
					"Vous n'avez pas accès à la page Wiki non publiée \"" . htmlspecialchars($id) . "\" !",
					"redactor");
		$this->title = $page->title;
		$this->view->classicPage($page);
	}

	public function entityPage($ent) {
		$entity = $this->model->getEntityPage($ent);
		if (!$entity)
			Utils::error(404, "L'entité \"" . htmlspecialchars($ent) . "\" que vous cherchez n'a pas été trouvée");
		$this->title = "$entity->name - Entités";
		$this->view->entityPage($entity);
	}

	public function levelPage($lvl) {
		$level = $this->model->getLevelPage($lvl);
		if (!$level)
			Utils::error(404, "Le niveau \"" . htmlspecialchars($lvl) . "\" que vous cherchez n'a pas été trouvé");
		$this->title = "$level->name - Niveaux";
		$this->view->levelPage($level);
	}
}
