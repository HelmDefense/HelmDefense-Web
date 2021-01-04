<?php
namespace Component;

include_once "components/generic/View.php";

class MarkdownTextView extends View {
	public function displayMarkdown($text) {
		echo "<div class='markdown'>$text</div>";
	}
}
