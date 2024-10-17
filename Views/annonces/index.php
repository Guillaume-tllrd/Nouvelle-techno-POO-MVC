<h1>Liste des annonces</h1>

<!-- j'accède à ma var grâce au render du controller -->
<!-- <?php var_dump($annonces) ?> -->
<?php
foreach ($annonces as $annonce): ?>
    <article>
        <!-- <h2><?= $annonce['titre'] ?></h2> -->
        <!-- comme on a changé le FETCH_ASSOC par FECTH_OBJ dans le Db on peut écrire de façon objet -->
        <h2><a href="/annonces/lire/<?= $annonce->id ?>"><?= $annonce->titre ?></a></h2>
        <p><?= $annonce->description ?></p>
    </article>
<?php endforeach; ?>