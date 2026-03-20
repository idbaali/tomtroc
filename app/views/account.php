<?php require __DIR__ . '/layout/header.php'; ?>

<h1 class="page-title">Mon compte</h1>

<div class="container">

    <!-- TOP BLOCK -->
    <div class="top-block">

        <!-- GAUCHE : Profil -->
        <div class="profile-card">

            <img src="/images/profiles/<?= e($user['avatar'] ?? 'default-user.png') ?>"
                alt="Profil"
                class="profile-photo">

            <a href="#" class="link-edit">Modifier</a>

            <div class="info-group">
                <div class="label">Pseudo</div>
                <div class="value"><?= e($user['username'] ?? '') ?></div>
            </div>

            <div class="info-group">
                <div class="label">Membre depuis</div>
                <div class="value">
                    <?= !empty($user['created_at']) 
                        ? date('d/m/Y', strtotime($user['created_at'])) 
                        : '1 an' ?>
                </div>
            </div>

            <div class="info-group">
                <div class="label">BIBLIOTHÈQUE</div>
                <div class="value"><?= isset($books) ? count($books) : 0 ?> livres</div>
            </div>

        </div>

        <!-- DROITE -->
        <div class="info-card">

            <h2>Vos informations personnelles</h2>

            <form action="/update-profile.php" method="post">

                <div class="info-group">
                    <div class="label">Adresse email</div>
                    <input type="email"
                        name="email"
                        class="value"
                        value="<?= e($user['email'] ?? '') ?>"
                        required>
                </div>

                <div class="info-group">
                    <div class="label">Mot de passe</div>
                    <input type="password"
                        name="password"
                        class="value"
                        placeholder="•••••••••">
                </div>

                <div class="info-group">
                    <div class="label">Pseudo</div>
                    <input type="text"
                        name="username"
                        class="value"
                        value="<?= e($user['username'] ?? '') ?>"
                        required>
                </div>

                <button type="submit">Enregistrer</button>

            </form>

        </div>

    </div>

    <!-- TABLE -->
    <div class="library-table">

        <!-- HEADER -->
        <div class="table-row header">
            <div>PHOTO</div>
            <div>TITRE</div>
            <div>AUTEUR</div>
            <div>DESCRIPTION</div>
            <div>DISPONIBILITÉ</div>
            <div>ACTION</div>
        </div>

        <?php if (!empty($books)): ?>

            <?php foreach ($books as $book): ?>
                <div class="table-row">

                    <div>
                        <img src="/images/books/<?= e($book->getImage() ?? 'default.png') ?>"
                            alt="<?= e($book->getTitle()) ?>"
                            class="book-img">
                    </div>

                    <div><?= e($book->getTitle()) ?></div>
                    <div><?= e($book->getAuthor()) ?></div>

                    <div class="description">
                        <?= e(strlen($book->getDescription()) > 180
                            ? substr($book->getDescription(), 0, 180) . '...'
                            : $book->getDescription()) ?>
                    </div>

                    <div class="status <?= $book->isAvailable() ? 'available' : 'unavailable' ?>">
                        <?= $book->isAvailable() ? 'Disponible' : 'Non dispo.' ?>
                    </div>

                    <div class="actions">
                        <a class="edit" href="/livre/modifier/<?= $book->getId() ?>">Éditer</a>

                        <a class="delete"
                           href="/livre/supprimer/<?= $book->getId() ?>"
                           title="Supprimer ce livre"
                           onclick="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                           Supprimer
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php else: ?>

            <div class="table-row">
                <div style="grid-column:1/-1;text-align:center;">
                    Aucun livre dans votre bibliothèque.
                </div>
            </div>

        <?php endif; ?>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>