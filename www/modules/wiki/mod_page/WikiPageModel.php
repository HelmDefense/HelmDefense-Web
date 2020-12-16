<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class WikiPageModel extends Model {
	public function getEntityPage($entity) {
		return Utils::httpGetRequest("v1/entities/$entity");
	}

	public function getClassicPage($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, title, content, created_at, edited_at, `name` FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u ON p.published = u.id WHERE p.id = :id", array("id" => $id), false);
		// $page->img = "data/img/wiki/$page->num.png";
		$page->img = "https://via.placeholder.com/250?text=data/img/wiki/$page->num.png";
		return $page;
	}
}
