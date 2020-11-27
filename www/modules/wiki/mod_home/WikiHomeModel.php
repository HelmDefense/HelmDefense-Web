<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class WikiHomeModel extends Model {
	public function homeText() {
		$home = Utils::executeRequest(self::$bdd, "SELECT content FROM hd_wiki_pages WHERE id = 'home'", array(), false);
		return $home ? $home->content : "";
	}

	public function recentPages($limit) {
		$pages = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_wiki_pages WHERE published ORDER BY edited_at DESC LIMIT $limit");
		return array_map(function($page) {
			return $page->id;
		}, $pages);
	}

	public function entities($limit) {
		$entities = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_entities WHERE published LIMIT $limit");
		return array_map(function($entity) {
			return $entity->id;
		}, $entities);
	}

	public function levels($limit) {
		$levels = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_levels WHERE published LIMIT $limit");
		return array_map(function($level) {
			return $level->id;
		}, $levels);
	}
}
