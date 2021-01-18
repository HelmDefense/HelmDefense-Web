<?php
namespace Module;

use PDO;
use stdClass;
use Utils;

class PanelRedacModel extends Model {
	public function pages($p, $limit) {
		$offset = ($p - 1) * $limit;
		$pages = new stdClass();
		self::$bdd->beginTransaction();
		$pages->result = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS p.num, p.id, p.title, p.created_at, p.edited_at, u.login AS author, u.name AS author_name, p.published FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u on p.author = u.id LIMIT $offset, $limit");
		$pages->count = Utils::executeRequest(self::$bdd, "SELECT found_rows() AS total", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		return $pages;
	}

	public function getPage($page) {
		return Utils::executeRequest(self::$bdd, "SELECT num, id, title, content, published FROM hd_wiki_pages WHERE num = :num", array("num" => $page), false);
	}

	public function createNewPage($id, $title, $content, $published) {
		$id = Utils::strNormalize($id);
		$duplicate = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_wiki_pages WHERE id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
		if ($duplicate)
			return false;
		$author = Utils::executeRequest(self::$bdd, "SELECT id FROM hd_user_users WHERE login = :login", array("login" => Utils::session("login")), false)->id;
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_wiki_pages (id, title, content, author, published) VALUES (:id, :title, :content, :author, :published)", array("id" => $id, "title" => $title, "content" => $content, "author" => $author, "published" => intval($published)));
		// Get l'id pour le nom du fichier image : self::$bdd->lastInsertId()
		return true;
	}

	public function editPage($page, $id, $title, $content, $published) {
		$old = $this->getPage($page);
		if (!$old)
			return false;
		foreach (array("id", "title", "content", "published") as $val)
			if (is_null($$val))
				$$val = $old->$val;
		$id = Utils::strNormalize($id);
		Utils::executeRequest(self::$bdd, "UPDATE hd_wiki_pages SET id = :id, title = :title, content = :content, published = :published WHERE num = :num", array("id" => $id, "title" => $title, "content" => $content, "published" => intval($published), "num" => $page));
		return true;
	}

	public function deletePage($page) {
		$exists = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_wiki_pages WHERE num = :num", array("num" => $page), false, PDO::FETCH_COLUMN);
		if (!$exists)
			return false;
		Utils::executeRequest(self::$bdd, "DELETE FROM hd_wiki_pages WHERE num = :num", array("num" => $page));
		return true;
	}
}
