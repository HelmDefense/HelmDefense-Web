<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "HeaderModel.php";
include_once "HeaderView.php";

class HeaderController extends Controller {
	public function __construct() {
		parent::__construct(new HeaderModel(), new HeaderView());
	}

	public function generateHeader() {
		$currentActiveNav = $this->model->currentActiveNav();
		$loggedInUsername = $this->model->loggedInUsername();
		$panelAccess = $this->model->panelAccess($loggedInUsername);

		$this->view->generateHeader($currentActiveNav, $panelAccess, $loggedInUsername);
	}
}
