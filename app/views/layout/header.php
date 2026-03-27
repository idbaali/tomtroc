<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Titre -->
    <title><?= $title ?? 'TomTroc' ?></title>

    <!-- CSS global -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/cf1feb7f30.js" crossorigin="anonymous"></script>

    <!-- JS global -->
    <script src="/js/main.js" defer></script>
</head>

<body>

    <!-- ================= HEADER ================= -->
    <header class="header">
        <nav class="nav" aria-label="Navigation principale">

            <!-- GAUCHE -->
            <div class="nav-left">
                <a href="/" class="logo-link" aria-label="Aller à l’accueil de TomTroc">
                    <img src="/images/logo.png" alt="TomTroc" class="logo">
                </a>

                <ul class="nav-list">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/livres">Nos livres à l’échange</a></li>
                </ul>
            </div>

            <!-- DROITE -->
            <div class="nav-right">
                <ul class="nav-list">
                    <?php if (isLogged()): ?>
                        <li><a href="/messagerie">Messagerie</a></li>

                        <li>
                            <a href="/compte">
                                <?= e(user()['username'] ?? 'Mon compte') ?>
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