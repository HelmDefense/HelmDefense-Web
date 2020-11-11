<?php
include_once "include/check_include.php";

class UsersView {
	public function get($user) {
		echo json_encode(array(
				"id" => $user->login,
				"name" => $user->name,
				"avatar" => "https://helmdefense.theoszanto.fr/data/img/avatar/$user->avatar",
				"description" => $user->description,
				"join_date" => $user->joined_at,
				"ranks" => $user->ranks
		));
	}

	public function auth($result) {
		echo $result ? "true" : "false";
	}
}
