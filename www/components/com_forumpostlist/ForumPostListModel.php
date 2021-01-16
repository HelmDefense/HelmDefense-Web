<?php
namespace Component;

use Utils;

class ForumPostListModel extends Model {
	public function postList($type, $limit, $page) {
		$posts = Utils::httpGetRequest("v1/forum/$type", array("limit" => $limit, "page" => $page));
		if (Utils::isError($posts))
			return null;
		return $posts;
	}
}
