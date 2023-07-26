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
                <th>Catégorie</th>
                <th>Créé par</th>
                <th>Créé le</th>
                <th>Réponses</th>
                <th>Dernier post</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($topics as $topic) {
            ?>
                <tr onclick="document.location = 'index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>'">
                    <td><?= $topic->getTitre() ?></td>
                    <td><?= $topic->getCategorie() ?></td>
                    <!-- Si l'user n'existe pas, affiche  "Utilisateur supprimé" sinon affiche l'user-->
                    <td><?php if (!$topic->getUser()) {
                            echo "Utilisateur supprimé";
                        } else {
                            echo $topic->getUser();
                        } ?></td>
                    <td><?= $topic->getCreationdate() ?></td>
                    <td><?= $topic->getMessagecount() ?></td>
                    <td>date</td>
                    <td>
                        <?php
                        if ($topic->getClosed()) {
                        ?>
                            Fermé
                        <?php
                        } else {
                        ?>
                            Ouvert
                        <?php
                        }
                        ?>
                    </td>
                    <?php
                    if (App\Session::isAdmin()) {
                    ?>
                        <td>
                            <!-- Bouton pour supprimer le topic -->
                            <form method="POST" action="index.php?ctrl=topic&action=deleteTopic&id=<?= $topic->getId() ?>" enctype="multipart/form-data">
                                <button class="delete-btn" type="submit" name="deleteTopic" id="submit">Supprimer le topic</button>
                            </form>
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
