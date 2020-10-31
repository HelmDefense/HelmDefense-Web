<?php
include_once "include/check_include.php";

class TestView {
	public function test($users) {
		foreach ($users as $user) {
			echo "<p>${user["name"]} : ${user["description"]}</p>";
		}
	}
}
