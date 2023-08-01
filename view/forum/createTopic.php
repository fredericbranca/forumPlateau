<?php

// Liste des topics ou liste des topics par catégorie
$categories = $result["data"]['categories'];

?>

<div class="header">
    <h1>Creation d'un nouveau sujet</h1>
</div>
<form class="create-topic" method="POST" action="index.php?ctrl=topic&action=createTopic" enctype="multipart/form-data">
    <input type="text" id="titre" name="titre" maxlength="50" required autocomplete="off" placeholder="Titre de la discussion">
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
    <textarea class="post" name='message' placeholder="Un message par jour éloigne l'ennui pour toujours ! Qu'avez-vous à dire aujourd'hui ? 🗓️😄"></textarea>
    <button class="btn" type="submit" name="createTopic" id="submit">Poster la discussion</button>
</form>

<?php

$style = "topics";
