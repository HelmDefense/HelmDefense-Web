<?php
namespace Component;

use Utils;

include_once "components/generic/Model.php";

class WikiPagePreviewModel extends Model {

	public function getPreview($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, title FROM hd_wiki_pages WHERE id = :id",
		array("id"=>$id), false);
		// $page->img = "/data/img/wiki/$page->num.png";
		$page->img = "https://via.placeholder.com/150";
		$page->id = $id;
		return $page;
	}
}