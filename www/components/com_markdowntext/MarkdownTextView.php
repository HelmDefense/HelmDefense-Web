<?php
namespace Component;

use Parsedown;

include_once "components/generic/View.php";
include_once "include/Parsedown.php";

class MarkdownTextView extends View {
	private $parsedown;

	public function __construct() {
		$this->parsedown = new Parsedown();
		$this->parsedown->setSafeMode(true);
		$this->parsedown->setMarkupEscaped(true);
	}

	public function generateMarkdown($text) {
		echo "<div class='markdown'>" . $this->parsedown->text($text) . "</div>";
	}
}
