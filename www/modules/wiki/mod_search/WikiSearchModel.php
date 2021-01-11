<?php
namespace Module;

use Utils;

class WikiSearchModel extends Model {
	public function search($search, $type) {
		switch ($type) {
		case "page":
			$sql = "SELECT id FROM hd_wiki_pages WHERE published AND (title LIKE :s OR content LIKE :s)";
			break;
		case "entity":
			$sql = "SELECT id FROM hd_game_entities WHERE published AND (`name` LIKE :s OR description LIKE :s)";
			break;
		case "level":
			$sql = "SELECT id FROM hd_game_levels WHERE published AND (`name` LIKE :s OR description LIKE :s)";
			break;
		default:
			return array();
		}
		$pages = Utils::executeRequest(self::$bdd, $sql, array("s" => "%" . Utils::escapeSqlLikeWildcards($search) . "%"), true);
		return array_map(function($page) { return $page->id; }, $pages);
	}
}
