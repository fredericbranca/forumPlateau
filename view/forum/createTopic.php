<form class="formulaire" method="POST" action="index.php?action=topic" enctype="multipart/form-data">
<input class="titre" type="text" id="titre" name="titre" maxlength="50" required autocomplete="off" placeholder="Titre de la discussion">
<div class="post"></div>
<button class="formulaire-btn" type="submit" name="submit" id="submit">Poster la discussion</button>
</form>

<?php

$style = "topics";