<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class LevelsModel extends connection {
	public function list() {
		return Utils::executeRequest(self::$bdd, "SELECT id FROM hd_game_levels");
	}

	public function get($id) {
		$level = Utils::executeRequest(self::$bdd, "SELECT * FROM `hd_game_levels` WHERE id = :id AND published", array("id" => $id), false);
		if (!$level)
			Utils::error(404, "Level not found");

		$num = array("num" => $level->num);
		$doors = Utils::executeRequest(self::$bdd, "SELECT * FROM `hd_game_level_doors` WHERE `level` = :num", $num);
		$spawns = Utils::executeRequest(self::$bdd, "SELECT * FROM `hd_game_level_spawns` WHERE `level` = :num", $num);
		$waves = Utils::executeRequest(self::$bdd, "SELECT * FROM `hd_game_level_waves` WHERE `level` = :num", $num);

		$lvl = new stdClass();
		$map = explode("|", $level->map);
		foreach ($map as &$line)
			$line = explode(",", $line);
		$lvl->map = $map;

		$lvl->spawns = array();
		foreach ($spawns as $spawn) {
			$s = new stdClass();
			$s->x = $spawn->x;
			$s->y = $spawn->y;
			$lvl->spawns[] = $s;
		}

		$lvl->target = new stdClass();
		$lvl->target->x = $level->target_x;
		$lvl->target->y = $level->target_y;

		$lvl->doors = array();
		foreach ($doors as $door) {
			$d = new stdClass();
			$d->x = $door->x;
			$d->y = $door->y;
			$d->hp = $door->hp;
			$lvl->doors[] = $d;
		}

		$lvl->id = $level->id;
		$lvl->name = $level->name;
		$lvl->description = $level->description;
		$lvl->lives = $level->lives;
		$lvl->start_money = $level->start_money;
		$lvl->img = "https://helmdefense.theoszanto.fr/data/img/wiki/level/$level->num.png";

		$lvl->waves = array();
		foreach ($waves as $wave) {
			$w = new stdClass();

			$w->name = $wave->name;
			$w->reward = $wave->reward;

			$entities = Utils::executeRequest(self::$bdd, "SELECT id, tick FROM hd_game_level_wave_entities INNER JOIN hd_game_entities ON entity = num WHERE wave = :wave", array("wave" => $wave->id));
			$w->entities = new stdClass();
			foreach ($entities as $entity)
				$w->entities->{$entity->tick} = $entity->id;
			$lvl->waves[] = $w;
		}
		return $lvl;
	}
}
