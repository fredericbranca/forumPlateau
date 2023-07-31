<?php

// Liste des topics ou liste des topics par catégorie
$topics = $result["data"]['topics'];

// Si une catégorie est sélectionné, donne à $catégorie le contenu categorie par ID
if (isset($result["data"]["categorie"])) {
    $categorie = $result["data"]["categorie"];
}

?>
<div class="header">
    <h1>Forums
        <?php
        // Affiche la catégorie si la page est trié par catégorie
        if (!empty($categorie)) {
            echo " - " . $categorie->getNom();
        } ?>
    </h1>
    <a class="btn-link" href="index.php?ctrl=topic&action=createTopic">Nouvelle discussion</a>
</div>

<?php
if (!empty($topics)) {
?>
    <div class="responsive-table">
        <div class="topicTable">
            <?php
            foreach ($topics as $topic) {
                App\Session::renameOnlyAdmin($topic->getUser());
            ?>
                <ul onclick="document.location = 'index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>'">
                    <div class="header-topic">
                        <li class="text-topic">
                            <?= $topic->getCategorie() ?>
                        </li>
                        <li class="titre">
                            <?= $topic->getClosed() ? '<i class="fa-sharp fa-solid fa-lock"></i> ' . $topic->getTitre() : '<i class="fa-solid fa-lock-open"></i> ' . $topic->getTitre() ?>
                        </li>
                        <li class="text-topic">Par
                            <?php if (!$topic->getUser()) {
                                echo "Utilisateur supprimé";
                            } else {
                                echo $topic->getUser();
                            } ?>
                            - <?= $topic->getCreationdate() ?>
                        </li>
                    </div>
                    <div class="infos-topic">
                        <li class="text-topic">
                            <?= $topic->getMessagecount() < 1 ? "0 réponse" : $topic->getMessagecount() . " réponses" ?>
                            <?= $topic->getLastPostDate() ? " - " . $topic->getLastPostDate() . "</li>" : "" ?>
                            <!-- </li> -->
                    </div>
                </ul>
                <!-- Si l'user en session a le rôle admin -->
                <?php if (App\Session::isAdmin()) { ?>
                    <li>
                        <!-- Bouton pour supprimer le topic -->
                        <form method="POST" action="index.php?ctrl=topic&action=deleteTopic&id=<?= $topic->getId() ?>" enctype="multipart/form-data">
                            <button class="delete-btn" type="submit" name="deleteTopic" id="submit">Supprimer le topic</button>
                        </form>
                    </li>
                <?php } ?>
            <?php }
        } else { ?>
            <div>Aucun topic existant dans cette catégorie</div>
        <?php } ?>
        </div>
    </div>

    <?php
    $style = "topics";
