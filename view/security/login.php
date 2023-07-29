<h1>Connexion</h1>
<form method="POST" action="index.php?ctrl=security&action=login" enctype="multipart/form-data">
    <input type="text" id="user" name="user" maxlength="100" required placeholder="Email / Pseudo" autocomplete="off">
    <input type="password" id="password" name="password" maxlength="255" required placeholder="Mot de passe" autocomplete="off">
    <button class="bouton btn-login" type="submit" name="submitLogin" id="submit">Connexion</button>
</form>

<h1>Pas encore inscrit ?</h1>
<div class="not-register">
    <a href="index.php?ctrl=security&action=register" class="btn-register-link">Inscription</a>
</div>

<?php
$style = "register-login";
