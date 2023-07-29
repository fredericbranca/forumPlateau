<?php

// Liste des topics ou liste des topics par catégorie
$topics = $result["data"]['topics'];

// Si une catégorie est sélectionné, donne à $catégorie le contenu categorie par ID
if (isset($result["data"]["categorie"])) {
    $categorie = $result["data"]["categorie"];
}

?>

<h1>Forums
    <?php
    // Affiche la catégorie si la page est trié par catégorie
    if (!empty($categorie)) {
        echo " - " . $categorie->getNom();
    } ?>
</h1>

<a href="index.php?ctrl=topic&action=createTopic">Créer une nouvelle discussion</a>
<?php
if (!empty($topics)) {
?>
    <div class="TopicTable">
        <?php
        foreach ($topics as $topic) {
            App\Session::renameOnlyAdmin($topic->getUser());
        ?>
            <ul class="TopicList" onclick="document.location = 'index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>'">
                <li>
                    Titre : <?= $topic->getTitre() ?>
                </li>
                <li>
                    Catégorie : <?= $topic->getCategorie() ?>
                </li>
                <li>
                    <?php if (!$topic->getUser()) {
                        echo "Utilisateur supprimé";
                    } else {
                        echo $topic->getUser();
                    } ?>
                </li>
                <li>
                    Créé le <?= $topic->getCreationdate() ?>
                </li>
                <li>
                    <?= $topic->getMessagecount() < 1 ? "Aucune réponse" : $topic->getMessagecount() . " réponses" ?>
                </li>
                <!-- <li> -->
                <?= $topic->getLastPostDate() ? "<li>Répondu le : " . $topic->getLastPostDate() . "</li>" : "" ?>
                <!-- </li> -->
                <li>
                    <?php
                    if ($topic->getClosed()) { ?>
                        Fermé
                    <?php } else { ?>
                        Ouvert
                    <?php } ?>
                </li>
                <!-- Si l'user en session a le rôle admin -->
                <?php if (App\Session::isAdmin()) { ?>
                    <li>
                        <!-- Bouton pour supprimer le topic -->
                        <form method="POST" action="index.php?ctrl=topic&action=deleteTopic&id=<?= $topic->getId() ?>" enctype="multipart/form-data">
                            <button class="delete-btn" type="submit" name="deleteTopic" id="submit">Supprimer le topic</button>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        <?php }
    } else { ?>
        <div>Aucun topic existant dans cette catégorie</div>
    <?php }

    $style = "topics";
