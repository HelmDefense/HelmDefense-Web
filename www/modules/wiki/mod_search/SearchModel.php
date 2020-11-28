<?php
namespace Module;

include_once "modules/generic/Model.php";

class SearchModel extends Model {

	public function search($search, $typeSearch) {
		return array("testlio", "page", "test_page");
	}

}