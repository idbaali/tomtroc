<?php require __DIR__ . '/layout/header.php'; ?>

<main class="auth-page">

    <section class="auth-left">
        <h1>Inscription</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form class="form" aria-label="Formulaire d’inscription" method="POST" action="/inscription">

            <label for="pseudo">Pseudo</label>
            <input id="pseudo" type="text" name="pseudo" required value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>">

            <label for="email">Adresse email</label>
            <input id="email" type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" required>

            <button class="btn-primary" type="submit">
                S’inscrire
            </button>

            <p class="auth-link">
                Déjà inscrit ?
                <a href="/connexion">Connectez-vous</a>
            </p>

        </form>
    </section>

    <section class="auth-right" aria-hidden="true">
        <img src="/images/register-photo.png" alt="">
    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>
