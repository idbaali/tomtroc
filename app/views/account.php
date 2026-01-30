<?php require __DIR__ . '/layout/header.php'; ?>

<main class="account-page">

<?php if ($user): ?>

<h1 class="account-title">Mon compte</h1>

<!-- ================= HAUT : GAUCHE / DROITE ================= -->
<section class="account-info">

    <!-- ===== GAUCHE ===== -->
    <div class="account-left">

        <a href="#" class="link-edit">Modifier</a>

        <strong class="username"><?= htmlspecialchars($user['username']) ?></strong>

        <span class="member-since">
            Membre depuis <?= htmlspecialchars($user['member_since'] ?? '1 an') ?>
        </span>

        <div class="library-resume">
            <span class="library-title">BIBLIOTHÈQUE</span>
            <span class="library-count">
                <?= isset($books) ? count($books) : 0 ?> livres
            </span>
        </div>

    </div>

    <!-- ===== DROITE ===== -->
    <div class="account-right">

        <h2>Vos informations personnelles</h2>

        <div class="info-group">
            <span class="label">Adresse email</span>
            <span class="value"><?= htmlspecialchars($user['email']) ?></span>
        </div>

        <div class="info-group">
            <span class="label">Mot de passe</span>
            <span class="value">•••••••••</span>
        </div>

        <div class="info-group">
            <span class="label">Pseudo</span>
            <span class="value"><?= htmlspecialchars($user['username']) ?></span>
        </div>

        <button class="btn-primary">Enregistrer</button>

    </div>

</section>

<!-- ================= BAS : BIBLIOTHÈQUE ================= -->
<section class="account-library">

    <h2>Bibliothèque</h2>

    <div class="library-books">

        <!-- EN-TÊTE -->
        <div class="library-header">
            <div>PHOTO</div>
            <div>TITRE</div>
            <div>AUTEUR</div>
            <div>DESCRIPTION</div>
            <div>DISPONIBILITÉ</div>
            <div>ACTION</div>
        </div>

        <!-- ROW 1 -->
        <article class="library-book">
            <div class="library-photo">
                <img src="/images/books/kinfolk.png" alt="The Kinfolk Table">
            </div>

            <div class="library-title">The Kinfolk Table</div>

            <div class="library-author">Nathan Williams</div>

            <div class="library-description">
                J'ai récemment plongé dans les pages de "The Kinfolk Table" et j'ai été enchanté par cette œuvre captivante...
            </div>

            <div class="library-status available">Disponible</div>

            <div class="library-actions">
                <a href="#">Éditer</a>
                <a href="#" class="danger">Supprimer</a>
            </div>
        </article>

        <!-- ROW 2 -->
        <article class="library-book">
            <div class="library-photo">
                <img src="/images/books/kinfolk.png">
            </div>
            <div class="library-title">The Kinfolk Table</div>
            <div class="library-author">Nathan Williams</div>
            <div class="library-description">Description du livre…</div>
            <div class="library-status unavailable">Non dispo.</div>
            <div class="library-actions">
                <a href="#">Éditer</a>
                <a href="#" class="danger">Supprimer</a>
            </div>
        </article>

        <!-- ROW 3 -->
        <article class="library-book">
            <div class="library-photo">
                <img src="/images/books/kinfolk.png">
            </div>
            <div class="library-title">The Kinfolk Table</div>
            <div class="library-author">Nathan Williams</div>
            <div class="library-description">Description du livre…</div>
            <div class="library-status available">Disponible</div>
            <div class="library-actions">
                <a href="#">Éditer</a>
                <a href="#" class="danger">Supprimer</a>
            </div>
        </article>

        <!-- ROW 4 -->
        <article class="library-book">
            <div class="library-photo">
                <img src="/images/books/kinfolk.png">
            </div>
            <div class="library-title">The Kinfolk Table</div>
            <div class="library-author">Nathan Williams</div>
            <div class="library-description">Description du livre…</div>
            <div class="library-status unavailable">Non dispo.</div>
            <div class="library-actions">
                <a href="#">Éditer</a>
                <a href="#" class="danger">Supprimer</a>
            </div>
        </article>

    </div>

</section>

<?php else: ?>
<p>Utilisateur non trouvé.</p>
<?php endif; ?>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>
