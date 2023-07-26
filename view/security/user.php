<?php
$user = $result["data"]['users'];
?>

<h1>Profil : <?= $user->getNickname() ?></h1>

<p>Compte créé le : <?= $user->getCreationdate() ?></p>

<?php

// convertit le statut : string en object DateTime
if ($user->getStatut()) {
    $statut = DateTime::createFromFormat('Y-m-d H:i:s', $user->getStatut());

    // Si la date du banissement est > à la date de maintenant, affiche jusqu'à quand l'user est banni, sinon affiche que le compte est actif
    if ($user->getStatut() !== "NULL" && $statut > new DateTime("now")) {
?>
        <p><u>Statut</u> : Compte banni jusqu'au <?= $user->getStatut() ?></p>
    <?php
    }
} else {
    ?>
    <p>Statut : Compte actif</p>
<?php
}

if (App\Session::isAdmin()) {
?>
    <form method="POST" action="index.php?ctrl=security&action=deleteUser&id=<?= $user->getId() ?>" enctype="multipart/form-data">
        <button class="delete-btn" type="submit" name="deleteUser" id="submit">Supprimer le compte</button>
    </form>
<?php
}
?>