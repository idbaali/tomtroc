<?php require __DIR__ . '/layout/header.php'; ?>

<main class="profile-page">

    <!-- ===========================
         COLONNE GAUCHE
    ============================ -->
    <aside class="profile-left">

        <div class="avatar-wrapper">
            <img src="/images/avatars/<?= e($user->getAvatar() ?? 'default-user.png') ?>"
                alt="Photo de <?= e($user->getUsername() ?? 'Utilisateur inconnu') ?>">
        </div>

        <h2 class="username"><?= e($user->getUsername() ?? 'Utilisateur inconnu') ?></h2>

        <p class="member-since">
            Membre depuis <?= date('d/m/Y', strtotime($user->getCreatedAt())) ?>
        </p>

        <div class="library-summary">
            <h6>BIBLIOTHÈQUE</h6>
            <p class="book-count">
                <?= count($user->getBooks()) ?> livre<?= count($user->getBooks()) > 1 ? 's' : '' ?>
            </p>
        </div>

        <!-- Lien vers messagerie -->
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/messagerie?user=<?= $user->getId() ?>" class="btn-profile">
                Écrire un message
            </a>
        <?php else: ?>
            <a href="/connexion" class="btn-profile">
                Ecrivez un message
            </a>
        <?php endif; ?>

    </aside>

    <!-- ===========================
         COLONNE DROITE
    ============================ -->
    <section class="profile-right">

        <div class="library-books">

            <?php if (!empty($user->getBooks())): ?>

                <div class="library-header">
                    <div>PHOTO</div>
                    <div>TITRE</div>
                    <div>AUTEUR</div>
                    <div>DESCRIPTION</div>
                </div>

                <?php foreach ($user->getBooks() as $book): ?>
                    <article class="library-book">

                        <div class="library-photo">
                            <a href="/livre/<?= e($book->getSlug()) ?>" class="book-public-link">
                                <img src="/images/books/<?= e($book->getImage() ?? 'default.png') ?>" alt="<?= e($book->getTitle()) ?>">
                            </a>
                        </div>

                        <div class="library-title">
                            <a href="/livre/<?= e($book->getSlug()) ?>" class="book-public-link">
                                <?= e($book->getTitle()) ?>
                            </a>
                        </div>

                        <div class="library-author">
                            <?= e($book->getAuthor()) ?>
                        </div>

                        <div class="library-description">
                            <?= e($book->getDescription()) ?>
                        </div>
                    </article>
                <?php endforeach; ?>

            <?php else: ?>
                <p>Aucun livre disponible pour cet utilisateur.</p>
            <?php endif; ?>

        </div>

    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>