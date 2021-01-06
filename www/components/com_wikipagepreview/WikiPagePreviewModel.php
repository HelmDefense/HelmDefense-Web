<?php
namespace Component;

use Utils;

include_once "components/generic/Model.php";

class WikiPagePreviewModel extends Model {

	public function getPreview($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, title FROM hd_wiki_pages WHERE id = :id", array("id"=>$id), false);
		// $page->img = "/data/img/wiki/$page->num.png";
		$page->img = "https://via.placeholder.com/250?text=/data/img/wiki/$page->num.png";
		$page->id = $id;
		return $page;
	}

	public function getLevel($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, `name` AS title FROM hd_game_levels WHERE id = :id", array("id"=>$id), false);
		$page->img = "/data/img/wiki/level/$page->num.png";
		$page->id = $id;
		return $page;
	}

	public function getEntity($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, `name` AS title FROM hd_game_entities WHERE id = :id", array("id"=>$id), false);
		$page->img = "/data/img/wiki/entity/$page->num.png";
		$page->id = $id;
		return $page;
	}
}
