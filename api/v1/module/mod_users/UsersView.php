<?php
include_once "include/check_include.php";

class UsersView {
	public function get($info) {
		echo json_encode(array(
			"id" => $info ["login"],
			"name" => $info ["name"],
			"avatar" => "https://helmdefense.theoszanto.fr/data/img/avatar/" . $info ["avatar"],
			"description" => $info ["description"],
			"join_date" => $info ["joined_at"],
			"ranks" => $info ["ranks"]
		));
	}

	public function auth($result) {
		echo $result ? "true" : "false";
	}
}
