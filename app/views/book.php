<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="book-page">

    <?php if (!empty($book)): ?>

        <!-- =========================
            FIL D’ARIANE
        ========================= -->
        <nav class="breadcrumb" aria-label="Fil d’ariane">
            <a class="bread" href="/livres">Nos livres</a>
            <span aria-hidden="true">›</span>
            <span aria-current="page"><?= htmlspecialchars($book['title'] ?? 'Titre inconnu') ?></span>
        </nav>

        <!-- =========================
            CONTENU PRINCIPAL DU LIVRE
        ========================= -->
        <section class="book-detail">

            <!-- GAUCHE : IMAGE DU LIVRE -->
            <div class="book-cover">
                <img src="/images/<?= htmlspecialchars($book['image'] ?? 'default.png') ?>"
                     alt="Couverture du livre <?= htmlspecialchars($book['title'] ?? 'Titre inconnu') ?>">
            </div>

            <!-- DROITE : CONTENU -->
            <div class="book-content">

                <!-- TITRE PRINCIPAL -->
                <h1><?= htmlspecialchars($book['title'] ?? 'Titre inconnu') ?></h1>
                <p class="book-author">par <strong><?= htmlspecialchars($book['author'] ?? 'Auteur inconnu') ?></strong></p>

                <!-- DESCRIPTION -->
                <h2>Description</h2>
                <p><?= nl2br(htmlspecialchars($book['description'] ?? 'Pas de description')) ?></p>

                <!-- PROPRIETAIRE -->
                <div class="book-owner">
                    <h2>Propriétaire</h2>
                    <p class="owner-name"><?= htmlspecialchars($book['owner_name'] ?? 'Utilisateur inconnu') ?></p>

                    <a href="#" class="btn-book">
                        Envoyer un message
                    </a>
                </div>

            </div>

        </section>

    <?php else: ?>
        <!-- Si le livre n'existe pas -->
        <p>Ce livre n'existe pas ou a été supprimé.</p>
    <?php endif; ?>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
