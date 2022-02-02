<?php


if (isset ($_POST['frm'])) 
{
    XSSPreventer::escapeSpecialCharacters();
    // htmlentities, addslashes, strip_tags, htmlspecialchars font à peu près le même travail
    $nom = trim($_POST['nom']) ?? '';
    $prenom = trim($_POST['prenom']) ?? '';
    $email = trim($_POST['email']) ?? '';
    $password = trim($_POST["password"]);
    $passwordRepeat = trim($_POST["passwordRepeat"]);
    
    $erreur = array(); //Tableau vide

    if (strlen(trim($nom)) === 0)
    {
        array_push($erreur, "Veuillez saisir votre nom");
    }
    else if (!ctype_alpha($nom))
    {
        array_push($erreur, "Veuillez saisir des caractères alphabétiques pour votre nom");
    }

    if (strlen(trim($prenom)) === 0)
    {
        array_push($erreur, "Veuillez saisir votre prenom");
    }
    else if (!ctype_alpha($prenom))
    {
        array_push($erreur, "Veuillez saisir des caractères alphabétiques pour votre prénom");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        array_push($erreur, "Veuillez saisir un e-mail valide");
    }

    if (strlen($password) === 0)
    {
        array_push($erreur, "Veuillez saisir un mot de passe");
    }

    if (strlen($passwordRepeat) === 0)
    {
        array_push($erreur, "Veuillez saisir la vérification de votre mot de passe");
    }

    if  ($password !== $passwordRepeat)
    {
        array_push($erreur, "Veuillez saisir le même mot de passe");
    }

    if (count($erreur) === 0)
    {
        $serverName = "localhost";
        $userName = "root";
        $userPassword = "";
        $database = "exercice";

        $connHandler = new ConnectionHandler($serverName, $database, $userName, $userPassword);

        $sql = "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp) 
        VALUES (NULL, '$nom', '$prenom', '$email', '" . password_hash($password, PASSWORD_DEFAULT) . "');";

        $connHandler->insert($sql);

    }

    else
    {
        $messageErreur = "<ul>";
        $cnt = 0;
        
        do 
        {
            $messageErreur .= "<li>" . $erreur[$cnt] . "</li>";
            ++$cnt;
        } 
        while ($cnt <count($erreur));
        
        $messageErreur .= "</ul>";
        
        echo $messageErreur;

        echo password_hash($password, PASSWORD_DEFAULT);
    }

}
else 
{
    echo "Merci de renseigner le formulaire";
    $nom = $prenom = $email = '';
}

include 'frmFormulaire.php';
