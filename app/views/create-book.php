<?php require __DIR__ . '/layout/header.php'; ?>

<?php
$old = $_SESSION['old_create_book'] ?? [
    'title' => '',
    'author' => '',
    'description' => '',
    'status' => 'available'
];
?>

<main class="create-book-principal">

    <!-- RETOUR -->
    <div class="bread-retour">
        <a href="/compte">← retour</a>
    </div>

    <!-- TITRE -->
    <h1 class="bread-title">Ajouter un livre</h1>

    <section class="edit-book-page">

        <form
            action="/creation-livre"
            method="POST"
            enctype="multipart/form-data"
            class="edit-book-card"
            novalidate>

            <!-- COLONNE GAUCHE : PHOTO -->
            <div class="edit-book-photo">
                <h2>Photo</h2>

                <img
                    src=""
                    alt=""
                    id="book-preview">


                <p class="photo-placeholder">
                    L'image sera affichée après l'ajout du livre
                </p>

                <label for="image" class="btn-photo">
                    Ajouter une photo
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="sr-only">
            </div>

            <!-- COLONNE DROITE : FORMULAIRE -->
            <div class="edit-book-form">

                <div class="form-group">
                    <label for="title">Titre</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="<?= e($old['title'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="author">Auteur</label>
                    <input
                        type="text"
                        id="author"
                        name="author"
                        value="<?= e($old['author'] ?? '') ?>"
                        required>
                </div>

                <div class="form-group">
                    <label for="description">Commentaire</label>
                    <textarea
                        id="description"
                        name="description"
                        required><?= e($old['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Disponibilité</label>
                    <select id="status" name="status">
                        <option value="available" <?= ($old['status'] ?? '') === 'available' ? 'selected' : '' ?>>
                            disponible
                        </option>
                        <option value="unavailable" <?= ($old['status'] ?? '') === 'unavailable' ? 'selected' : '' ?>>
                            non disponible
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn-edit">
                    Ajouter le livre
                </button>

            </div>

        </form>

    </section>

</main>

<?php unset($_SESSION['old_create_book']); ?>

<?php require __DIR__ . '/layout/footer.php'; ?>