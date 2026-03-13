<?php require __DIR__ . '/layout/header.php'; ?>

<main class="profile-page">

    <!-- ===========================
         COLONNE GAUCHE
    ============================ -->
    <aside class="profile-left">

        <div class="avatar-wrapper">
            <img src="/images/avatars/<?= htmlspecialchars($user->getAvatar() ?? 'default-user.png') ?>"
                alt="Photo de <?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu') ?>">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $user->getId()): ?>
                <span class="status-online">En ligne</span>
            <?php endif; ?>
        </div>

        <h2 class="username"><?= htmlspecialchars($user->getUsername() ?? 'Utilisateur inconnu') ?></h2>
        <p class="member-since">Membre depuis <?= htmlspecialchars($user->getCreatedAt() ?? 'inconnu') ?></p>

        <div class="library-summary">
            <h6>BIBLIOTHÈQUE</h6>
            <p class="book-count"><?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?></p>
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
                                <img src="/images/books/<?= htmlspecialchars($book->getImage() ?? 'default-book.png') ?>"
                                    alt="<?= htmlspecialchars($book->getTitle()) ?>">
                            </div>
                            <div class="library-title"><?= htmlspecialchars($book->getTitle()) ?></div>
                            <div class="library-author"><?= htmlspecialchars($book->getAuthor()) ?></div>
                            <div class="library-description"><?= htmlspecialchars($book->getDescription()) ?></div>
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