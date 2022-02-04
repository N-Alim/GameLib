<?php
function goToPage($defaultPage)
{
    $files = glob("./includes/*.inc.php");
    $page = $_GET["page"] ?? $defaultPage;
    $page = "./includes/" . $page . ".inc.php";
    
    if (!in_array($page, $files))
    {
        $page = "./includes/" . $defaultPage . ".inc.php";
    }

    require_once $page;
}