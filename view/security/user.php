<?php
$user = $result["data"]['users'];
App\Session::renameOnlyAdmin($user)
?>

<div class="header-user">
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
            <p>Statut : Compte banni jusqu'au <?= $user->getStatutFR() ?></p>
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
    } ?>

</div>
<div class="content">
    <?php

    //Ban & Unban un utilisateur
    if (App\Session::isAdmin() && App\Session::getUser()->getId() !== $user->getId()) {
    ?>
        <form class="bannir" method="POST" action="index.php?ctrl=security&action=restriction&id=<?= $user->getId() ?>" enctype="multipart/form-data">
            <h2>Restriction utilisateur</h2>
            <input type="number" id="seconde" name="seconde" min="1" step="1" required placeholder="Seconde" autocomplete="off">
            <div>
                <button class="btn" type="button" onclick="hideFormProfile('.bannir')">Annuler</button>
                <button class="btn" type="submit" name="restriction" id="submit">Valider</button>
            </div>
        </form>
        <button class="btn display-bannir" type="button" onclick="displayFormProfile('.bannir')">Bannir</button>
    <?php
    }

    // Si l'utilisateur est admin il peut supprimer le compte de chaque utilisateur sauf le sien
    // L'utilisateur peut uniquement voir le bouton supprimer sur son profile ; un visiteur ne voit pas le bouton
    if (App\Session::getUser() && ((App\Session::isAdmin() && App\Session::getUser()->getId() !== $user->getId()) || (!App\Session::isAdmin() && (App\Session::getUser()->getId() === $user->getId())))) {
    ?>
        <form method="POST" action="index.php?ctrl=security&action=deleteUser&id=<?= $user->getId() ?>" enctype="multipart/form-data">
            <button class="delete-btn display-delete" type="submit" name="deleteUser" id="submit">Supprimer le compte</button>
        </form>
    <?php
    }

    // Formulaire pour changer de pseudo
    if (App\Session::getUser() && App\Session::getUser()->getId() === $user->getId()) {
    ?>
        <form class="modif-nickname" method="POST" action="index.php?ctrl=security&action=changeNickname&id=<?= $user->getId() ?>" enctype="multipart/form-data">
            <h2>Modifier votre pseudo</h2>
            <input type="text" id="nickname" name="nickname" required placeholder="Nouveau pseudo" autocomplete="off">
            <div>
                <button class="btn" type="button" onclick="hideFormProfile('.modif-nickname')">Annuler</button>
                <button class="btn" type="submit" name="changeNickname" id="submit">Modifier le pseudo</button>
            </div>
        </form>
        <button class="btn display-modif-nickname" type="button" onclick="displayFormProfile('.modif-nickname')">Changer de pseudo</button>
    <?php
    }

    // Formulaire pour modifier le mot de passe
    if (App\Session::getUser() && App\Session::getUser()->getId() === $user->getId()) {
    ?>
        <form class="modif-pass" method="POST" action="index.php?ctrl=security&action=changePassword&id=<?= $user->getId() ?>" enctype="multipart/form-data">
            <h2>Modifier votre mot de passe</h2>
            <input type="password" id="password" name="oldpassword" maxlength="255" required placeholder="Ancien mot de passe" autocomplete="off">
            <input type="password" id="password" name="newpassword" maxlength="255" required placeholder="Nouveau mot de passe" autocomplete="off">
            <input type="password" id="password" maxlength="255" name="confirmNewPassword" required placeholder="Confirmation du nouveau mot de passe" autocomplete="off">
            <div>
                <button class="btn" type="button" onclick="hideFormProfile('.modif-pass')">Annuler</button>
                <button class="btn" type="submit" name="changePassword" id="submit">Modifier le mot de passe</button>
            </div>
        </form>
        <button class="btn display-modif-pass" type="button" onclick="displayFormProfile('.modif-pass')">Modifier votre mot de passe</button>
    <?php
    } ?>

</div>

<?php

$style = "user";
