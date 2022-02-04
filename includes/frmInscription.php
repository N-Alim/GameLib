<form method="post" action="index.php?page=inscription" enctype="multipart/form-data">
    <label for="name"> Nom : </label>
        <input type="texte" id="name" name="name" value="<?php echo $name;?>" /><br />
    <label for="firstName"> Prénom : </label>
        <input type="texte" id="firstName" name="firstName" value="<?php echo $firstName;?>" /><br />
    <label for="email"> E-mail : </label>
        <input type="texte" id="email" name="email" value="<?php echo $email;?>" /><br />
    <label for="pseudo"> Pseudo : </label>
        <input type="texte" id="pseudo" name="pseudo" value="<?php echo $pseudo;?>" /><br />
    <label for="password"> Mot de passe : </label>
        <input type="password" id="password" name="password" value="" /><br />
    <label for="passwordRepeat"> Confirmer votre mot de passe : </label>
        <input type="password" id="passwordRepeat" name="passwordRepeat" value="" /><br />
    <label for="bio"> Bio : </label>
        <textarea id="bio" name="bio" value="<?php echo $bio;?>"></textarea><br />
    <label for="avatar">Avatar :</label>
        <input type="file" id="avatar" name="avatar" value="<?php echo $avatar;?>">

    <input type="reset" value="Effacer" />
    <input type="submit" value="S'inscrire" name="inscription"/>
</form>