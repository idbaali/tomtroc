<?php
/**
 * Composant : carte d’un livre
 * Dépend uniquement de la variable $book (objet Book)
 */

// Sécurisation + fallback
$title  = htmlspecialchars($book->getTitle() ?? 'Titre inconnu');
$author = htmlspecialchars($book->getAuthor() ?? 'Auteur inconnu');
$seller = htmlspecialchars($book->getSeller() ?? 'Utilisateur');

$image  = $book->getImage()
    ? htmlspecialchars($book->getImage())
    : 'default.png';

$slug = htmlspecialchars($book->getSlug() ?? '#');
?>

<a href="/livre/<?= $slug ?>" class="exchange-card">

    <img
        src="/images/books/<?= $image ?>"
        alt="Couverture du livre <?= $title ?>"
        loading="lazy"
    >

    <h3><?= $title ?></h3>

    <p class="author"><?= $author ?></p>

    <p class="seller">
        Vendu par : <?= $seller ?>
    </p>

</a>