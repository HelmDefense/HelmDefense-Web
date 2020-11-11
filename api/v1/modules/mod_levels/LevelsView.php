<?php
include_once "include/check_include.php";

class LevelsView {
    public function list($list) {
	    $json = array();
	    foreach ($list as $value)
		    $json[] = $value->id;
	    echo json_encode($json);
    }

    public function get($lvl) {
        echo json_encode($lvl, JSON_NUMERIC_CHECK);
    }
}
