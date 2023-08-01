<?php

$posts = $result["data"]['posts'];
$topic = $result["data"]['topic'];
App\Session::renameOnlyAdmin($topic->getUser());

?>

<div class="header">
    <h2><?= $topic->getTitre() ?> - <?= $topic->getCategorie() ?></h2>
    <?php
    // Fermer ou ouvrir le topic
    // Un utilisateur peut fermer son topic mais ne peut pas le rouvrir, un admin peut verouiller et déverouiller
    if (App\Session::isAdmin() || (!$topic->getClosed() && ($topic->getUser() && (App\Session::getUser() && App\Session::getUser()->getId() === $topic->getUser()->getId())))) {
        $statut = $topic->getClosed() ? 'Ouvrir' : 'Fermer';
    ?>
        <form method="POST" action="index.php?ctrl=topic&action=<?= $statut ?>&id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
            <button class="btn-link" type="submit" name="<?= $statut ?>" id="submit"><?= $statut ?> le topic</button>
        </form>
    <?php
    } ?>
</div>

<div class="responsive-table">
    <div class="postTable">
        <ul>
            <div class="info-post">
                <li class="utilisateur">
                    <!-- Si l'user n'existe pas, affiche  "Utilisateur supprimé" sinon affiche l'user-->
                    <?php if (!$topic->getUser()) {
                        echo "Utilisateur supprimé";
                    } else {
                        echo $topic->getUser();
                    } ?>
                </li>
                <li class="date">Posté le <?= $topic->getCreationdate();
                                            echo $topic->getModifiedMessageDate() !== null ? "<div>Modifier le : " . $topic->getModifiedMessageDate() . "</div>" : ""; ?>
                </li>
                <!-- htmlspecialchars_decode() convertit les entités HTML spéciales en caractères -->
                <li class="mess"><?= htmlspecialchars_decode($topic->getMessage()) ?></li>
            </div>
            <li class="afficher-topicMessage">
                <?php
                if (App\Session::isAdmin() || (!$topic->getClosed() && ($topic->getUser() && (App\Session::getUser() && App\Session::getUser()->getId() === $topic->getUser()->getId())))) {
                ?>
                    <button class="btn" onclick="changeStyle('afficher-topicMessage', 'modifier-topicMessage')">
                        Modifier
                    </button>
                <?php
                }
                if (App\Session::isAdmin()) {
                ?>
                    <!-- Bouton pour supprimer le topic -->
                    <form method="POST" action="index.php?ctrl=topic&action=deleteTopic&id=<?= $topic->getId() ?>" enctype="multipart/form-data">
                        <button class="delete-btn" type="submit" name="deleteTopic" id="submit">Supprimer le topic</button>
                    </form>
                <?php
                }
                ?>
            </li>
            <?php
            if (App\Session::isAdmin() || (!$topic->getClosed() && ($topic->getUser() && (App\Session::getUser() && App\Session::getUser()->getId() === $topic->getUser()->getId())))) {
            ?>
                <div class="modifier-topicMessage">
                    <form method="POST" action="index.php?ctrl=topic&action=modifyTopic&id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
                        <input class="post" name="message" value="<?= $topic->getMessage() ?>">
                        <button class="btn" type="button" onclick="changeStyle('modifier-topicMessage', 'afficher-topicMessage')">
                            Annuler
                        </button>
                        <button class="btn" type="submit" name="modifyTopic" id="submit">Modifier le message</button>
                    </form>
                </div>
            <?php
            }
            ?>
        </ul>
    </div>
</div>

<?php
if (!empty($posts)) {
?>
    <div class="header">
        <h2>Réponses</h2>
    </div>
    <div class="responsive-table">
        <div class="postTable">
            <?php
            foreach ($posts as $post) {
                App\Session::renameOnlyAdmin($post->getUser());
            ?>
                <ul>
                    <div class="info-post">
                        <li class="utilisateur">
                            <!-- Si l'user n'existe pas, affiche  "Utilisateur supprimé" sinon affiche l'user-->
                            <?php if (!$post->getUser()) {
                                echo "Utilisateur supprimé";
                            } else {
                                echo $post->getUser();
                            } ?>
                        </li>
                        <li class="date">Posté le <?= $post->getCreationdate();
                                                    echo $post->getModifiedMessageDate() !== null ? "<div>Modifier le : " . $post->getModifiedMessageDate() . "</div>" : ""; ?>
                        </li>
                        <li class="mess"><?= htmlspecialchars_decode($post->getMessage()) ?></li>
                    </div>
                    <li class="afficher-topicMessage<?= $post->getId() ?>">
                        <?php
                        if (App\Session::isAdmin() || (!$topic->getClosed() && ($post->getUser() && (App\Session::getUser() && App\Session::getUser()->getId() === $post->getUser()->getId())))) {
                        ?>
                            <button class="btn" onclick="changeStyle('afficher-topicMessage<?= $post->getId() ?>', 'modifier-topicMessage<?= $post->getId() ?>')">
                                Modifier
                            </button>
                            <form method="POST" action="index.php?ctrl=post&action=deleteTopicMessage&id=<?= $post->getId() ?>" enctype="multipart/form-data">
                                <button class="delete-btn" type="submit" name="deleteTopicMessage" id="submit">Supprimer le message</button>
                            </form>
                        <?php
                        }
                        ?>
                    </li>
                    <?php
                    if (App\Session::isAdmin() || (!$topic->getClosed() && ($post->getUser() && (App\Session::getUser() && App\Session::getUser()->getId() === $post->getUser()->getId())))) {
                    ?>
                        <li class="modifier-topicMessage<?= $post->getId() ?>">
                            <form method="POST" action="index.php?ctrl=post&action=modifyTopicMessage&id=<?= $post->getId() ?>" enctype="multipart/form-data">
                                <input id="message" class="post" name="message" value="<?= $post->getMessage() ?>">
                                <button class="btn" type="button" onclick="changeStyle('modifier-topicMessage<?= $post->getId() ?>', 'afficher-topicMessage<?= $post->getId() ?>')">
                                    Annuler
                                </button>
                                <button class="btn" type="submit" name="modifyTopicMessage" id="submit">Modifier le message</button>
                            </form>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            <?php
            }
            ?>
        </div>
    </div>
<?php
} else {
?>
    <div class="header">
        <h2>Ce topic n'a pas encore de réponses</h2>
    </div>
<?php
}
// Si le topic est ouvert et que l'user est en session ou que l'user est admin
if ((!$topic->getClosed() && App\Session::getUser()) || App\Session::isAdmin()) {
?>
    <!-- Envoyer une réponse au topic -->
    <div class="header">
        <h2>Postez votre réponse !</h2>
    </div>
    <form class="formulaire" method="POST" action="index.php?ctrl=post&action=answerTopic&id=<?= $_GET['id'] ?>" enctype="multipart/form-data">
        <textarea class="post" name='message' placeholder='Tapez votre réponse avec style 💃'></textarea>
        <button class="btn" type="submit" name="answerTopic" id="submit">Poster la réponse</button>
    </form>
<?php
    // Si le topic est fermé
} elseif ($topic->getClosed()) {
?>
    <div class="header">
        <h2>Le topic est fermé</h2>
    </div>
<?php
    // Si l'utilisateur n'est pas inscrit
} else {
?>
    <div class="no-message"><a href="index.php?ctrl=security&action=register">Inscrivez-vous pour répondre à ce sujet</a></div>
<?php
}
$style = "topics";
?>