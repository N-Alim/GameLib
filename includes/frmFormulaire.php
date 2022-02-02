<form method="post" action="index.php?page=formulaire">
<label for="nom"> Nom : </label>
        <input type="texte" id="nom" name="nom" value="<?php echo $nom;?>" /><br />
    <label for="prenom"> Prénom : </label>
        <input type="texte" id="prenom" name="prenom" value="<?php echo $prenom;?>" /><br />
    <label for="email"> E-mail : </label>
        <input type="texte" id="email" name="email" value="<?php echo $email;?>" /><br />
    <label for="password"> Mot de passe : </label>
        <input type="password" id="password" name="password" value="" /><br />
    <label for="passwordRepeat"> Confirmer votre mot de passe : </label>
        <input type="password" id="passwordRepeat" name="passwordRepeat" value="" /><br />
    <input type="reset" value="Effacer" />
    <input type="submit" value="Clique-moi grand fou!"/>
    <input type="hidden" name="frm" />
</form>