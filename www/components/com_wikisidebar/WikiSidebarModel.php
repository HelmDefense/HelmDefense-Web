<?php
namespace Component;

use Utils;

include_once "components/generic/Model.php";

class WikiSidebarModel extends Model {
	public function sidebarText() {
		$sidebar = Utils::executeRequest(self::$bdd, "SELECT content FROM hd_wiki_pages WHERE id = 'sidebar'", array(), false);
		return $sidebar ? $sidebar->content : "";
	}

	public function recentActions($limit) {
		return Utils::executeRequest(self::$bdd, "SELECT p.id AS page_id, p.title AS title, CASE WHEN p.edited_at IS NULL THEN p.created_at ELSE p.edited_at END AS `date`, u.login AS author_id, u.name AS author FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u ON p.author = u.id WHERE p.published ORDER BY `date` DESC LIMIT $limit");
	}
}
