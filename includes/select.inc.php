
<?php
try 
{
    $serverName = "localhost";
        $userName = "root";
        $userPassword = "";
        $database = "exercice";


    $conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $userPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requete = $conn->prepare("SELECT DISTINCT * FROM utilisateurs ORDER BY nom DESC");

    $requete->execute();
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    echo tabAffichage($resultat);
}
    
catch (PDOException $e)
{
    die("Erreur : " . $e->getMessage());
}

function tabAffichage(Array $tab) : string
{
    
    $result = "<table>
    <thead>
        <tr>
            <td> Id </td>
            <td> Nom </td>
            <td> Prénom </td>
            <td> Mail </td>
        </tr>
    </thead>";
    for ($cnt=0; $cnt < count($tab); $cnt++) 
    {
        $result .= "<tr>";

        foreach ($tab[$cnt] as $key => $value) 
        {
            if ($key !== "mdp")
            {
                $result .= "<td> $value </td>";
            }
        }

        $result .= "<tr>";

    }

    $result .= "</table>";

    return $result;
}

