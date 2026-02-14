<?php require __DIR__ . '/layout/header.php'; ?>

<main class="auth-page">

    <!-- Colonne gauche : formulaire d'inscription -->
    <section class="auth-left">
        <h1>Inscription</h1>

        <!-- Affichage d'un message d'erreur si présent -->
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- 
            Formulaire d'inscription
            method POST : envoi sécurisé des données
            action /inscription : route gérée par AuthController
        -->
        <form class="form" aria-label="Formulaire d’inscription" method="POST" action="/inscription">

            <label for="pseudo">Pseudo</label>
            <!-- htmlspecialchars protège contre les attaques XSS -->
            <input id="pseudo" type="text" name="pseudo" required
                value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>">

            <label for="email">Adresse email</label>
            <!-- type=email : validation HTML5 côté navigateur -->
            <input id="email" type="email" name="email" required
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

            <label for="password">Mot de passe</label>
            <!-- Jamais pré-remplir un mot de passe -->
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

    <!-- Colonne droite : image décorative -->
    <section class="auth-right" aria-hidden="true">
        <img src="/images/register-photo.png" alt="">
    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>
