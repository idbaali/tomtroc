<?php require __DIR__ . '/layout/header.php'; ?>

<h1 class="page-title">Ajouter un livre</h1>

<div class="container">

    <div class="info-card">

        <h2>Créer un nouveau livre</h2>

        <form action="/create-book" method="POST">

            <!-- TITRE -->
            <div class="info-group">
                <div class="label">Titre</div>
                <input type="text" name="title" class="value" required>
            </div>

            <!-- AUTEUR -->
            <div class="info-group">
                <div class="label">Auteur</div>
                <input type="text" name="author" class="value" required>
            </div>

            <!-- DESCRIPTION -->
            <div class="info-group">
                <div class="label">Description</div>
                <textarea name="description" class="value" rows="5" required></textarea>
            </div>

            <!-- IMAGE -->
            <div class="info-group">
                <div class="label">Nom de l’image</div>
                <input type="text" name="image" class="value" placeholder="ex: mon-livre.png">
            </div>

            <!-- BOUTON -->
            <button type="submit">Ajouter le livre</button>

        </form>

    </div>

</div>

<?php require __DIR__ . '/layout/footer.php'; ?>