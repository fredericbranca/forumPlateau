<?php

$categories = $result["data"]['categories'];

?>

<h1>Catégories</h1>

<div class="list-categorie">
    <?php
    foreach ($categories as $categorie) {

    ?>
        <a class="categorie" href="index.php?ctrl=topic&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>"><span><?= $categorie->getNom() ?></span></a>
    <?php
    } ?>
</div>

<?php

$style = "categorie";
