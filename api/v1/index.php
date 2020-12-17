<?php
define("CHECK_INCLUDE", NULL);
include_once "include/Utils.php";
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$mod = Utils::getRequired("module", "No request specified");
if ($mod == "error")
	Utils::error(intval(Utils::get("code", "400")), Utils::get("msg", "No information available"));

$module = Utils::loadModule($mod, false);
