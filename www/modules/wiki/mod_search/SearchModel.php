<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class SearchModel extends Model {
	public function search($search, $type) {
		switch ($type) {
			case "page":
				return $this->searchPage($search);
			case "entity":
				return $this->searchEntity($search);
			case "level":
				return $this->searchLevel($search);
		}
		return array();
	}

	public function searchPage($search) {
		$pages = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_wiki_pages WHERE published AND (title LIKE :search OR content LIKE :search)", array("search" => "%$search%"), true);
		return array_map(function($page) { return $page->id; }, $pages);
	}

	public function searchEntity($search) {
		$pages = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_entities WHERE published AND (`name` LIKE :search OR description LIKE :search)", array("search" => "%$search%"), true);
		return array_map(function($page) { return $page->id; }, $pages);
	}

	public  function searchLevel($search) {
		$pages = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_levels WHERE published AND (`name` LIKE :search OR description LIKE :search)", array("search" => "%$search%"), true);
		return array_map(function($page) { return $page->id; }, $pages);
	}
}
