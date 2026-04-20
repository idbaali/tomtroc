<?php require __DIR__ . '/layout/header.php'; ?>

<h1 class="page-title">Mon compte</h1>

<div class="container">

    <!-- TOP BLOCK -->
    <div class="top-block">

        <!-- GAUCHE : Profil -->
        <div class="profile-card">

            <img src="/images/profiles/<?= e($user->getAvatar() ?? 'default-user.png') ?>"
                alt="Profil de <?= e($user->getUsername() ?? 'Utilisateur') ?>"
                class="profile-photo">

            <a href="#" class="link-edit">Modifier</a>

            <div class="profile-name">
                <?= e($user->getUsername() ?? 'Utilisateur') ?>
            </div>

            <div class="info-group">
                <div class="value profile-value">
                    Membre depuis
                    <?= $user->getCreatedAt() ? date('d/m/Y', strtotime($user->getCreatedAt())) : '1 an' ?>
                </div>
            </div>

            <div class="info-group">
                <div class="label">BIBLIOTHÈQUE</div>
                <div class="value profile-value books-count">
                    <img src="/images/icons/vector.svg" alt="" class="icon-books">
                    <?= count($books ?? []) ?> livres
                </div>
            </div>

            <div class="account-actions">
                <a href="/creation-livre" class="btn-ajouter">+ Ajouter un livre</a>
            </div>

        </div>


        <!-- DROITE : Informations personnelles -->
        <div class="info-card">

            <h2>Vos informations personnelles</h2>

            <form action="/update-profile.php" method="post">

                <div class="info-group">
                    <label class="label" for="email">Adresse email</label>
                    <input type="email"
                        id="email"
                        name="email"
                        class="value"
                        value="<?= e($user->getEmail() ?? '') ?>"
                        required>
                </div>

                <div class="info-group">
                    <label class="label" for="password">Mot de passe</label>
                    <input type="password"
                        id="password"
                        name="password"
                        class="value"
                        placeholder="•••••••••">
                </div>

                <div class="info-group">
                    <label class="label" for="username">Pseudo</label>
                    <input type="text"
                        id="username"
                        name="username"
                        class="value"
                        value="<?= e($user->getUsername() ?? '') ?>"
                        required>
                </div>

                <button type="submit">Enregistrer</button>

            </form>

        </div>

    </div>

    <!-- TABLE BIBLIOTHÈQUE -->
    <div class="library-table">

        <!-- HEADER -->
        <div class="table-row header">
            <div class="table-cell">PHOTO</div>
            <div class="table-cell">TITRE</div>
            <div class="table-cell">AUTEUR</div>
            <div class="table-cell">DESCRIPTION</div>
            <div class="table-cell">DISPONIBILITÉ</div>
            <div class="table-cell">ACTION</div>
        </div>

        <?php if (!empty($books)): ?>

            <?php foreach ($books as $book): ?>
                <div class="table-row">

                    <div class="table-cell">
                        <a href="/livre/<?= e($book->getSlug()) ?>">
                            <img src="/images/books/<?= e($book->getImage() ?? 'default.png') ?>"
                                alt="<?= e($book->getTitle()) ?>"
                                class="book-img">
                        </a>
                    </div>

                    <div class="table-cell">
                        <a href="/livre/<?= e($book->getSlug()) ?>" class="book-link">
                            <?= e($book->getTitle()) ?>
                        </a>
                    </div>

                    <div class="table-cell">
                        <?= e($book->getAuthor()) ?>
                    </div>

                    <div class="table-cell description">
                        <?= e(strlen($book->getDescription()) > 180
                            ? substr($book->getDescription(), 0, 180) . '...'
                            : $book->getDescription()) ?>
                    </div>

                    <div class="table-cell">
                        <span class="status <?= $book->getStatus() === 'available' ? 'available' : 'unavailable' ?>">
                            <?= $book->getStatus() === 'available' ? 'Disponible' : 'Non dispo.' ?>
                        </span>
                    </div>

                    <div class="table-cell actions">
                        <a class="edit" href="/edition-livre/<?= $book->getId() ?>">Éditer</a>

                        <a class="delete"
                            href="/supprimer-livre/<?= $book->getId() ?>"
                            onclick="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                            Supprimer
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php else: ?>

            <div class="table-row">
                <div class="table-cell empty-library">
                    Aucun livre dans votre bibliothèque.
                </div>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>