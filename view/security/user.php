<?php
$user = $result["data"]['users'];
?>

<h1>Profil : <?= $user->getNickname() ?></h1>

<p>Compte créé le : <?= $user->getCreationdate() ?></p>

<?php

var_dump($user->getStatut() > new DateTime());
var_dump($user->getStatut());
var_dump(new DateTime());

if ($user->getStatut() !== "NULL" && $user->getStatut() >= new DateTime("now")) {
?>
    <p><u>Statut</u> : Compte banni jusqu'au <?= $user->getStatut() ?></p>
<?php
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