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
		$this->view->generateHeader($this->model->currentActiveNav(), $this->model->loggedInUser());
	}
}
