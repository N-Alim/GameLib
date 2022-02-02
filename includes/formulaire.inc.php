<?php


if (isset ($_POST['frm'])) 
{
    $nom = htmlentities(trim($_POST['nom'])) ?? '';
    $prenom = htmlentities(trim($_POST['prenom'])) ?? '';
    $email = htmlentities(trim($_POST['email'])) ?? '';
    $password = $_POST["password"];
    $passwordRepeat = $_POST["passwordRepeat"];
    
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

    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        array_push($erreur, "Veuillez saisir un e-mail valide");
    }

    if (strlen($password) === 0)
    {
        array_push($erreur, "Veuillez saisir un mot de passe");
    }

    if (strlen($passwordRepeat) === 0)
    {
        array_push($erreur, "Veuillez saisir la vérificatio  de votre mot de passe");
    }

    if  ($password !== $passwordRepeat)
    {
        array_push($erreur, "Veuillez saisir le même mot de passe");
    }

    if (count($erreur) === 0)
    {
        echo "Traitement du formulaire";
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
    }

}
else 
{
    echo "Merci de renseigner le formulaire";
    $nom = $prenom = $email = '';
}

include 'frmFormulaire.php';
