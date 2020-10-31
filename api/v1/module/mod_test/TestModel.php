<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class TestModel extends Connection {
	public function test() {
		$query = self::$bdd->prepare("SELECT name, description FROM hd_user_users");

		if (!$query->execute())
			throw new PDOException();

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
