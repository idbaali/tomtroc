<?php require __DIR__ . '/layout/header.php'; ?>

<h2>Ma bibliothèque</h2>

<table class="table">
    <thead>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Disponibilité</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>The Kinfolk Table</td>
            <td>Nathan Williams</td>
            <td>Disponible</td>
            <td>
                <a href="/edit-book">Éditer</a> |
                <a href="#">Supprimer</a>
            </td>
        </tr>
    </tbody>
</table>

<?php require_once __DIR__ . '/layout/footer.php'; ?>

