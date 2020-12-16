<?php
namespace Module;

use Utils;

include_once "modules/generic/Model.php";

class WikiPageModel extends Model {
	public function getEntityPage($entity) {
		return Utils::httpGetRequest("v1/entities/$entity");
	}

	public function getClassicPage($id) {
		$page = Utils::executeRequest(self::$bdd, "SELECT num, title, content, created_at, edited_at, `name`, published FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u ON p.author = u.id WHERE p.id = :id", array("id" => $id), false);
		if (!$page->num)
			Utils::error(404, "La page que vous cherchez n'a pas été trouvée");
		else if (!$page->published)
			Utils::error(401, "Vous n'avez pas accès à cette page ! Connectez-vous avec un compte ayant des accès de rédacteur pour voir la page");

		// $page->img = "data/img/wiki/$page->num.png";
		$page->img = "https://via.placeholder.com/250?text=data/img/wiki/$page->num.png";
		return $page;
	}
}
