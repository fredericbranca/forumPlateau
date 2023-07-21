<form class="formulaire" method="POST" action="index.php?ctrl=topic&action=createTopic" enctype="multipart/form-data">
<input class="titre" type="text" id="titre" name="titre" maxlength="50" required autocomplete="off" placeholder="Titre de la discussion">
<input class="post" name="message">
<input type="hidden" name="userID" value="1">
<input type="hidden" name="categorie" value="1">
<button class="formulaire-btn" type="submit" name="createTopic" id="submit">Poster la discussion</button>
</form>

<?php

$style = "topics";