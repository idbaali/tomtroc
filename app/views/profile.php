<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Profil de l'utilisateur</h1>

<?php if ($user): ?>
    <p>Nom : <?= htmlspecialchars($user['username']) ?></p>
    <p>Email : <?= htmlspecialchars($user['email']) ?></p>
    <p>Date d'inscription : <?= htmlspecialchars($user['created_at']) ?></p>
<?php else: ?>
    <p>Profil introuvable.</p>
<?php endif; ?>

<?php require __DIR__ . '/layout/footer.php'; ?>


<?php require __DIR__ . '/layout/header.php'; ?>

<main class="public-profile" aria-labelledby="profile-title">

    <!-- PROFIL PUBLIC -->
    <section class="public-user">

        <header class="public-user-header">
            <img
                src="/images/avatar.png"
                alt="Photo de profil de Alexlecture"
                class="public-avatar"
            >

            <div>
                <h1 id="profile-title">Alexlecture</h1>
                <p class="member-since">Membre depuis 1 an</p>
            </div>
        </header>

        <p class="public-bio">
            J'ai récemment plongé dans les pages de
            <em>The Kinfolk Table</em> et j'ai été enchanté par cette œuvre
            captivante. Ce livre célèbre l'art de partager des moments
            authentiques autour de la table et de la convivialité.
        </p>

        <a
            href="/messages"
            class="btn-primary"
            aria-label="Écrire un message à Alexlecture"
        >
            Écrire un message
        </a>

    </section>

    <!-- BIBLIOTHÈQUE PUBLIQUE -->
    <section class="public-library" aria-labelledby="library-title">

        <header class="public-library-header">
            <h2 id="library-title">Bibliothèque</h2>
            <span aria-label="Nombre de livres">4 livres</span>
        </header>

        <div class="public-books">

            <!-- LIVRE -->
            <article class="public-book">
                <img
                    src="/images/kinfolk.png"
                    alt="Couverture du livre The Kinfolk Table"
                >

                <div class="public-book-content">
                    <h3>The Kinfolk Table</h3>
                    <p class="author">Nathan Williams</p>

                    <p class="description">
                        J'ai récemment plongé dans les pages de
                        <em>'The Kinfolk Table'</em> et j'ai été enchanté par
                        cette œuvre captivante. Ce livre va bien au-delà
                        d'une simple collection de recettes.
                    </p>
                </div>
            </article>

            <!-- Dupliquer ce bloc pour d'autres livres -->

        </div>

    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>
