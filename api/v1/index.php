<?php
define("CHECK_INCLUDE", NULL);
include_once "include/Utils.php";
header("Content-Type: application/json");

$mod = Utils::get("module");

if (is_null($mod))
    Utils::error(400, "No request specified");

if ($mod == "error")
	Utils::error(intval(Utils::get("code", "400")), Utils::get("msg", "No information available"));

$module = Utils::loadModule($mod, true);
