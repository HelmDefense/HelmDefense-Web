<?php
include_once "modules/generic/Controller.php";
include_once "StaticModel.php";
include_once "StaticView.php";

class StaticController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new StaticModel(), new StaticView());
	}

	/**
	 * Load a page from it's name
	 * @param $page string The page name
	 */
	public function loadPage($page) {
		if (!preg_match("/^[a-z_]+$/", $page) || !file_exists("modules/mod_static/pages/$page/index.php"))
			Utils::error(404, "Page \"$page\" introuvable", array("page" => $page));

		$this->model->setPage("modules/mod_static/pages/$page");
		$this->view->displayPage("modules/mod_static/pages/$page/index.php");
	}

	/**
	 * @inheritDoc
	 */
	public function getHead() {
		return $this->view->getHead($this->model->getHeadFilename(), $this->model->getStyle());
	}

	/**
	 * @inheritDoc
	 */
	public function getTitle() {
		return $this->model->getName();
	}
}
