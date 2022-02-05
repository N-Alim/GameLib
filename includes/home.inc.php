<h1>Home</h1>
<?php

// echo "Bienvenue " . ($_SESSION["firstName"] ?? "Inconnu(e)") . " " . ($_SESSION["name"] ?? "perdu(e)");
echo "Bienvenue " . ($_SESSION["pseudo"] ?? "Inconnu(e) perdu(e)");
