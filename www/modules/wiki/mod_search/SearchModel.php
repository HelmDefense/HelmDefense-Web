<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class SearchModel extends Model {

	public function search($search, $typeSearch) {
		switch ($typeSearch) {
			case 'page':
				return $this->searchPage($search);
			case 'entity':
				return $this->searchEntity($search);
			case 'level':
				return $this->searchLevel($search);
		}
		return array();
	}

	public function searchPage($search) {
		return Utils::executeRequest(self::$bdd, "SELECT * FROM hd_wiki_pages WHERE title LIKE :search OR content LIKE :search", array("search" => "%$search%"), true);
	}

	public function searchEntity($search) {
		return Utils::executeRequest(self::$bdd, "SELECT * FROM hd_game_entities WHERE `name` LIKE :search OR description LIKE :search", array("search" => "%$search%"), true);
	}

	public  function searchLevel($search) {
		return Utils::executeRequest(self::$bdd, "SELECT * FROM hd_game_levels WHERE `name` LIKE :search OR description LIKE :search", array("search" => "%$search%"), true);

	}

}