<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "FooterModel.php";
include_once "FooterView.php";

class FooterController extends Controller {
	public function __construct() {
		parent::__construct(new FooterModel(), new FooterView());
	}

	public function generateFooter() {
		$this->view->generateFooter();
	}
}
