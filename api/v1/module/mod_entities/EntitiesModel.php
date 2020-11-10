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
		$query_entity = self::$bdd->prepare("SELECT num, id,`type`, `name`, description, size_x, size_y FROM hd_game_entities where id = :id");

		$params = array("id" => $id);
		if (!$query_entity->execute($params))
			throw new PDOException();

		$entity = $query_entity->fetch(PDO::FETCH_OBJ);
		if (!$entity)
			Utils::error(404, "entity not found");

		$num = $entity->num;
		switch ($entity->type){
			case 1 :
				$type = "defender";
				break;

			case 2 :
				$type = "attacker";
				break;

			case 3 :
				$type = "hero";
				break;

			case 4 :
				$type = "boss";
				break;

			default :
				$type = "unknown";
		}

		$query_abilities = self::$bdd->prepare("SELECT class, params FROM hd_game_entity_abilities where entity = :num");
		$query_stats = self::$bdd->prepare("SELECT type, hp, dmg, mvt_spd, atk_spd, atk_range, shoot_range, cost, reward, unlock_cost FROM hd_game_entity_stats where entity = :num");

		$tab = array("num" => $num);
		if (!$query_abilities->execute($tab) || !$query_stats->execute($tab))
			throw new PDOException();

		$abilities = $query_abilities->fetchAll(PDO::FETCH_OBJ);
		$stats = $query_stats->fetchAll(PDO::FETCH_OBJ);

		$result = new stdClass();
		$result->id = $entity->id;
		$result->name = $entity->name;
		$result->type = $type;

		$result->abilities = new stdClass();
		foreach ($abilities as $ability)
			$result->abilities->{$ability->class} = is_null($ability->params) ? array() : explode("|", $ability->params);

		$result->size = new stdClass();
		$result->size->width = $entity->size_x;
		$result->size->height = $entity->size_y;

		foreach ($stats as $stat){
			$typeStat = $stat->type;
			if($typeStat)
				$tier = "tier$typeStat";
			else
				$tier = "stats";
			unset($stat->type);

			$result->$tier = new stdClass();
			foreach ($stat as $val=>$check)
				if (! is_null($check))
					$result->$tier->$val = $check;
		}

		return $result;
	}


	public function test() {
		$query = self::$bdd->prepare("SELECT name, description FROM hd_user_users");

		if (!$query->execute())
			throw new PDOException();

		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
