<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>Helm Defense API</title>
    </head>
    <body>
        <main>
            <?php
            define("CHECK_INCLUDE", NULL);

            include_once "include/utils.php";

            $mod = Utils::get("module");

            if (is_null($mod))
                echo "Bienvenue !";
            else
                $module = Utils::loadModule($mod, true);
            ?>
        </main>
    </body>
</html>