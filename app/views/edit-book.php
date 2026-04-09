<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="edit-book-principal">

    <nav class="bread-retour" aria-label="Fil d’ariane">
        <a href="/compte">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Retour</span>
        </a>
    </nav>

    <h1 class="bread-title">Modifier les informations</h1>

    <section class="edit-book-page">

        <div class="edit-book-card">

            <!-- BLOC GAUCHE : PHOTO -->
            <div class="edit-book-photo">
                <h2>Photo</h2>

                <img
                    src="/images/books/<?= htmlspecialchars($book->getImage() ?? 'default.png') ?>"
                    alt="Couverture du livre <?= htmlspecialchars($book->getTitle() ?? 'Livre') ?>"
                    onerror="this.src='/images/books/default.png';">

                <label class="btn-photo" for="book-image">
                    Modifier la photo
                </label>
            </div>

            <!-- BLOC DROIT : FORMULAIRE -->
            <div class="edit-book-form">
                <form method="POST" action="/edition-livre/<?= $book->getId() ?>" enctype="multipart/form-data">

                    <input type="file" id="book-image" name="image" hidden>

                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="<?= htmlspecialchars($book->getTitle() ?? '') ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="author">Auteur</label>
                        <input
                            type="text"
                            id="author"
                            name="author"
                            value="<?= htmlspecialchars($book->getAuthor() ?? '') ?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="description">Commentaire</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="10"
                            required><?= htmlspecialchars($book->getDescription() ?? '') ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="availability">Disponibilité</label>
                        <select id="availability" name="status">
                            <option value="available" <?= (($book->getStatus() ?? 'available') === 'available') ? 'selected' : '' ?>>
                                disponible
                            </option>
                            <option value="unavailable" <?= (($book->getStatus() ?? '') === 'unavailable') ? 'selected' : '' ?>>
                                non disponible
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn-primary">Valider</button>
                </form>
            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>