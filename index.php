<?php

date_default_timezone_set("Europe/Paris");
// setlocale(LC_ALL, ""); spécifique Windows

spl_autoload_register(function ($className)
{
    include "./classes/$className.php";
});

require_once "./functions/includeAllFunctions.php";
includeAllFunctions();

require_once "./includes/head.php";
require_once "./includes/main.php";
require_once "./includes/footer.php";