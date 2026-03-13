<?php require __DIR__ . '/layout/header.php'; ?>

<h1 class="page-title">Mon compte</h1>

<div class="container">

    <!-- TOP BLOCK -->
    <div class="top-block">

        <!-- GAUCHE : Profil -->
        <div class="profile-card">

            <img src="/images/profiles/<?= htmlspecialchars($user['avatar'] ?? 'default-user.png') ?>"
                alt="Profil"
                class="profile-photo">

            <a href="#" class="link-edit">Modifier</a>

            <div class="info-group">
                <div class="label">Pseudo</div>
                <div class="value"><?= htmlspecialchars($user['username'] ?? '') ?></div>
            </div>

            <div class="info-group">
                <div class="label">Membre depuis</div>
                <div class="value"><?= htmlspecialchars($user['member_since'] ?? '1 an') ?></div>
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
                        value="<?= htmlspecialchars($user['email'] ?? '') ?>"
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
                        value="<?= htmlspecialchars($user['username'] ?? '') ?>"
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
                        <img src="/images/books/<?= htmlspecialchars($book['photo'] ?? 'default.png') ?>"
                            alt="<?= htmlspecialchars($book['title']) ?>"
                            class="book-img">
                    </div>

                    <div><?= htmlspecialchars($book['title']) ?></div>

                    <div><?= htmlspecialchars($book['author']) ?></div>

                    <div class="description">
                        <?= htmlspecialchars(strlen($book['description']) > 180
                            ? substr($book['description'], 0, 180) . '...'
                            : $book['description']) ?>
                    </div>

                    <div class="status <?= $book['available'] ? 'available' : 'unavailable' ?>">
                        <?= $book['available'] ? 'Disponible' : 'Non dispo.' ?>
                    </div>

                    <div class="actions">
                        <a class="edit" href="#">Éditer</a>
                        <a class="delete" href="#">Supprimer</a>
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