<?php

// Liste des topics ou liste des topics par catégorie
$categories = $result["data"]['categories'];

?>

<form class="formulaire" method="POST" action="index.php?ctrl=topic&action=createTopic" enctype="multipart/form-data">
    <input class="titre" type="text" id="titre" name="titre" maxlength="50" required autocomplete="off" placeholder="Titre de la discussion">
    <select name="categorie" id="categorie" required>
        <option value="">--Choisir une catégorie--</option>
        <?php
        foreach ($categories as $categorie) {
        ?>
            <option value="<?= $categorie->getId() ?>"><?= $categorie->getNom() ?></option>
        <?php
        }
        ?>

    </select>
    <input class="post" name="message">
    <button class="formulaire-btn" type="submit" name="createTopic" id="submit">Poster la discussion</button>
</form>

<?php

$style = "topics";
