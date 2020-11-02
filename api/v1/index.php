<?php
define("CHECK_INCLUDE", NULL);
include_once "include/Utils.php";
header("Content-Type: application/json");

$mod = Utils::get("module");

if (is_null($mod))
    echo "Bienvenue !";
else
    $module = Utils::loadModule($mod, true);
