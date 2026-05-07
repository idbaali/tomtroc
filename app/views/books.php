<?php require __DIR__ . '/layout/header.php'; ?>

<main class="books-page">

    <!-- =========================
         HEADER DE LA PAGE LIVRES
    ========================= -->
    <!-- =========================
     HEADER DE LA PAGE LIVRES
========================= -->

    <div class="books-header">

        <h1 class="visually-hidden">
            <?= htmlspecialchars($title ?? 'Nos livres à l’échange') ?>
        </h1>

        <h2 class="books-title">
            Nos livres à l’échange
        </h2>

        <!-- Recherche -->
        <form method="GET" action="/livres" class="books-search-wrapper">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="search"
                name="search"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                placeholder="Rechercher un livre"
                class="books-search"
                aria-label="Rechercher un livre">

        </form>

    </div>
    <!-- =========================
         LISTE DES LIVRES
    ========================= -->
    <section class="book-grid">
        <ul class="exchange-list">

            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                    <?php include __DIR__ . '/components/_book_component.php'; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucun livre disponible</li>
            <?php endif; ?>

        </ul>
    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>