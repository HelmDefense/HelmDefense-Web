<?php
include_once "check_include.php";

class Connection {
	/**
	 * @var PDO
	 */
	protected static $bdd;

	/**
	 * @param PDOException|null $error
	 * @return bool
	 */
	static function init(&$error = null) {
		try {
			self::$bdd = self::dbconnect();
			return true;
		} catch (PDOException $e) {
			$error = $e;
			return false;
		}
	}

	/**
	 * @return PDO
	 */
	private static function dbconnect() {
		$dbconnect = Utils::config("database");
		if (is_null($dbconnect) || !isset($dbconnect->dsn, $dbconnect->user, $dbconnect->pass))
			throw new PDOException("Fichier de connexion invalide");

		return new PDO($dbconnect->dsn, $dbconnect->user, $dbconnect->pass);
	}
}
