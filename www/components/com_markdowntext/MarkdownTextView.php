<?php
namespace Component;

class MarkdownTextView extends View {
	public function displayMarkdown($text) {
		echo "<div class='markdown'>$text</div>";
	}
}
