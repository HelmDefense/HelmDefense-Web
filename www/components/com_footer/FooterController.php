<?php
namespace Component;

class FooterController extends Controller {
	public function __construct() {
		parent::__construct(new FooterModel(), new FooterView());
	}

	public function generateFooter() {
		$this->view->generateFooter();
	}
}
