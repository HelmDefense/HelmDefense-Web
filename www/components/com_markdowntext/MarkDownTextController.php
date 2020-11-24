<?php
namespace Component;

include_once "components/generic/Controller.php";
include_once "MarkDownTextModel.php";
include_once "MarkDownTextView.php";

class MarkDownTextController extends Controller {
	private $text;

	public function __construct($var) {
		parent::__construct(new MarkDownTextModel(), new MarkDownTextView());
		$this->text = $var;
	}

	public function generateMarkDown() {
		$this->view->generateMarkDown($this->text);
	}
}
