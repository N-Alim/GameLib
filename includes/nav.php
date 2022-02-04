<header>
    <nav>
        <ul>
            <li><a href="index.php?page=home">Home</a> </li>
            <li><a href="index.php?page=news">News</a></li>
            <?php
                if (isset($_SESSION["login"]) && $_SESSION["login"] === true)
                    echo "<li><a href=\"index.php?page=logout\">Logout</a></li>";
                else
                    echo "<li><a href=\"index.php?page=login\">Login</a></li>";

            ?>

            <li><a href="index.php?page=formulaire">Formulaire</a></li>
            <li><a href="index.php?page=contact">Contact</a></li>
        </ul>
    </nav>
</header>