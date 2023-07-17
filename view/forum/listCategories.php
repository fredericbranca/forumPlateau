<?php

$categories = $result["data"]['categories'];
    
?>

<h1>liste categories</h1>

<?php
foreach($categories as $categorie ){

    ?>
    <a href="index.php?ctrl=topic&action=listTopicsByCategorie&id=<?= $categorie->getId() ?>"><?=$categorie->getNom()?></a>
    <?php
}