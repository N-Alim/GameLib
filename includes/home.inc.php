<h1>Home</h1>
<?php

echo "Bienvenue " . ($_SESSION["prenom"] ?? "Inconnu(e)") . " " . ($_SESSION["nom"] ?? "perdu(e)");