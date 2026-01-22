<?php
/**
 * =====================
 * Helpers pour TomTroc
 * =====================
 *
 * Ce fichier contient des fonctions utilitaires
 * destinées à l'affichage dans les vues.
 */

/**
 * Affiche une carte HTML pour un livre
 *
 * @param array $book Tableau associatif représentant un livre
 * @return void
 */
/**
 * Affiche une carte livre
 */
function renderBookCard(array $book): void
{
?>
    <div class="book-card">
        <h3><?= htmlspecialchars($book['title']) ?></h3>
        <p>Auteur : <?= htmlspecialchars($book['author']) ?></p>
        <p>Vendu par : <?= htmlspecialchars($book['seller']) ?></p>
        <?php if (isset($book['slug'])): ?>
            <a href="/livre/<?= htmlspecialchars($book['slug']) ?>">Voir le livre</a>
        <?php elseif (isset($book['id'])): ?>
            <a href="/modifier-livre/<?= htmlspecialchars($book['id']) ?>">Modifier</a>
        <?php endif; ?>
    </div>
<?php
}


/**
 * Définit un message flash en session
 */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Affiche le message flash (si existe) puis le supprime
 */
function showFlash(): void
{
    if (!isset($_SESSION['flash'])) {
        return;
    }

    $flash = $_SESSION['flash'];

    echo "<div id='flash-message' class='flash {$flash['type']}'>{$flash['message']}</div>";

    unset($_SESSION['flash']);
}