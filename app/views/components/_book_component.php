<?php

/** @var \App\Models\Book $book */

$title  = htmlspecialchars($book->getTitle() ?? 'Titre inconnu');
$author = htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu');

$owner = $book->getOwner();
$seller = htmlspecialchars($owner ? $owner->getUsername() : 'Utilisateur');

$image = $book->getImage()
    ? htmlspecialchars($book->getImage())
    : 'default.png';

$slug = htmlspecialchars($book->getSlug());
?>


<a href="/livre/<?= urlencode($book->getSlug()) ?>" class="exchange-card">

        <img
            src="/images/books/<?= $image ?>"
            alt="Couverture du livre <?= $title ?>"
            loading="lazy">

        <h3><?= $title ?></h3>

        <p class="author"><?= $author ?></p>

        <p class="seller">
            Vendu par : <?= $seller ?>
        </p>

    </a>