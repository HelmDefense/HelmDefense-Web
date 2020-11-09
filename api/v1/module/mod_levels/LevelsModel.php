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

        $query = self::$bdd->prepare("SELECT * FROM `hd_game_levels` where id = :id");
        $params = array("id" => $id);
        if (!$query->execute($params))
            throw new PDOException();
        $result1 = $query->fetchAll(PDO::FETCH_ASSOC);

         $query = self::$bdd->prepare("SELECT * FROM `hd_game_level_doors` where level = :num");
         $params = array("num" => $result1[0]['num']);
         if (!$query->execute($params))
             throw new PDOException();
         $result2 = $query->fetchAll(PDO::FETCH_ASSOC);

         $query = self::$bdd->prepare("SELECT * FROM `hd_game_level_spawns` where level = :num");
         $params = array("num" => $result1[0]['num']);
         if (!$query->execute($params))
             throw new PDOException();
         $result3 = $query->fetchAll(PDO::FETCH_ASSOC);

         $query = self::$bdd->prepare("SELECT * FROM `hd_game_level_waves` where level = :num");
         $params = array("num" => $result1[0]['num']);
         if (!$query->execute($params))
             throw new PDOException();
         $result4 = $query->fetchAll(PDO::FETCH_ASSOC);

        $query = self::$bdd->prepare("SELECT * FROM 'hd_game_level_waves' INNER JOIN 'hd_game_level_wave_entities' where level = :num");
        $params = array("num" => $result1[0]['num']);
        if (!$query->execute($params))
            throw new PDOException();
        $result4 = $query->fetchAll(PDO::FETCH_ASSOC);


        for ($i = 0;$i < sizeof($result3); $i++){
            $liste["spawns"][$i]['x'] = $result3[$i]['x'];
            $liste["spawns"][$i]['y'] = $result3[$i]['y'];
        }
        $liste["target"]['x'] = $result1[0]['target_x'];
        $liste["target"]["y"] = $result1[0]['target_y'];
        for ($i = 0;$i < sizeof($result2); $i++){
            $liste["doors"][$i]['x'] = $result2[$i]['x'];
            $liste["doors"][$i]['y'] = $result2[$i]['y'];
        }
        $liste["lives"] = $result1[0]['lives'];
        $liste["names"] = $result1[0]['name'];
        $liste["start-money"] = $result1[0]['start_money'];
        for($i = 0;$i < sizeof($result4); $i++){
            //$liste["waves"][$i]["name"] = $result4[]
        }


        return  $liste;
    }
}