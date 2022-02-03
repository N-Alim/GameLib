<form method="post" action="index.php?page=login">

    <label for="mail"> E-mail : </label>
        <input type="texte" id="mail" name="mail" value="<?php echo $mail;?>" /><br />
    <label for="password"> Mot de passe : </label>
        <input type="password" id="password" name="password" value="" /><br />
    <input type="reset" value="Effacer" />
    <input type="submit" value="Envoyer" name="envoi" />
</form>