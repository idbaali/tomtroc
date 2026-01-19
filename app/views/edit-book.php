<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="edit-book-principal">
    <!-- Fil d’Ariane -->
    <nav class="bread-retour" aria-label="Fil d’ariane">
        <a href="/books">retour</a>
    </nav>
    <h2>Modifier les informations</h2>

    <section class="edit-book-page">

        <!-- Contenu principal -->
        <section class="edit-book-detail">
            <!-- Photo livre / aperçu -->
            <div class="edit-book-photo">
                <h2>Photo</h2>
                <img src="/images/kinfolk.png" alt="Couverture du livre The Kinfolk Table">
                <a href="#" class="">Modifier la photo</a>
            </div>
            <!-- Formulaire édition -->
            <div class="edit-book-form">

                <form aria-label="Formulaire d'édition de livre">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" value="The Kinfolk Table" required>

                    <label for="author">Auteur</label>
                    <input type="text" id="author" name="author" value="Nathan Williams" required>

                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="6" required>
                        J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre captivante...
                    </textarea>

                    <label for="availability">Disponibilité</label>
                    <select id="availability" name="availability">
                        <option value="disponible" selected>Disponible</option>
                        <option value="non_disponible">Non disponible</option>
                    </select>

                    <button type="submit" class="btn-edit">Valider</button>
                </form>
            </div>

        </section>
    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>