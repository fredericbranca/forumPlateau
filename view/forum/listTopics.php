<?php

$topics = $result["data"]['topics'];

?>

<h1>liste topics</h1>

<table class="topics-table">
    <thead>
        <tr>
            <th>Discussion</th>
            <th>Créé par</th>
            <th>Créé le</th>
            <th>Réponses</th>
            <th>Dernier post</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($topics)) {
            foreach ($topics as $topic) {
        ?>
                <tr onclick="document.location = 'index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>'">
                    <td><?= $topic->getTitre() ?></td>
                    <td><?= $topic->getUser() ?></td>
                    <td><?= $topic->getCreationdate() ?></td>
                    <td>nb réponse</td>
                    <td>dernier post</td>
                </tr>
            <?php
            }
            ?>
    </tbody>
</table>
<?php
        } else {
            echo "Aucun topic existant.";
        }

$style = "topics";
?>