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

        // $connHandler = new ConnectionHandler($serverName, $database, $userName, $userPassword);
        // $connHandler->insert($sql);

        try 
        {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);


            // 5 méthodes; 4 icis et 1 dans ConnectionHandler

            // $query = $conn->prepare(
            //     "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp) 
            //     VALUES (id, :nom, :prenom, :email, :password);"
            // );

            // $query->execute(
            //     array(
            //         ":id" => null,
            //         ":nom" => $nom,
            //         ":prenom" => $prenom,
            //         ":email" => $email,
            //         ":password" => $password
            //     )
            // );

            // $query = $conn->prepare(
            //     "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp) 
            //     VALUES (?, ?, ?, ?, ?);"
            // );

            // $query->execute( array( null, $nom, $prenom, $email, $password ));
            
            // $query = $conn->prepare(
            //     "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp) 
            //     VALUES (:id, :nom, :prenom, :email, :password);"
            // );

            // $query->bindValue(':id', null);
            // $query->bindValue(':nom', $nom, PDO::PARAM_STR_CHAR);
            // $query->bindValue(':prenom', $prenom, PDO::PARAM_STR_CHAR);
            // $query->bindValue(':email', $email, PDO::PARAM_STR_CHAR);
            // $query->bindValue(':password', $password, PDO::PARAM_STR_CHAR);
            // $query->execute();

            // $query = $conn->prepare(
            //     "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp) 
            //     VALUES (?, ?, ?, ?, ?);"
            // );
            // // bindValue: passage par copie, bindParam: passage par référence
            // $query->bindValue(1, null);
            // $query->bindValue(2, $nom, PDO::PARAM_STR_CHAR);
            // $query->bindValue(3, $prenom, PDO::PARAM_STR_CHAR);
            // $query->bindValue(4, $email, PDO::PARAM_STR_CHAR);
            // $query->bindValue(5, $password, PDO::PARAM_STR_CHAR);
            // $query->execute();

            $query = $conn->prepare(
                "INSERT INTO utilisateurs(id_utilisateur, nom, prenom, mail, mdp) 
                VALUES (:id, :nom, :prenom, :email, :password);"
            );

            $query->bindValue(':id', null);
            $query->bindParam(':nom', $nom, PDO::PARAM_STR_CHAR);
            $query->bindParam(':prenom', $prenom, PDO::PARAM_STR_CHAR);
            $query->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
            $query->bindParam(':password', $password, PDO::PARAM_STR_CHAR);
            $query->execute();

            $update = $conn->prepare(
                "UPDATE utilisateurs
                SET mail='toto@toto.com'
                WHERE id_utilisateur=1;"
            );

            $update->execute();

            echo "<p>Insertions effectuées</p>";
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

        echo password_hash($password, PASSWORD_DEFAULT);
    }

}
else 
{
    echo "Merci de renseigner le formulaire";
    $nom = $prenom = $email = '';
}

include 'frmFormulaire.php';
