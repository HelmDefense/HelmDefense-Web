<?php
include_once "include/check_include.php";
include_once "include/Connection.php";
include_once "include/Parsedown.php";

class MarkdownModel extends Connection {
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
