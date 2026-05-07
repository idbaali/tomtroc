<?php require __DIR__ . '/layout/header.php'; ?>

<?php
/** @var \App\Models\User $user */
?>

<main class="profile-page">

    <aside class="profile-left">

        <div class="avatar-wrapper">
            <img src="/images/profiles/<?= e($user->getAvatar() ?? 'default-user.png') ?>"
                alt="Photo de <?= e($user->getUsername() ?? 'Utilisateur inconnu') ?>"
                onerror="this.src='/images/profiles/default-user.png';">
        </div>

        <h2 class="username"><?= e($user->getUsername() ?? 'Utilisateur inconnu') ?></h2>

        <?php
        $createdAt = new DateTime($user->getCreatedAt());
        $now = new DateTime();

        $interval = $createdAt->diff($now);

        if ($interval->y > 0) {
            $memberSince = $interval->y . ' an' . ($interval->y > 1 ? 's' : '');
        } elseif ($interval->m > 0) {
            $memberSince = $interval->m . ' mois';
        } else {
            $memberSince = $interval->d . ' jour' . ($interval->d > 1 ? 's' : '');
        }
        ?>

        <div class="member-since">
            Membre depuis <?= $memberSince ?>
        </div>

        <div class="library-summary">
            <h6>BIBLIOTHÈQUE</h6>

            <div class="book-count">
                <img
                    src="/images/icons/vector.svg"
                    alt=""
                    class="icon-books">

                <?= count($user->getBooks()) ?> livre<?= count($user->getBooks()) > 1 ? 's' : '' ?>
            </div>
        </div>

        <?php if (isset($_SESSION['user']) && $_SESSION['user']->getId() !== $user->getId()): ?>
            <a href="/messagerie/<?= $user->getId() ?>" class="btn-profile">
                Écrire un message
            </a>
        <?php elseif (!isset($_SESSION['user'])): ?>
            <a href="/connexion" class="btn-profile">
                Écrire un message
            </a>
        <?php endif; ?>

    </aside>

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
                                <img src="/images/books/<?= e($book->getImage() ?? 'default.png') ?>"
                                    alt="<?= e($book->getTitle()) ?>">
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