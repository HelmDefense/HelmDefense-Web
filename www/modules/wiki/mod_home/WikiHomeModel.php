<?php
namespace Module;

use Utils;

class WikiHomeModel extends Model {
	public function homeText() {
		$home = Utils::executeRequest(self::$bdd, "SELECT content FROM hd_wiki_pages WHERE id = 'home'", array(), false);
		return $home ? $home->content : "";
	}

	public function recentPages($limit = -1) {
		$pages = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_wiki_pages WHERE published ORDER BY edited_at DESC" . ($limit > 0 ? " LIMIT $limit" : ""));
		return array_map(function($page) {
			return $page->id;
		}, $pages);
	}

	public function entities($limit = -1) {
		$entities = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_entities WHERE published" . ($limit > 0 ? " LIMIT $limit" : ""));
		return array_map(function($entity) {
			return $entity->id;
		}, $entities);
	}

	public function levels($limit = -1) {
		$levels = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_levels WHERE published" . ($limit > 0 ? " LIMIT $limit" : ""));
		return array_map(function($level) {
			return $level->id;
		}, $levels);
	}
}
