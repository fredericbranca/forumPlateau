<div>CONNEXION</div>
<form method="POST" action="index.php?ctrl=security&action=login" enctype="multipart/form-data">
    <input type="text" id="user" name="user" maxlength="100" required placeholder="Email / Pseudo" autocomplete="off">
    <input type="password" id="password" name="password" maxlength="255" required placeholder="Mot de passe" autocomplete="off">
    <button class="bouton btn-login" type="submit" name="submitLogin" id="submit">Connexion</button>
</form>