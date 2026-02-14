<?php
/**
 * =====================
 * Helpers pour TomTroc
 * =====================
 *
 * Ce fichier contient des fonctions utilitaires
 * utilisées dans plusieurs parties du projet.
 * 
 * - Génération de slug
 * - Affichage de carte livre
 * - Gestion des messages flash
 * - Utilitaires de session/utilisateur
 */


/**
 * Affiche une carte HTML pour un livre
 *
 * @param array $book Tableau associatif représentant un livre
 * @return void
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
 *
 * @param string $type  Type du message (success, error, info)
 * @param string $message Le texte du message
 * @return void
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
 *
 * @return void
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


/**
 * Retourne l'utilisateur connecté ou null
 *
 * @return array|null
 */
function user(): ?array
{
    return $_SESSION['user'] ?? null;
}


/**
 * Vérifie si un utilisateur est connecté
 *
 * @return bool
 */
function isLogged(): bool
{
    return isset($_SESSION['user']);
}


/**
 * Échappe une valeur pour l'affichage HTML
 *
 * @param string|null $value
 * @return string
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}


/**
 * Redirige vers une URL donnée
 *
 * @param string $url
 * @return void
 */
function redirect(string $url): void
{
    if (headers_sent()) {
        die('Erreur : headers déjà envoyés.');
    }

    header("Location: {$url}");
    exit;
}


/**
 * Génère un slug à partir d'un titre
 *
 * Ex: "Mon super livre !" => "mon-super-livre"
 *
 * @param string $title
 * @return string
 */
function generateSlug(string $title): string
{
    $slug = strtolower(trim($title));

    // Remplace les caractères non alphanumériques par des "-"
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    // Supprime les doublons de "-"
    $slug = preg_replace('/-+/', '-', $slug);

    return trim($slug, '-');
}
