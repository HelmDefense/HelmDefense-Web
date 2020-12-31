<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "WikiSidebarModel.php";
include_once "WikiSidebarView.php";

class WikiSidebarController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new WikiSidebarModel(), new WikiSidebarView());
	}

	public function generateSidebar() {
		$this->view->sidebar($this->model->sidebarText(), $this->model->recentActions(3));
	}
}
