<?php

if (isset ($_POST['envoi'])) 
{
    XSSPreventer::escapeSpecialCharacters();
    // htmlentities, addslashes, strip_tags, htmlspecialchars font à peu près le même travail
    $email = trim($_POST['email']) ?? '';
    $password = trim($_POST["password"]);
    
    $erreur = array(); //Tableau vide

    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        array_push($erreur, "Veuillez saisir un e-mail valide");
    }

    if (strlen($password) === 0)
    {
        array_push($erreur, "Veuillez saisir un mot de passe");
    }

    if (count($erreur) === 0)
    {
        $serverName = "localhost";
        $userName = "root";
        $userPassword = "";
        $database = "exercice";

        // $connHandler = new ConnectionHandler($serverName, $database, $userName, $userPassword);
        // $connHandler->insert($sql);

        try 
        {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // $requete = $conn->query("SELECT COUNT(*) FROM utilisateurs WHERE mail='$email'");

            // $requete->execute();
            // $resultat = $requete->fetchColumn();

            $requete = $conn->query("SELECT * FROM utilisateurs WHERE mail='$email'");

            $requete->execute();
            $resultat  =$requete->fetchAll(PDO::FETCH_OBJ);

            if (count($resultat) === 0)
            {
                echo "Pas de résultat avec votre login/mot de passe";
            }

            else
            {
                if (password_verify($password, $resultat[0]->mdp))
                {
                    echo "Ok";
                }

                else
                {
                    echo "Bien tenté mais non";
                }
            }
        }

        catch (PDOException $e)
        {
            die("Erreur : " . $e->getMessage());
        }
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

include 'frmLogin.php';
