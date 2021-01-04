<?php
include_once "include/check_include.php";

class MarkdownView {
	public function markdown($text) {
		echo json_encode(array("markdown" => $text));
	}
}
