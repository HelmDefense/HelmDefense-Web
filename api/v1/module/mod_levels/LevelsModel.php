<?php
include_once "include/check_include.php";
include_once "include/Connection.php";

class LevelsModel extends connection {


    public function liste() {
        $query = self::$bdd->prepare("SELECT id FROM hd_game_levels");

        if (!$query->execute())
            throw new PDOException();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0;$i < sizeof($result); $i++){
            $list[$i] = $result[$i]["id"];
        }
        return $list;
    }

    public function level($id){

        $level = Utils::executeRequest(self::$bdd,"SELECT * FROM `hd_game_levels` where id = :id", array("id" => $id),false);
        $num = array("num" => $level->num);
        $doors = Utils::executeRequest(self::$bdd,"SELECT * FROM `hd_game_level_doors` where level = :num",$num);
        $spawns = Utils::executeRequest(self::$bdd,"SELECT * FROM `hd_game_level_spawns` where level = :num", $num);
        $waves = Utils::executeRequest(self::$bdd,"SELECT * FROM `hd_game_level_waves` where level = :num", $num);

        $lvl = new stdClass();
        $map = explode("|",$level->map);
        foreach ($map as &$line){
            $line = explode(",",$line);
        }
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
        foreach ($doors as $door){
            $d = new stdClass();
            $d->x = $door->x;
            $d->y = $door->y;
            $d->hp = $door->hp;
            $lvl->doors[] = $d;
        }


        $lvl->lives = $level->lives;
        $lvl->names = $level->name;
        $lvl->start_money = $level->start_money;

        $lvl->waves = array();
        foreach ($waves as $wave){
            $w = new stdClass();

            $w->names = $wave->name;
            $w->reward = $wave->reward;

            $entities = Utils::executeRequest(self::$bdd,"SELECT id,tick FROM hd_game_level_wave_entities INNER JOIN hd_game_entities ON entity = num WHERE wave = :wave",array("wave" => $wave->id));
            $w->entities = new stdClass();
            foreach ($entities as $entity){
                $w->entities->{$entity->tick} = $entity->id;
            }
            $lvl->waves[] = $w;
        }
        return  $lvl;
    }
}