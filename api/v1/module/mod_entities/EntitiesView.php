<?php
include_once "include/check_include.php";

class EntitiesView {
    public function list($list){
        $json = array();

        foreach ($list as $value)
            $json[] = $value{"id"};

        echo json_encode($json);
    }


	public function test($users) {
		foreach ($users as $user) {
			echo "<p>${user["name"]} : ${user["description"]}</p>";
		}
	}
}
