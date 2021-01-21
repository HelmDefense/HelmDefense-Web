<?php
namespace Component;

class MarkdownTextView extends View {
	public function displayMarkdown($text, $inverted) {
		echo "<div class='markdown" . ($inverted ? " inverted" : "") . "'>$text</div>";
	}
}
