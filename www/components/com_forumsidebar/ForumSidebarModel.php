<?php
namespace Component;

use Utils;

class ForumSidebarModel extends Model {
	private static $types = array("talk", "rate", "strat");

	public function sidebarText() {
		$sidebar = Utils::executeRequest(self::$bdd, "SELECT content FROM hd_forum_msgs WHERE topic = 2 AND type = 0", array(), false);
		return $sidebar ? $sidebar->content : "";
	}

	public function recentActions() {
		$actions = array();
		foreach (self::$types as $type) {
			$action = Utils::httpGetRequest("v1/forum/$type", array("limit" => 1));
			if (Utils::isError($action) || $action->count == 0)
				return null;
			$actions[$type] = $action->result[0];
		}
		return $actions;
	}
}
