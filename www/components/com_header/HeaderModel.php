<?php
namespace Component;

include_once "components/generic/Model.php";

class HeaderModel extends Model {
	public function currentActiveNav() {
		$url = $_SERVER["REQUEST_URI"];
		$page = explode("/", $url)[1];
		return empty($page) ? "home" : $page;
	}
}
