<?php
namespace Component;

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
