<?php require __DIR__ . '/layout/header.php'; ?>

<main class="login-page">
    <section class="login-left" aria-labelledby="login-title">
        <h2 id="login-title">Connexion</h2>

        <form class="form" aria-label="Formulaire de connexion">
            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn btn-primary">Connexion</button>

            <p class="auth-link">
                Pas de compte ?
                <a href="/inscription">Inscrivez-vous</a>
            </p>

        </form>
    </section>

    <section class="login-right" aria-hidden="true">
        <img src="/images/login-photo.png" alt="">
    </section>
</main>

<?php require __DIR__ . '/layout/footer.php'; ?>