<?php
namespace Component;

use Utils;

include_once "components/generic/Model.php";

class ForumPostListModel extends Model {
	public function postList($type, $limit, $offset) {
		$posts = Utils::httpGetRequest("v1/forum/$type", array("limit" => $limit, "offset" => $offset));
		if (Utils::isError($posts))
			return null;
		return $posts;
	}
}
