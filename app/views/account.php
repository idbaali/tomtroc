<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Mon compte</h1>

<?php if ($user): ?>
    <p>Nom : <?= htmlspecialchars($user['username']) ?></p>
    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
    <p>Date d'inscription : <?= htmlspecialchars($user['created_at']) ?></p>
<?php else: ?>
    <p>Utilisateur non trouvé.</p>
<?php endif; ?>


<main class="account-page">

    <!-- INFOS UTILISATEUR -->
    <section class="account-info" aria-labelledby="account-title">

        <h1 id="account-title">Vos informations personnelles</h1>

        <div class="info-group">
            <span class="label">Adresse email</span>
            <span class="value">nathalie@mail.com</span>
            <a href="#" class="link-edit">Modifier</a>
        </div>

        <div class="info-group">
            <span class="label">Mot de passe</span>
            <span class="value">•••••••••</span>
            <a href="#" class="link-edit">Modifier</a>
        </div>

        <div class="info-group">
            <span class="label">Pseudo</span>
            <span class="value">nathalire</span>
        </div>

        <div class="info-meta">
            <strong>nathalire</strong><br>
            <span>Membre depuis 1 an</span>
        </div>

        <button class="btn-primary">Enregistrer</button>

    </section>

    <!-- BIBLIOTHÈQUE -->
    <section class="account-library" aria-labelledby="library-title">

        <header class="library-header">
            <h2 id="library-title">Bibliothèque</h2>
            <span class="library-count">4 livres</span>
        </header>

        <div class="library-table">

            <div class="table-head">
                <span>Photo</span>
                <span>Titre</span>
                <span>Auteur</span>
                <span>Description</span>
                <span>Disponibilité</span>
                <span>Action</span>
            </div>

            <!-- LIVRE -->
            <article class="table-row">
                <img src="/images/kinfolk.png" alt="Couverture The Kinfolk Table">

                <div>
                    <strong>The Kinfolk Table</strong>
                </div>

                <div>Nathan Williams</div>

                <p class="desc">
                    J'ai récemment plongé dans les pages de 'The Kinfolk Table'...
                </p>

                <span class="status available">Disponible</span>

                <div class="actions">
                    <a href="/edit-book">Éditer</a>
                    <a href="#" class="danger">Supprimer</a>
                </div>
            </article>

            <!-- Dupliquer les rows si besoin -->

        </div>

    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>
