<?php
require_once "./includes/nav.php";
?>
<h1>GameLib</h1>
<?php

$page = $_GET["page"] ?? "./includes/404.php";
require_once $page;