<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class SearchModel extends Model {

	public function search($search, $typeSearch) {
		switch ($typeSearch) {
			case 'page':
				$this->searchPage($search);
				break;
			case 'entity':
				$this->searchEntity($search);
				break;
			case 'level':
				$this->searchLevel($search);
				break;
		}
	}

	public function searchPage($search) {
		return Utils::executeRequest(self::$bdd, 'SELECT * FROM hd_wiki_pages WHERE title OR content LIKE %:`search`%', array("search" => $search), true);
	}

	public function searchEntity($search) {
		return Utils::executeRequest(self::$bdd, 'SELECT * FROM hd_game_entities WHERE `name` OR description LIKE %:`search`%', array("search" => $search), true);
	}

	public  function searchLevel($search) {
		return Utils::executeRequest(self::$bdd, 'SELECT * FROM hd_game_levels WHERE `name` OR description LIKE %:`search`%', array("search" => $search), true);

	}

}