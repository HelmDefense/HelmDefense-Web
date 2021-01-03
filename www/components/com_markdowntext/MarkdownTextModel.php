<?php
namespace Component;

use Parsedown;

include_once "components/generic/Model.php";

class MarkdownTextModel extends Model {
	private $parsedown;

	public function __construct() {
		$this->parsedown = new Parsedown();
		$this->parsedown->setSafeMode(true);
		$this->parsedown->setMarkupEscaped(true);
	}

	public function parseMarkdown($text) {
		return $this->parsedown->text($text);
	}
}
