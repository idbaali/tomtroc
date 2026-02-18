<?php require __DIR__ . '/layout/header.php'; ?>

<main class="profile-page">

    <!-- ===========================
         COLONNE GAUCHE
    ============================ -->
    <aside class="profile-left">

        <div class="avatar-wrapper">
            <img src="/images/avatars/<?= htmlspecialchars($user['avatar'] ?? 'default-user.png') ?>"
                alt="Photo de <?= htmlspecialchars($user['username'] ?? 'Utilisateur inconnu') ?>">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $user['id']): ?>
                <span class="status-online">En ligne</span>
            <?php endif; ?>
        </div>

        <h2 class="username"><?= htmlspecialchars($user['username'] ?? 'Utilisateur inconnu') ?></h2>
        <p class="member-since">Membre depuis <?= htmlspecialchars($user['created_at'] ?? 'inconnu') ?></p>

        <div class="library-summary">
            <h3>BIBLIOTHÈQUE</h3>
            <p class="book-count">4 livres</p>
        </div>

        <a href="#" class="btn-primary-profile">Écrire un message</a>

    </aside>


    <!-- ===========================
         COLONNE DROITE
    ============================ -->
    <section class="profile-right">

        <!-- Bibliothèque -->
        <section class="profile-library">
            <h2>Bibliothèque</h2>

            <div class="library-books">
                <?php if (!empty($books)): ?>
                    <div class="library-header">
                        <div>PHOTO</div>
                        <div>TITRE</div>
                        <div>AUTEUR</div>
                        <div>DESCRIPTION</div>
                    </div>

                    <?php foreach ($books as $book): ?>
                        <article class="library-book">
                            <div class="library-photo">
                                <img src="/images/books/<?= htmlspecialchars($book['image'] ?? 'default-book.png') ?>"
                                    alt="<?= htmlspecialchars($book['title']) ?>">
                            </div>
                            <div class="library-title"><?= htmlspecialchars($book['title']) ?></div>
                            <div class="library-author"><?= htmlspecialchars($book['author']) ?></div>
                            <div class="library-description"><?= htmlspecialchars($book['description']) ?></div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun livre disponible pour cet utilisateur.</p>
                <?php endif; ?>
            </div>

        </section>


    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>