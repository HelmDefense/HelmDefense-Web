<?php
include_once "include/check_include.php";

class ForumView {
	public function json($posts) {
		echo json_encode($posts, JSON_NUMERIC_CHECK);
	}
}
