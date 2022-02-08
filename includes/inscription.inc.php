<?php

if (isset ($_POST['inscription'])) 
{
    // htmlentities, addslashes, strip_tags, htmlspecialchars font à peu près le même travail
    $name = htmlentities(trim(mb_strtoupper($_POST['name']))) ?? '';
    $firstName = htmlentities(ucfirst(mb_strtolower(trim($_POST['firstName'])))) ?? '';
    $email = mb_strtolower(trim(htmlentities($_POST['email']))) ?? '';
    $password = trim(htmlentities($_POST["password"]));
    $passwordRepeat = trim(htmlentities($_POST["passwordRepeat"]));
    $pseudo = trim(htmlentities($_POST['pseudo'])) ?? '';
    $bio = trim(htmlentities($_POST['bio'])) ?? '';
    
    $erreur = array(); //Tableau vide

    if (!preg_match("/(*UTF8)^[[:alpha:]]+$/", html_entity_decode($name)))
    {
        array_push($erreur, "Veuillez saisir votre nom");
    }
    else
    {
        $name = html_entity_decode($name);
    }

    if (!preg_match("/(*UTF8)^[[:alpha:]]+$/", html_entity_decode($firstName)))
    {
        array_push($erreur, "Veuillez saisir votre prenom");
    }
    else
    {
        $firstName = html_entity_decode($firstName);
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
            $fileName = getcwd() . "/avatars/" . $fileName;
            $fileName = str_replace("\\", "/", $fileName);


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

        }

        else
        {
            array_push($erreur, "Erreur type MIME");
        }
    }

    else
    {
        $fileError = "";
        switch ($_FILES["avatar"]["error"])
        {
            case 1:
                $fileError = " La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini.";
                break;
            
            case 2:
                $fileError = "La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.";
                break;

            case 3:
                $fileError = "Le fichier n'a été que partiellement téléchargé.";
                break;

            case 4:
                $fileError = "Aucun fichier n'a été téléchargé.";
                break;

            case 6:
                $fileError = "Un dossier temporaire est manquant.";
                break;

            case 7:
                $fileError = "Échec de l'écriture du fichier sur le disque.";
                break;
            
            case 8:
                $fileError = "Une extension PHP a arrêté l'envoi de fichier. PHP ne propose aucun moyen de déterminer quelle extension est en cause. L'examen du phpinfo() peut aider.";
                break;

        }
        array_push($erreur, $fileError);
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


            $requete = $conn->prepare("SELECT * FROM users WHERE email='$email'");
            $requete->execute();
            $resultat = $requete->fetchAll(PDO::FETCH_OBJ);

            if(count($resultat) !== 0) 
            {
                echo "<p>Votre adresse est déjà enregistrée dans la base de données</p>";
            }

            else 
            {
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
