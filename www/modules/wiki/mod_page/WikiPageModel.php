<?php
namespace Module;

use Utils;

class WikiPageModel extends Model {
	public function getEntityPage($entity) {
		$ent = Utils::httpGetRequest("v1/entities/$entity");
		if (Utils::isError($ent))
			return null;
		return $ent;
	}

	public function getLevelPage($level) {
		$lvl = Utils::httpGetRequest("v1/levels/$level");
		if (Utils::isError($lvl))
			return null;
		return $lvl;
	}

	public function getClassicPage($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, title, content, created_at, edited_at, `name`, published FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u ON p.author = u.id WHERE p.id = :id", array("id" => $id), false);
		if (!$page)
			return null;

		// $page->img = "data/img/wiki/$page->num.png";
		$page->img = "https://via.placeholder.com/250?text=data/img/wiki/$page->num.png";
		return $page;
	}
}
