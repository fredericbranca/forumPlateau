<?php

$topics = $result["data"]['topics'];
// var_dump($topics);
// die();

?>

<h1>liste topics</h1>

<?php
if (!empty($topics)) {
    foreach ($topics as $topic) {
    ?>
        <p><?= $topic->getTitre()." ".$topic->getUser() ?></p>
    <?php
    }
} else {
    echo "Aucun topic existant.";
}
?>
