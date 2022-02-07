<?php
require_once "./functions/includeAllFunctions.php";
includeAllFunctions();
/*
session_destroy
session_unset
session_id
*/
session_start();

date_default_timezone_set("Europe/Paris");
// setlocale(LC_ALL, ""); spécifique Windows
setlocale(LC_CTYPE, 'FR');

spl_autoload_register(function ($className)
{
    include "./classes/$className.php";
});


require_once "./includes/head.php";
require_once "./includes/main.php";
require_once "./includes/footer.php";