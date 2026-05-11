<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="book-page">

    <?php if (!empty($book)): ?>

        <!-- =========================
            FIL D’ARIANE
        ========================= -->
        <nav class="breadcrumb" aria-label="Fil d’ariane">
            <a class="bread" href="/livres">Nos livres</a>
            <span aria-hidden="true">›</span>
            <span aria-current="page"><?= htmlspecialchars($book->getTitle()) ?></span>
        </nav>

        <!-- =========================
            CONTENU PRINCIPAL DU LIVRE
        ========================= -->
        <section class="book-detail">

            <!-- IMAGE -->
            <div class="book-cover">
                <img
                    src="/images/books/<?= htmlspecialchars($book->getImage() ?: 'default.png') ?>"
                    alt="Couverture du livre <?= htmlspecialchars($book->getTitle()) ?>">
            </div>

            <!-- CONTENU -->
            <div class="book-content">

                <h1><?= htmlspecialchars($book->getTitle()) ?></h1>

                <p class="book-author">
                    par <?= htmlspecialchars($book->getAuthor()) ?>
                </p>

                <!-- DESCRIPTION -->
                <h2>Description</h2>

                <p class="descript">
                    <?= nl2br(htmlspecialchars($book->getDescription() ?: 'Pas de description')) ?>
                </p>

                <!-- PROPRIÉTAIRE -->
                <div class="book-owner">

                    <h2>Propriétaire</h2>

                    <a href="/compte-public/<?= $book->getOwner()->getId() ?>" class="owner-box">

                        <img
                            src="/images/avatars/<?= htmlspecialchars($book->getOwner()->getAvatar() ?: 'default-user.png') ?>"
                            alt="Photo de <?= htmlspecialchars($book->getOwner()->getUsername() ?: 'Utilisateur inconnu') ?>"
                            class="owner-avatar"
                            loading="lazy"
                            onerror="this.src='/images/avatars/default-user.png';">

                        <div class="owner-info">
                            <p class="owner-name">
                                <?= htmlspecialchars($book->getOwner()->getUsername() ?: 'Utilisateur inconnu') ?>
                            </p>
                        </div>

                    </a>

                    <!-- BOUTON MESSAGE -->
                    <?php if (user() && user()->getId() !== $book->getOwner()->getId()) : ?>

                        <a href="/messagerie/<?= $book->getOwner()->getId() ?>" class="btn btn-book">
                            Envoyer un message
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </section>

    <?php else: ?>

        <p>Ce livre n'existe pas ou a été supprimé.</p>

    <?php endif; ?>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>