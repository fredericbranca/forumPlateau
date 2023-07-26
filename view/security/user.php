<?php
$user = $result["data"]['users'];
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
?>