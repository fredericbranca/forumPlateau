<?php

// Liste des topics ou liste des topics par catégorie
$topics = $result["data"]['topics'];

// Si une catégorie est sélectionné, donne à $catégorie le contenu categorie par ID
if (isset($result["data"]["categorie"])) {
    $categorie = $result["data"]["categorie"];
}

?>

<h1>Liste des topics
    <?php
    // Affiche la catégorie si la page est trié par catégorie
    if (!empty($categorie)) {
        echo " - Catégorie : " . $categorie->getNom();
    }
    ?>
</h1>

<a href="index.php?ctrl=topic&action=createTopic">Créer une nouvelle discussion</a>
<?php
if (!empty($topics)) {
?>
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
            foreach ($topics as $topic) {
            ?>
                <tr onclick="document.location = 'index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>'">
                    <td><?= $topic->getTitre() ?></td>
                    <td><?= $topic->getUser() ?></td>
                    <td><?= $topic->getCreationdate() ?></td>
                    <td>nb réponse</td>
                    <td>dernier post</td>
                    <?php
                    if (App\Session::isAdmin()) {
                    ?>
                        <td>
                            <a href="index.php?ctrl=topic&action=deleteTopic&id=<?= $topic->getId() ?>">Supprimer le topic</a>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php
} else {
?>
    <div>Aucun topic existant dans cette catégorie</div>
<?php
}
$style = "topics";
