<?php
$users = $result["data"]['users'];
?>

<h1>Utilisateurs inscrits</h1>

<?php
foreach($users as $user) {
?>
    <p><a href="index.php?ctrl=security&action=user&id=<?= $user->getId() ?>"><?= $user->getNickname() ?></a></p>
<?php
}