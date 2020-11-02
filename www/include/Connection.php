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
		$dbconnect = self::get_dbconnect_info();
		if (is_null($dbconnect))
			throw new PDOException("Fichier de connexion invalide");

		return new PDO($dbconnect["dsn"], $dbconnect["user"], $dbconnect["pass"]);
	}

	/**
	 * @return array|null
	 */
	private static function get_dbconnect_info() {
		$file = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/../.dbconnect");
		if (!$file)
			return null;

		$file = str_replace("\r", "", $file);
		$file_split = explode("\n", $file);
		if (count($file_split) != 3)
			return null;

		return array(
				"dsn" => $file_split[0],
				"user" => $file_split[1],
				"pass" => $file_split[2]
		);
	}
}
