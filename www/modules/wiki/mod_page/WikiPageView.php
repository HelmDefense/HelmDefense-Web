<?php
namespace Module;

include_once "modules/generic/View.php";

class WikiPageView extends View {
	/**
	 * Display the page
	 * @param $page string The page index.php file path
	 */
	public function displayPage($page) {
		include_once "$page";
	}

}