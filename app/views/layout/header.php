<?php
$currentPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title><?= $title ?? 'TomTroc' ?></title>

    <link rel="stylesheet" href="/css/style.css">

    <script src="https://kit.fontawesome.com/cf1feb7f30.js" crossorigin="anonymous"></script>

    <script src="/js/main.js" defer></script>
</head>

<body>

    <header class="header">
        <nav class="nav" aria-label="Navigation principale">

            <div class="nav-group-left">
                <a href="/" class="logo-link" aria-label="Aller à l’accueil de TomTroc">
                    <img src="/images/logo.png" alt="TomTroc" class="logo">
                </a>

                <div class="nav-left">
                    <ul class="nav-list">
                        <li>
                            <a href="/" class="<?= $currentPath === '' ? 'active' : '' ?>">
                                Accueil
                            </a>
                        </li>

                        <li>
                            <a href="/livres" class="<?= $currentPath === 'livres' ? 'active' : '' ?>">
                                Nos livres à l’échange
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="nav-right">
                <ul class="nav-list">
                    <?php if (isLogged()): ?>
                        <li>
                            <a href="/messagerie" class="nav-icon-link <?= str_starts_with($currentPath, 'messagerie') ? 'active' : '' ?>">
                                <i class="fa-regular fa-comment" aria-hidden="true"></i>
                                <span>Messagerie</span>
                                <span class="message-badge">1</span>
                            </a>
                        </li>

                        <li>
                            <a href="/compte" class="nav-icon-link <?= $currentPath === 'compte' ? 'active' : '' ?>">
                                <i class="fa-regular fa-user" aria-hidden="true"></i>
                                <span>Mon compte</span>
                            </a>
                        </li>

                        <li>
                            <a href="/deconnexion" class="btn-nav">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="/connexion" class="btn-nav">Connexion</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

        </nav>


        <?php showFlash(); ?>
    </header>