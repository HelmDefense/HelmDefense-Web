<?php
if (!defined("CHECK_INCLUDE"))
	define("CHECK_INCLUDE", NULL);
include_once "include/Utils.php";

Utils::initSession();

$module = Utils::loadModule();
$output = $module->run();

$header = Utils::loadComponent("header");
$header->generateRender();

$footer = Utils::loadComponent("footer");
$footer->generateRender();

$title = (empty($output->title) ? "" : "$output->title - ") . "Helm Defense";
$description = "Un jeu de Tower Defense basé sur l'univers de la Terre du Milieu (Et plus précisément la bataille du gouffre de Helm)";
$url = Utils::SITE_URL . substr($_SERVER["REQUEST_URI"], 1);
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />

		<meta name="author" content="Helm Defense Development Team" />
		<meta name="keywords" content="helmdefense, tower defense, helm deep, the lord of the rings, tolkien, lotr" />
		<meta name="application-name" content="Helm Defense" />
		<meta name="description" content="<?= $description ?>" />

		<meta property="og:site_name" content="Helm Defense" />
		<meta property="og:type" content="website" />
		<meta property="og:locale" content="fr" />
		<meta property="og:title" content="<?= $title ?>" />
		<meta property="og:description" content="<?= $description ?>" />
		<meta property="og:image" content="<?= Utils::SITE_URL ?>data/img/icon.png" />
		<meta property="og:url" content="<?= $url ?>" />

		<meta property="twitter:card" content="summary" />
		<meta property="twitter:title" content="<?= $title ?>" />
		<meta property="twitter:description" content="<?= $description ?>" />
		<meta property="twitter:image" content="<?= Utils::SITE_URL ?>data/img/icon.png" />
		<meta property="twitter:url" content="<?= $url ?>" />

		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
		<script src="/data/js/Utils.js"></script>
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
		<link rel="stylesheet" href="/data/css/style.css" />
		<link rel="icon" href="/data/img/icon.png" />
		<?= Utils::generateHead() ?>
		<title><?= $title ?></title>
	</head>
	<body>
		<?php $header->display(); ?>

		<main>
			<?= $output->body ?>
		</main>

		<?php $footer->display(); ?>
	</body>
</html>
