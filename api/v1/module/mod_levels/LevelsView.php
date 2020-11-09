<?php
include_once "include/check_include.php";

class LevelsView
{
    public function afficheListe($liste){
        echo json_encode($liste);
    }

    public function afficheLevel($lvl){
        echo json_encode($lvl);
    }
    /*public function test($users) {
        foreach ($users as $user) {
            echo "<p>${user["name"]} : ${user["description"]}</p>";
        }
    }*/
}