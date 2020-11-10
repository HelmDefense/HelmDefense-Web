<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class EntitiesModel extends Connection {

    public function list() {
        $query = self::$bdd->prepare("SELECT id FROM hd_game_entities");

        if (!$query->execute())
            throw new PDOException();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

	public function get($id) {
		//$query = self::$bdd->prepare("SELECT id, `name`, description, size_x, size_y, class, params, `type`, hp, dmg, atk_spd, atk_range, cost, unlock_cost FROM hd_game_entities where id = :id INNER JOIN hd_game_entity_abilities WHERE hd_game_entity_abilities.entity = hd_game_entities.num INNER JOIN hd_game_entity_stats WHERE hd_game_entity_stats.entity = hd_game_entities.num");
		$query_entity = self::$bdd->prepare("SELECT num, id,`type`, `name`, description, size_x, size_y FROM hd_game_entities where id = :id");
		//1 : defenseur
		//2 : attaquant
		//3 : hero
		//4 : boss

		$params = array("id" => $id);

		if (!$query_entity->execute($params))
			throw new PDOException();

		$entiity = $query_entity->fetch(PDO::FETCH_ASSOC);

		$num = $entiity->num;

		$query_abiliies = self::$bdd->prepare("SELECT class, params FROM hd_game_entity_abilities where entity = :num");
		$query_stats = self::$bdd->prepare("SELECT hp, dmg, atk_spd, atk_range, cost, unlock_cost FROM hd_game_entity_stats where entity = :num");
	}


	public function test() {
		$query = self::$bdd->prepare("SELECT name, description FROM hd_user_users");

		if (!$query->execute())
			throw new PDOException();

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
