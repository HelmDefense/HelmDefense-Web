<?php
namespace Component;

use Parsedown;

include_once "components/generic/View.php";
include_once "include/Parsedown.php";

class MarkDownTextView extends View {

	private $parseDown;

	public function __construct() {
		$this->parseDown =  new Parsedown();
		$this->parseDown->setSafeMode(true);
		$this->parseDown->setMarkupEscaped(true);
	}

	public function generateMarkDown($text) {
		echo $this->parseDown->text($text);
	}
}
