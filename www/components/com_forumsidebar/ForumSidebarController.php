<?php
namespace Component;

class ForumSidebarController extends Controller {
	/**
	 * @inheritDoc
	 */
	public function __construct() {
		parent::__construct(new ForumSidebarModel(), new ForumSidebarView());
	}

	public function generateSidebar() {
		$this->view->sidebar($this->model->sidebarText(), $this->model->recentActions());
	}
}
