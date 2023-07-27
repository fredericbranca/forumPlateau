<?php
$user = $result["data"]['users'];
App\Session::renameOnlyAdmin($user)
?>

<h1>Profil : <?= $user->getNickname() ?></h1>

<p>Compte créé le : <?= $user->getCreationdateFR() ?></p>

<?php
// Vérifie si le statut est défini
if ($user->getStatut()) {
    // convertit le statut : string en object DateTime
    $statut = DateTime::createFromFormat('Y-m-d H:i:s', $user->getStatut());
    // Si la date du banissement est > à la date de maintenant, affiche jusqu'à quand l'user est banni, sinon affiche que le compte est actif
    if ($user->getStatut() !== "NULL" && $statut > new DateTime("now")) {
?>
        <p><u>Statut</u> : Compte banni jusqu'au <?= $user->getStatutFR() ?></p>
    <?php
    } else {
    ?>
        <p>Statut : Compte actif</p>
    <?php
    }
} else {
    ?>
    <p>Statut : Compte actif</p>
<?php
}

//Ban & Unban un utilisateur
if (App\Session::isAdmin() && App\Session::getUser()->getId() !== $user->getId()) {
?>
    <form method="POST" action="index.php?ctrl=security&action=restriction&id=<?= $user->getId() ?>" enctype="multipart/form-data">
        <p>Restriction utilisateur</p>
        <input type="number" id="seconde" name="seconde" min="1" step="1" required placeholder="Seconde" autocomplete="off">
        <button type="submit" name="restriction" id="submit">Valider</button>
    </form>
<?php
}

// Si l'utilisateur est admin il peut supprimer le compte de chaque utilisateur sauf le sien
// L'utilisateur peut uniquement voir le bouton supprimer sur son profile ; un visiteur ne voit pas le bouton
if (App\Session::getUser() && ((App\Session::isAdmin() && App\Session::getUser()->getId() !== $user->getId()) || (!App\Session::isAdmin() && (App\Session::getUser()->getId() === $user->getId())))) {
?>
    <form method="POST" action="index.php?ctrl=security&action=deleteUser&id=<?= $user->getId() ?>" enctype="multipart/form-data">
        <button class="delete-btn" type="submit" name="deleteUser" id="submit">Supprimer le compte</button>
    </form>
<?php
}

// Formulaire pour changer de pseudo
if (App\Session::getUser() && App\Session::getUser()->getId() === $user->getId()) {
?>
    <form method="POST" action="index.php?ctrl=security&action=changeNickname&id=<?= $user->getId() ?>" enctype="multipart/form-data">
        <input type="text" id="nickname" name="nickname" required placeholder="Nouveau pseudo" autocomplete="off">
        <button type="submit" name="changeNickname" id="submit">Modifier le pseudo</button>
    </form>
<?php
}

// Formulaire pour modifier le mot de passe
if (App\Session::getUser() && App\Session::getUser()->getId() === $user->getId()) {
?>
    <form method="POST" action="index.php?ctrl=security&action=changePassword&id=<?= $user->getId() ?>" enctype="multipart/form-data">
        <input type="password" id="password" name="oldpassword" maxlength="255" required placeholder="Ancien mot de passe" autocomplete="off">
        <input type="password" id="password" name="newpassword" maxlength="255" required placeholder="Nouveau mot de passe" autocomplete="off">
        <input type="password" id="password" maxlength="255" name="confirmNewPassword" required placeholder="Confirmation du nouveau mot de passe" autocomplete="off">
        <button type="submit" name="changePassword" id="submit">Modifier le mot de passe</button>
    </form>
<?php
}