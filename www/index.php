<?php
if (!defined("CHECK_INCLUDE"))
	define("CHECK_INCLUDE", NULL);
include_once "include/Utils.php";

if (session_status() !== PHP_SESSION_ACTIVE)
	session_start(array("cookie_lifetime" => 86400));

if (Utils::get("section") == "user" && Utils::get("module") == "login") {
	$_SESSION["login"] = "indyteo";
	header("Location: /");
	exit;
}

if (Utils::get("section") == "user" && Utils::get("module") == "logout") {
	unset($_SESSION["login"]);
	header("Location: /");
	exit;
}

$module = Utils::loadModule();
$output = $module->run();

$header = Utils::loadComponent("header");
$header->generateRender();

$footer = Utils::loadComponent("footer");
$footer->generateRender();

$text = Utils::loadComponent("markdowntext",false,"# HelmDefense\nUn jeu de __Tower Defense__ basé sur l'univers de la __Terre du Milieu__ *(Et plus précisément la bataille du gouffre de Helm)* !");
$text->generateRender();
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport"
			  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
		<link rel="stylesheet" href="/data/css/style.css" />
		<link rel="stylesheet" href="/data/css/nav.css" />
		<link rel="icon" href="/data/img/icon.png" />
		<?php if (!is_null($output->head)) echo $output->head; ?>
		<title><?php if (!is_null($output->title)) echo "$output->title - "; ?>Helm Defense</title>
	</head>
	<body>
		<?php $header->display(); ?>

		<main>
			<?= $output->body ?>
		</main>

		<?php $footer->display(); ?>
		<?php $text->display(); ?>
	</body>
</html>
