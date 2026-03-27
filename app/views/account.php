<?php require __DIR__ . '/layout/header.php'; ?>

<h1 class="page-title">Mon compte</h1>

<div class="container">

    <!-- TOP BLOCK -->
    <div class="top-block">

        <!-- GAUCHE : Profil -->
        <div class="profile-card">

            <img src="/images/profiles/<?= e($user['avatar'] ?? 'default-user.png') ?>"
                alt="Profil de <?= e($user['username'] ?? 'Utilisateur') ?>"
                class="profile-photo">

            <a href="#" class="link-edit">Modifier</a>

            <div class="info-group">
                <div class="label">Membre depuis</div>
                <div class="value profile-value">
                    <?= !empty($user['created_at'])
                        ? date('d/m/Y', strtotime($user['created_at']))
                        : '1 an' ?>
                </div>
            </div>

            <div class="info-group">
                <div class="label">BIBLIOTHÈQUE</div>
                <div class="value profile-value"><?= isset($books) ? count($books) : 0 ?> livres</div>
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
                        value="<?= e($user['email'] ?? '') ?>"
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
                        value="<?= e($user['username'] ?? '') ?>"
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
                        <img src="/images/books/<?= e($book->getImage() ?? 'default.png') ?>"
                            alt="<?= e($book->getTitle()) ?>"
                            class="book-img">
                    </div>

                    <div class="table-cell">
                        <?= e($book->getTitle()) ?>
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