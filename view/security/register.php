<div class="sous-titre">
    <div>INSCRIPTION</div>
</div>

<form method="POST" action="index.php?ctrl=security&action=register" enctype="multipart/form-data">
    <input type="email" id="email" name="email" maxlength="100" required placeholder="Email" autocomplete="off">
    <input type="text" id="nickname" name="nickname" maxlength="15" required placeholder="Pseudo" autocomplete="off">
    <input type="password" id="password" name="password" maxlength="255" required placeholder="Mot de passe" autocomplete="off">
    <input type="password" id="confirmPassword" maxlength="255" name="confirmPassword" required placeholder="Confirmation du mot de passe" autocomplete="off">
    <button type="submit" name="submitSignUp" id="submit">Inscription</button>
    <a href="index.php?ctrl=security&action=login">Connexion</a>
</form>