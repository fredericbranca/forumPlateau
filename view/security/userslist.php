<?php
$users = $result["data"]['users'];

foreach($users as $user) {
?>
    <p><a href="index.php?ctrl=security&action=user&id=<?= $user->getId() ?>"><?= $user->getNickname() ?></a></p>
<?php
}