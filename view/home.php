<h1>BIENVENUE SUR LE FORUM</h1>

<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit ut nemo quia voluptas numquam, itaque ipsa soluta ratione eum temporibus aliquid, facere rerum in laborum debitis labore aliquam ullam cumque.</p>

<?php
if (!App\Session::getUser()) {
?>
    <p>
        <a href="index.php?ctrl=security&action=login">Se connecter</a>
        <span>&nbsp;-&nbsp;</span>
        <a href="index.php?ctrl=security&action=register">S'inscrire</a>
    </p>
<?php
}
