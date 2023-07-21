<?php

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>

<h1><?= $topic->getTitre() ?></h1>

<div class="premierMessage">
    <div><?= $topic->getUser() ?></div>
    <div>le <?= $topic->getCreationdate() ?></div>
    <!-- htmlspecialchars_decode() convertit les entités HTML spéciales en caractères -->
    <div class="afficher-topicMessage">
        <div><?= htmlspecialchars_decode($topic->getMessage()) ?></div>
        <button onclick="changeStyle('afficher-topicMessage', 'modifier-topicMessage')">
            Modifier
        </button>
    </div>
    <form class="modifier-topicMessage" method="POST" action="index.php?ctrl=topic&action=modifyTopic&id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
        <input class="post" name="message" value="<?= $topic->getMessage() ?>">
        <button class="formulaire-btn" type="submit" name="modifyTopic" id="submit">Modifier le message</button>
    </form>
</div>

<?php
if (!empty($posts)) {
?>
    <h2>Réponses</h2>
    <div class="topicMessages">
        <?php
        foreach ($posts as $post) {
        ?>
            <div class="topicMessage">
                <div><?= $post->getUser() ?></div>
                <div>le <?= $post->getCreationdate() ?></div>
                <div><?= htmlspecialchars_decode($post->getMessage()) ?></div>
                <a href="index.php?ctrl=post&action=modifyPost&id=<?= $post->getId() ?>">Modifier</a>
            </div>
        <?php
        }
        ?>
    </div>
<?php
} else {
?>
    <h2>Ce topic n'a pas encore de réponses</h2>
<?php
}
?>

<!-- Envoyer une réponse au topic -->
<form class="formulaire" method="POST" action="index.php?ctrl=post&action=listPostsByTopic&id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
    <input class="post" name="message">
    <input type="hidden" name="userID" value="1">
    <button class="formulaire-btn" type="submit" name="answerTopic" id="submit">Poster la réponse</button>
</form>

<?php
$style = "post";
?>