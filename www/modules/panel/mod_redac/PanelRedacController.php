<?php
namespace Module;

use Utils;

class PanelRedacController extends Controller {
	public function __construct() {
		parent::__construct(new PanelRedacModel(), new PanelRedacView());
	}

	public function verifyAccess() {
		Utils::restrictAccess(null,
				"Vous n'êtes pas autorisé à accéder au panel de rédaction sans être connecté",
				"Vous n'avez pas accès au panel de rédaction",
				"redactor");
	}

	public function listPages($p, $limit) {
		if ($p <= 0)
			Utils::error(400, "Numéro de page invalide");
		if ($limit <= 0)
			Utils::error(400, "Nombre d'éléments invalide");
		$pages = $this->model->pages($p, $limit);
		if (!$pages->result)
			Utils::error(400, "Page invalide");
		$this->view->displayList($pages->result, $pages->count, $limit, $p);
	}

	public function displayNewPage() {
		$this->title = "Nouvelle page";
		$this->view->displayEditPage();
	}

	public function displayEditPage($id) {
		if ($id <= 0)
			Utils::error(400, "Identifiant de page invalide");
		$page = $this->model->getPage($id);
		if (!$page)
			Utils::error(404, "La page n°" . htmlspecialchars($id) . " n'existe pas");

		$this->title = "$page->title - Édition de page";
		$this->view->displayEditPage($page->num, $page->id, $page->title, $page->content, $page->published);
		Utils::timeout("delete", 300);
	}

	public function createNewPage($id, $title, $content, $published) {
		$errors = array();
		if (is_null($id))
			$errors[] = "Identifiant non renseigné";
		if (is_null($title))
			$errors[] = "Titre non renseigné";
		if (is_null($content))
			$errors[] = "Contenu non renseigné";

		if (!count($errors)) {
			if ($this->model->createNewPage($id, $title, $content, $published)) {
				header("Location: /panel/redac");
				exit;
			} else
				$errors[] = "Identifiant de page dupliqué";
		}
		$this->title = "Nouvelle page";
		$this->view->displayEditPage(0, $id, $title, $content, $published, ...$errors);
	}

	public function editPage($page, $id, $title, $content, $published) {
		if ($this->model->editPage($page, $id, $title, $content, $published)) {
			header("Location: /panel/redac");
			exit;
		} else
			Utils::error(404, "La page n°" . htmlspecialchars($page) . " n'existe pas");
	}

	public function deletePage($page) {
		Utils::timeoutCheck("delete", true);
		if ($this->model->deletePage($page)) {
			header("Location: /panel/redac");
			exit;
		} else
			Utils::error(404, "La page n°" . htmlspecialchars($page) . " n'existait pas");
	}
}
