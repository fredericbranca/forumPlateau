<?php
$users = $result["data"]['users'];
?>

<h1>Utilisateurs inscrits</h1>
<div class="list-users">
    <?php
    foreach ($users as $user) {
    ?>
        <a class="user" href="index.php?ctrl=security&action=user&id=<?= $user->getId() ?>"><span><?= $user->getNickname() ?></span></a>
    <?php
    } ?>
</div>

<?php

$style = "categorie-usersList";
