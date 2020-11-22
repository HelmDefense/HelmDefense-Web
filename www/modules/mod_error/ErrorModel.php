<?php
namespace Module;

include_once "modules/generic/Model.php";

class ErrorModel extends Model {
	/**
	 * @param string|null $page
	 * @return array
	 */
	public function searchFor($page) {
		if (is_null($page))
			return array();

		$pages = array_diff(scandir("modules/mod_static/pages"), array(".", ".."));
		return array_filter($pages, function ($p) use ($page) {
			return stristr($page, $p) || stristr($p, $page);
		});
	}
}
