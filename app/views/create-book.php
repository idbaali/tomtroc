<?php require __DIR__ . '/layout/header.php'; ?>

<?php
// Anciennes valeurs du formulaire si erreur
$old = $_SESSION['old_create_book'] ?? [
    'title' => '',
    'author' => '',
    'description' => '',
    'image' => ''
];
?>

<main class="create-book-page">

    <!-- ===========================
         TITRE DE PAGE
    ============================ -->
    <h1 class="page-title">Ajouter un livre</h1>

    <div class="container">

        <section class="form-card">

            <!-- ===========================
                 EN-TÊTE
            ============================ -->
            <div class="form-card-header">
                <h2>Créer un nouveau livre</h2>
                <p class="form-intro">
                    Remplissez les informations ci-dessous pour ajouter un livre à votre bibliothèque d’échange.
                </p>
            </div>

            <!-- ===========================
                 FORMULAIRE
            ============================ -->
            <form action="/creation-livre" method="POST" class="book-form">

                <!-- TITRE -->
                <div class="form-group">
                    <label for="title">Titre du livre</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control"
                        placeholder="Ex : Wabi Sabi"
                        value="<?= e($old['title'] ?? '') ?>"
                        required>
                </div>

                <!-- AUTEUR -->
                <div class="form-group">
                    <label for="author">Auteur</label>
                    <input
                        type="text"
                        id="author"
                        name="author"
                        class="form-control"
                        placeholder="Ex : Beth Kempton"
                        value="<?= e($old['author'] ?? '') ?>"
                        required>
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="6"
                        placeholder="Décrivez brièvement le livre, son contenu ou son intérêt..."
                        required><?= e($old['description'] ?? '') ?></textarea>
                </div>

                <!-- IMAGE -->
                <div class="form-group">
                    <label for="image">Nom de l’image</label>
                    <input
                        type="text"
                        id="image"
                        name="image"
                        class="form-control"
                        placeholder="Ex : mon-livre.png"
                        value="<?= e($old['image'] ?? '') ?>">
                    <small class="form-help">
                        Indiquez le nom du fichier image déjà présent dans le dossier des images.
                    </small>
                </div>

                <!-- ACTIONS -->
                <div class="form-actions">
                    <a href="/compte" class="btn-secondary">Annuler</a>
                    <button type="submit" class="btn-primary">Ajouter le livre</button>
                </div>

            </form>

        </section>

    </div>

</main>

<?php
// ✅ On efface les anciennes valeurs après affichage
unset($_SESSION['old_create_book']);
?>

<?php require __DIR__ . '/layout/footer.php'; ?>