<form method="post" action="index.php?page=login">

    <label for="email"> E-mail : </label>
        <input type="texte" id="email" name="email" value="<?php echo $email;?>" /><br />
    <label for="password"> Mot de passe : </label>
        <input type="password" id="password" name="password" value="" /><br />
    <input type="reset" value="Effacer" />
    <input type="submit" value="Envoyer" name="envoi" />
</form>