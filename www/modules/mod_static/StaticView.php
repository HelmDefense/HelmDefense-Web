<?php
namespace Module;

class StaticView extends View {
	/**
	 * Display the page
	 * @param $page string The page index.php file path
	 */
	public function displayPage($page) {
		include_once "$page";
	}

	/**
	 * Generate the page head
	 * @param $head string|null The head.php file path or null if there's no head
	 * @param $style string|null The style.css file content or null if there's no style
	 * @return string The final head section to include in the page head
	 */
	public function getHead($head, $style) {
		// Check if head exists
		if (is_null($head))
			// When head doesn't exists, we only have to return style if it exists or nothing otherwise
			return is_null($style) ? "" : $style;

		// We need output buffering to include head file
		ob_start();
		include_once "$head";
		// Check if style exists
		if (!is_null($style))
			echo $style;

		return ob_get_clean();
	}
}
