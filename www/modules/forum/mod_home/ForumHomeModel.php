<?php
namespace Module;

use Utils;

class ForumHomeModel extends Model {
	public function homeText() {
		$home = Utils::executeRequest(self::$bdd, "SELECT content FROM hd_forum_msgs WHERE topic = 1 AND type = 0", array(), false);
		return $home ? $home->content : "";
	}
}
