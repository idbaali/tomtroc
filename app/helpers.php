<?php
/**
 * Helpers pour TomTroc
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
