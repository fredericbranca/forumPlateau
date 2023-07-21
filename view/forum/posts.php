<?php

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];

?>

<h1><?= $topic->getTitre() ?></h1>

<div class="premierMessage">
    <div><?= $topic->getUser() ?></div>
    <div>le <?= $topic->getCreationdate() ?></div>
    <!-- htmlspecialchars_decode() convertit les entités HTML spéciales en caractères -->
    <div><?= htmlspecialchars_decode($topic->getMessage()) ?></div>
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
                <div><?= $post->getMessage() ?></div>
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



<?php
$style = "post";
?>