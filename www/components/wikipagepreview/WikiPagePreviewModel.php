<?php
namespace Component;

include_once "components/generic/Model.php";

class WikiPagePreviewModel extends Model {
	protected static $bdd;

	public function getImagePreview($search) {
		self::$bdd = new PDO('mysql:host=localhost; dbname=helmdefense; charset=utf8', 'helmdefense', 'helmdefense');
		$sth = self::$bdd->prepare('SELECT avatar FROM hd_user_users WHERE name = $search');
		$sth->execute();

		return $sth->fetch();
	}

	public function getNamePreview($search) {
		$bdd = new PDO('mysql:host=localhost; dbname=helmdefense; charset=utf8', 'helmdefense', 'helmdefense');
		$sth = self::$bdd->prepare('SELECT name FROM hd_user_users WHERE name = $search');
		$sth->execute();

		return $sth->fetch();
	}
}