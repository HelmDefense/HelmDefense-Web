<?php
namespace Module;

use stdClass;
use Utils;

include_once "modules/generic/Model.php";

class WikiPageModel extends Model {

	public function getEntityPage($entity) {
		return Utils::httpGetRequest("v1/entities/$entity");
	}

	public function getClassicPage($id) {

		$page = Utils::executeRequest(self::$bdd, "SELECT published,num,title,content,created_at,edited_at,`name` FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u ON p.author = u.id WHERE p.id=:id",array("id" => $id),false);
		if (!$page)
			Utils::error(404,"Wiki Page not found");
		else if($page->published == 0)
			Utils::error(401,"Vous n'avez pas accès à cette page !");

		// $page->img = "data/img/wiki/$page->num.png";
		$page->img = "https://via.placeholder.com/150";
		return $page;
	}

}