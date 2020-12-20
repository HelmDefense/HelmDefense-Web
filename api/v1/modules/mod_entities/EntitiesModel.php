<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class EntitiesModel extends Connection {
    public function list() {
        return Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_entities");
    }

	public function get($id) {
		$entity = Utils::executeRequest(self::$bdd, "SELECT num, id,`type`, `name`, description, size_x, size_y FROM hd_game_entities WHERE id = :id AND published", array("id" => $id), false);
		if (!$entity)
			Utils::error(404, "Entity not found");

		$num = $entity->num;
		switch ($entity->type) {
			case 1:
				$type = "defender";
				break;
			case 2:
				$type = "attacker";
				break;
			case 3:
				$type = "hero";
				break;
			case 4:
				$type = "boss";
				break;
			default:
				$type = "unknown";
		}

		$params = array("num" => $num);
		$abilities = Utils::executeRequest(self::$bdd, "SELECT class, params, description FROM hd_game_entity_abilities WHERE entity = :num", $params);
		$stats = Utils::executeRequest(self::$bdd, "SELECT `type`, hp, dmg, mvt_spd, atk_spd, atk_range, shoot_range, cost, reward, unlock_cost FROM hd_game_entity_stats WHERE entity = :num", $params);

		$ent = new stdClass();
		$ent->id = $entity->id;
		$ent->name = $entity->name;
		$ent->type = $type;
		$ent->description = $entity->description;
		$ent->img = "https://helmdefense.theoszanto.fr/data/img/wiki/entity/$num.png";

		$ent->abilities = new stdClass();
		foreach ($abilities as $ability) {
			$a = new stdClass();
			$a->params = is_null($ability->params) ? array() : explode("|", $ability->params);
			if (!is_null($ability->description))
				$a->description = $ability->description;

			$ent->abilities->{$ability->class} = $a;
		}

		$ent->size = new stdClass();
		$ent->size->width = $entity->size_x;
		$ent->size->height = $entity->size_y;

		foreach ($stats as $stat) {
			$typeStat = $stat->type;
			if ($typeStat)
				$tier = "tier$typeStat";
			else
				$tier = "stats";
			unset($stat->type);

			$ent->$tier = new stdClass();
			foreach ($stat as $s => $val)
				if (!is_null($val))
					$ent->$tier->$s = $val;
		}

		return $ent;
	}

	public function stat($id, $stat) {
    	if (!preg_match("/^((tier(?P<tier>[1-3]))\.)?(?P<stat>hp|dmg|mvt_spd|atk_spd|atk_range|shoot_range|cost|reward|unlock_cost)$/", $stat, $matches))
    		Utils::error(400, "Malformed stat name");

    	$s = Utils::executeRequest(self::$bdd, "SELECT ${matches["stat"]} AS stat FROM hd_game_entities INNER JOIN hd_game_entity_stats AS stats ON (entity = num) WHERE id = :id AND stats.`type` = :tier", array("id" => $id, "tier" => intval($matches["tier"])), false);
		if (!$s)
			Utils::error(404, "Statistic not found");

		return $s->stat;
	}
}
