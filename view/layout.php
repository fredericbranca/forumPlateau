<?php
// Check si l'user en session existe dans la db
if (App\Session::getUser()) {
    //Récupère l'id de l'user en session
    $sessionUserId = App\Session::getUser()->getId();
    // Utilise la method findOneById() du Manager
    $userManager = new Model\Managers\UserManager;
    $userExist = $userManager->findOneById($sessionUserId);
    // Supprime la session si l'user existe pas
    if (!$userExist) {
        App\Session::unsetUser();
        header("Location:index.php?ctl=topic");
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/de7e6c09fa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
    <?php
    if (isset($style)) {
    ?>
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/<?= $style ?>.css">
    <?php
    }
    ?>
    <title>FORUM</title>
</head>

<body>
    <div id="wrapper" data-theme="dark">

        <div id="mainpage">
            <header>
                <div id="navbar">
                    <div class="hamburger" onclick="toggleMenu()">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                    <nav id="myNav" class="nav-links">
                        <ul>
                            <div class="nav-row">
                                <li><a href="index.php?ctrl=topic">Accueil</a></li>
                                <li><a href="index.php?ctrl=categorie">Catégories</a></li>

                                <?php
                                if (App\Session::isAdmin()) {
                                ?>
                                    <li><a href="index.php?ctrl=security&action=users">Utilisateurs</a></li>
                                <?php
                                } ?>
                            </div>
                            <div class="nav-row">
                                <?php
                                if (App\Session::getUser()) { ?>
                                    <li><a href="index.php?ctrl=security&action=user"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser() ?></a></li>
                                    <li><a href="index.php?ctrl=security&action=logout">Déconnexion</a></li>
                                <?php
                                } else { ?>
                                    <li><a href="index.php?ctrl=security&action=login">Connexion</a></li>
                                    <li><a href="index.php?ctrl=security&action=register">Inscription</a></li>
                                <?php
                                } ?>
                            </div>
                        </ul>
                    </nav>
                </div>
            </header>
            <div class="overlay"></div>

            <main id="forum">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <?= $page ?>
            </main>
        </div>
        <footer id="footer">
            <p>&copy; 2020 - <?= date('Y') ?> - Forum CDA - <a href="/home/forumRules.html">Règlement du forum</a> - <a href="">Mentions légales</a></p>
            <!--<button id="ajaxbtn">Surprise en Ajax !</button> -> cliqué <span id="nbajax">0</span> fois-->
        </footer>
    </div>
    <script type="text/javascript" src="<?= PUBLIC_DIR ?>/js/script.js"></script>
    <script type="text/javascript" src="<?= PUBLIC_DIR ?>/js/forum-height.js"></script>
    <?php
    if (isset($js)) {
    ?>
        <script type="text/javascript" src="<?= PUBLIC_DIR ?>/js/<?= $js ?>.js"></script>
    <?php
    }
    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(".message").each(function() {
                if ($(this).text().length > 0) {
                    $(this).slideDown(500, function() {
                        $(this).delay(3000).slideUp(500)
                    })
                }
            })
            $(".delete-btn").on("click", function() {
                return confirm("Etes-vous sûr de vouloir supprimer?")
            })
            tinymce.init({
                selector: '.post',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_css: '//www.tiny.cloud/css/codepen.min.css',

                // Ajout de css sur le formulaire
                content_style: `
                .mce-content-body:not([dir=rtl])[data-mce-placeholder]:not(.mce-visualblocks)::before {
                left: 10px;
                }
                .mce-content-body {
                    padding-left: 10px;
                }
                `
            });
        })



        /*
        $("#ajaxbtn").on("click", function(){
            $.get(
                "index.php?action=ajax",
                {
                    nb : $("#nbajax").text()
                },
                function(result){
                    $("#nbajax").html(result)
                }
            )
        })*/
    </script>
</body>

</html>