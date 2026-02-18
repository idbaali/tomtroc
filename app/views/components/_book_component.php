<?php
/**
 * Composant : carte d’un livre
 * Dépend uniquement de la variable $book
 */

// Sécurisation + fallback
$title  = htmlspecialchars($book['title'] ?? 'Titre inconnu');
$author = htmlspecialchars($book['author'] ?? 'Auteur inconnu');
$seller = htmlspecialchars($book['owner_name'] ?? 'Utilisateur');
$image  = !empty($book['image'])
    ? htmlspecialchars($book['image'])
    : 'default.png';

$slug = htmlspecialchars($book['slug'] ?? '#');
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
