<?php
namespace Component;

use Utils;

class HeaderController extends Controller {
	public function __construct() {
		parent::__construct(new HeaderModel(), new HeaderView());
	}

	public function generateHeader() {
		$this->view->generateHeader($this->model->currentActiveNav(), Utils::loggedInUser());
	}
}
