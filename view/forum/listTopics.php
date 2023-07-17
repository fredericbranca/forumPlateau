<?php

$topics = $result["data"]['topics'];

?>

<h1>liste topics</h1>

<?php
if (!empty($topics)) {
    foreach ($topics as $topic) {
    ?>
        <p><?= $topic->getTitre() ?></p>
    <?php
    }
} else {
    echo "Aucun topic existant.";
}
?>
