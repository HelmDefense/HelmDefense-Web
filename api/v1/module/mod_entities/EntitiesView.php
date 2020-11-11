<?php
include_once "include/check_include.php";

class EntitiesView {
	public function list($list) {
		$json = array();

		foreach ($list as $value)
			$json[] = $value->id;

		echo json_encode($json);
	}

	public function get($info) {
		echo json_encode($info, JSON_NUMERIC_CHECK);
	}

	public function stat($stat) {
		echo $stat;
	}
}
