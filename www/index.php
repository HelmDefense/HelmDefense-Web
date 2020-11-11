<?php
define("CHECK_INCLUDE", NULL);
include_once "include/Utils.php";

$module = Utils::loadModule();
$output = $module->run();
?>

<!doctype html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport"
		      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title><?php echo $output->title; ?> - Helm Defense</title>
	</head>
	<body>
		<?php echo $output->body; ?>
	</body>
</html>
