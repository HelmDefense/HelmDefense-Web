<?php
namespace Module;

use DateTime;
use PDO;
use stdClass;
use Utils;

class PanelRedacModel extends Model {
	public function pages($p, $limit) {
		$offset = ($p - 1) * $limit;
		$pages = new stdClass();
		self::$bdd->beginTransaction();
		$pages->result = Utils::executeRequest(self::$bdd, "SELECT SQL_CALC_FOUND_ROWS p.num, p.id, p.title, p.created_at, p.edited_at, u.login AS author, u.name AS author_name, p.published FROM hd_wiki_pages AS p INNER JOIN hd_user_users AS u on p.author = u.id WHERE p.title <> '' LIMIT $offset, $limit");
		$pages->count = Utils::executeRequest(self::$bdd, "SELECT found_rows() AS total", array(), false, PDO::FETCH_COLUMN);
		self::$bdd->commit();
		return $pages;
	}

	public function getPage($page) {
		return Utils::executeRequest(self::$bdd, "SELECT num, id, title, content, published FROM hd_wiki_pages WHERE num = :num", array("num" => $page), false);
	}

	private function image($image, $num) {
		$imagePath = $_SERVER["DOCUMENT_ROOT"] . "/data/img/wiki/$num.png";
		return move_uploaded_file($image->tmp_name, $imagePath);
	}

	private function postDiscordEmbed($num, $id, $title, $content, $author, $edited = false) {
		$discordEmbed = array(
				"embeds" => array(
						array(
								"author" => array(
										"name" => $author->name,
										"url" => Utils::SITE_URL . "user/profile/$author->login",
										"icon_url" => $author->avatar
								),
								"title" => $title,
								"url" => Utils::SITE_URL . "wiki/page/$id",
								"description" => substr($content, 0, 500) . "...\n\nVisitez le site pour découvrir la suite du " . ($edited ? "nouveau " : "") . "contenu de cette " . ($edited ? "" : "nouvelle ") . "page Wiki !",
								"thumbnail" => array(
										"url" => Utils::SITE_URL . "data/img/icon.png"
								),
								"image" => array(
										"url" => Utils::SITE_URL . "data/img/wiki/$num.png"
								),
								"footer" => array(
										"text" => $edited ? "Page Wiki Helm Defense éditée" : "Nouvelle page Wiki Helm Defense"
								),
								"timestamp" => date(DateTime::ISO8601)
						)
				)
		);
		Utils::httpPostRequest(Utils::config("discord.webhook"), $discordEmbed, true, false, false);
	}

	public function createNewPage($id, $title, $content, $published, $image) {
		$id = Utils::strNormalize($id);
		$duplicate = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_wiki_pages WHERE id = :id", array("id" => $id), false, PDO::FETCH_COLUMN);
		if ($duplicate)
			return false;
		$author = Utils::executeRequest(self::$bdd, "SELECT id, login, name, concat('https://helmdefense.theoszanto.fr/data/img/avatar/', if(avatar IS NULL, 'default.png', concat(id, '-', avatar))) AS avatar FROM hd_user_users WHERE login = :login", array("login" => Utils::session("login")), false);
		Utils::executeRequest(self::$bdd, "INSERT INTO hd_wiki_pages (id, title, content, author, published) VALUES (:id, :title, :content, :author, :published)", array("id" => $id, "title" => $title, "content" => $content, "author" => $author->id, "published" => intval($published)));
		$num = self::$bdd->lastInsertId();
		if ($published)
			$this->postDiscordEmbed($num, $id, $title, $content, $author);
		return $this->image($image, $num);
	}

	public function editPage($page, $id, $title, $content, $published, $image) {
		$old = $this->getPage($page);
		if (!$old)
			return false;
		foreach (array("id", "title", "content", "published") as $val)
			if (is_null($$val))
				$$val = $old->$val;
		$id = Utils::strNormalize($id);
		Utils::executeRequest(self::$bdd, "UPDATE hd_wiki_pages SET id = :id, title = :title, content = :content, published = :published WHERE num = :num", array("id" => $id, "title" => $title, "content" => $content, "published" => intval($published), "num" => $page));
		if ($published) {
			$author = Utils::executeRequest(self::$bdd, "SELECT id, login, name, concat('https://helmdefense.theoszanto.fr/data/img/avatar/', if(avatar IS NULL, 'default.png', concat(id, '-', avatar))) AS avatar FROM hd_user_users WHERE login = :login", array("login" => Utils::session("login")), false);
			$this->postDiscordEmbed($page, $id, $title, $content, $author, true);
		}
		return is_null($image) || $image->error || $this->image($image, $page);
	}

	public function deletePage($page) {
		$exists = Utils::executeRequest(self::$bdd, "SELECT count(1) FROM hd_wiki_pages WHERE num = :num", array("num" => $page), false, PDO::FETCH_COLUMN);
		if (!$exists)
			return false;
		Utils::executeRequest(self::$bdd, "DELETE FROM hd_wiki_pages WHERE num = :num", array("num" => $page));
		return unlink($_SERVER["DOCUMENT_ROOT"] . "/data/img/wiki/$page.png");
	}
}
