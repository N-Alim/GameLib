<?php

if (isset ($_POST['inscription'])) 
{
    XSSPreventer::escapeSpecialCharacters();
    // htmlentities, addslashes, strip_tags, htmlspecialchars font à peu près le même travail
    $name = trim($_POST['name']) ?? '';
    $firstName = trim($_POST['firstName']) ?? '';
    $email = trim($_POST['email']) ?? '';
    $password = trim($_POST["password"]);
    $passwordRepeat = trim($_POST["passwordRepeat"]);
    $pseudo = trim($_POST['pseudo']) ?? '';
    $bio = trim($_POST['bio']) ?? '';
    
    $erreur = array(); //Tableau vide

    if (strlen(trim($name)) === 0)
    {
        array_push($erreur, "Veuillez saisir votre nom");
    }
    else if (!ctype_alpha($name))
    {
        array_push($erreur, "Veuillez saisir des caractères alphabétiques pour votre nom");
    }

    if (strlen(trim($firstName)) === 0)
    {
        array_push($erreur, "Veuillez saisir votre prenom");
    }
    else if (!ctype_alpha($firstName))
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

    if (strlen($pseudo) === 0)
    {
        array_push($erreur, "Veuillez saisir un pseudo");
    }

    if(isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0)
    {
        $fileName = $_FILES["avatar"]["name"];
        $fileType = $_FILES["avatar"]["type"];
        $fileTmpName = $_FILES["avatar"]["tmp_name"];

        $tableauTypes = array("image/jpeg", "image/jpg", "image/png", "image/gif");    

        if (in_array($fileType, $tableauTypes))
        {
            $date = date("Y-m-d-h-i-s");
            $fileName = $date . "_" . $fileName;
            $fileName = getcwd() . "\\avatars\\" . $fileName;


            // if (file_exists($fileName))
            // {
            //     $cnt = 2;

            //     $fileCopyName = $fileName . " (" . $cnt . ")";

            //     while(file_exists($fileCopyName))
            //     {
            //         ++$cnt;
            //         $fileCopyName = $fileName . " (" . $cnt .")";
            //     }

            //     $fileName = $fileCopyName;
            // }

            if (move_uploaded_file($fileTmpName, $fileName))
            {
                // echo "Fichier déplacé";
            }
        }

        else
        {
            array_push($erreur, "Erreur type MIME");
        }
    }

    else
    {
        array_push($erreur, "Erreur upload " . $_FILES["avatar"]["error"]);
    }

    if (count($erreur) === 0)
    {
        $serverName = "localhost";
        // $userName = "root";
        // $userPassword = "";
        $userName = "guest";
        $userPassword = "VXUtMaHGFDv5FYz_";
        $database = "gamelib";

        // Mot de passe "guest": VXUtMaHGFDv5FYz_

        // $connHandler = new ConnectionHandler($serverName, $database, $userName, $userPassword);
        // $connHandler->insert($sql);

        try 
        {
            $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = $conn->prepare(
                "INSERT INTO users(name, firstName, email, password, pseudo, bio, avatar) 
                VALUES (:name, :firstName, :email, :password, :pseudo, :bio, :avatar);"
            );

            $query->bindParam(':name', $name, PDO::PARAM_STR_CHAR);
            $query->bindParam(':firstName', $firstName, PDO::PARAM_STR_CHAR);
            $query->bindParam(':email', $email, PDO::PARAM_STR_CHAR);
            $query->bindParam(':password', $password, PDO::PARAM_STR_CHAR);
            $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR_CHAR);
            $query->bindParam(':bio', $bio, PDO::PARAM_STR_CHAR);
            $query->bindParam(':avatar',  $fileName, PDO::PARAM_STR_CHAR);            
            
            $query->execute();

            echo "<script>
            document.location.replace('http://localhost/GameLib/index.php?page=login')
            </script>";
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
    $name = $firstName = $email = $pseudo = $bio = '';
}

include 'frmInscription.php';
