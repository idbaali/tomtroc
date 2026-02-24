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
                <img src="/images/books/<?= htmlspecialchars($book['image'] ?? 'default.png') ?>"
                    alt="Couverture du livre <?= htmlspecialchars($book['title'] ?? 'Titre inconnu') ?>">
            </div>

            <!-- DROITE : CONTENU -->
            <div class="book-content">

                <!-- TITRE PRINCIPAL -->
                <h1><?= htmlspecialchars($book['title'] ?? 'Titre inconnu') ?></h1>
                <p class="book-author">par <?= htmlspecialchars($book['author'] ?? 'Auteur inconnu') ?></p>

                <!-- DESCRIPTION -->
                <h2>Description</h2>
                <p class="descript"><?= nl2br(htmlspecialchars($book['description'] ?? 'Pas de description')) ?></p>

                <!-- PROPRIETAIRE -->
                <!-- ================= PROPRIÉTAIRE ================= -->
                <div class="book-owner">

                    <h2>Propriétaire</h2>

                    <div class="owner-box">
                        <!-- Avatar du propriétaire -->
                        <img
                            src="/images/avatars/<?= htmlspecialchars($book['owner_avatar'] ?? 'default-user.png') ?>"
                            alt="Photo de <?= htmlspecialchars($book['owner_name'] ?? 'Utilisateur inconnu') ?>"
                            class="owner-avatar"
                            loading="lazy">

                        <!-- Nom + lien vers profil -->
                        <div class="owner-info">
                            <p class="owner-name">
                                <a href="">
                                <?= htmlspecialchars($book['owner_name'] ?? 'Utilisateur inconnu') ?>
                                </a>
                            </p>
                        </div>
                    </div>

                    <!-- Bouton "Envoyer un message" uniquement si l'utilisateur est connecté et n'est pas le propriétaire -->
                    <?php if (!empty($_SESSION['user']) && $_SESSION['user']['id'] !== ($book['owner_id'] ?? 0)) : ?>
                        <a href="/messages/nouveau/<?= (int)$book['owner_id'] ?>" class="btn btn-book">
                            Envoyer un message
                        </a>
                    <?php endif; ?>

                </div>

            </div>

        </section>

    <?php else: ?>
        <!-- Si le livre n'existe pas -->
        <p>Ce livre n'existe pas ou a été supprimé.</p>
    <?php endif; ?>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>