<?php
/**
 * Composant : carte d’un livre
 * Dépend uniquement de la variable $book
 */

$title  = htmlspecialchars($book['title']  ?? '');
$author = htmlspecialchars($book['author'] ?? '');
$seller = htmlspecialchars($book['seller'] ?? '');
$image  = htmlspecialchars($book['image']  ?? 'default.png');
$slug   = htmlspecialchars($book['slug']   ?? '#');
?>

<a href="/livre/<?= $slug ?>" class="exchange-card">

    <img
        src="/images/<?= $image ?>"
        alt="Couverture du livre <?= $title ?>"
        loading="lazy"
    >

    <h3><?= $title ?></h3>

    <p class="author"><?= $author ?></p>

    <p class="seller">
        Vendu par : <?= $seller ?>
    </p>

</a>
