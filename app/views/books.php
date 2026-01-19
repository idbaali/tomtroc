<?php require __DIR__ . '/layout/header.php'; ?>

<main class="books-page">

    <!-- =========================
         HEADER DE LA PAGE LIVRES
    ========================= -->
    <div class="books-header">
        <h1 class="visually-hidden">
            <?= htmlspecialchars($title ?? 'Nos livres à l’échange') ?>
        </h1>
        <h2 class="books-title">Nos livres à l’échange</h2>

        <!-- Barre de recherche accessible -->
        <input type="search"
            placeholder="Rechercher un livre"
            class="books-search"
            aria-label="Rechercher un livre">
    </div>

    <!-- =========================
         LISTE DES LIVRES
    ========================= -->
    <section class="book-grid">
        <ul class="exchange-list">

            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <?php
                    // Sécurisation des données (évite les Deprecated)
                    $id     = (int) ($book['id'] ?? 0);
                    $title  = htmlspecialchars($book['title'] ?? 'Titre inconnu');
                    $author = htmlspecialchars($book['author'] ?? 'Auteur inconnu');
                    $seller = htmlspecialchars($book['seller'] ?? 'Utilisateur inconnu');
                    $image  = htmlspecialchars($book['image'] ?? 'default.png');
                    ?>

                    <!-- Carte cliquable sans lien -->
                    <a href="/livre/<?= htmlspecialchars($book['slug']) ?>" class="exchange-card">
                        <img src="/images/<?= $image ?>" alt="Couverture du livre <?= $title ?>">
                        <h3><?= $title ?></h3>
                        <p class="author"><?= $author ?></p>
                        <p class="seller">Vendu par : <?= $seller ?></p>
                    </a>

                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucun livre disponible pour le moment.</li>
            <?php endif; ?>

        </ul>
    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>