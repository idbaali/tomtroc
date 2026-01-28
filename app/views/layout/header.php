<!DOCTYPE html>
<html lang="fr">

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <!-- =====================================================
         Responsive & accessibilité mobile
         Indispensable pour le bon affichage sur téléphone
    ====================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- =====================================================
         TITRE DE LA PAGE
         - $title est défini dans le contrôleur (optionnel)
         - Si absent → "TomTroc" par défaut
         - N'affecte PAS le CSS
    ====================================================== -->
    <title><?= $title ?? 'TomTroc' ?></title>

    <link rel="stylesheet" href="/css/style.css">

    <!-- =====================================================
         Font Awesome (icônes)
    ====================================================== -->
    <script src="https://kit.fontawesome.com/cf1feb7f30.js" crossorigin="anonymous"></script>
</head>

<html>
<script src="/js/main.js" defer></script>

<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <!-- ================= HEADER ================= -->
    <header class="header">

        <nav class="nav" aria-label="Navigation principale">

            <!-- GAUCHE -->
            <div class="nav-left">
                <a href="/" class="logo-link" aria-label="Aller à l’accueil de TomTroc">
                    <img src="/images/logo.png" alt="TomTroc" class="logo">
                </a>

                <ul class="nav-list">
                    <li class="debut"><a href="/">Accueil</a></li>
                    <li><a href="/livres">Nos livres à l’échange</a></li>
                </ul>
            </div>

            <!-- CENTRE -->
            <!-- <div class="nav-center" aria-hidden="true"></div> -->

            <!-- DROITE -->
            <div class="nav-right">
                <ul class="nav-list">

                    <!-- MESSAGERIE : non visible -->
                    <?php if (isset($_SESSION['user'])) : ?>

                        <li>
                            <a href="/bibliotheque">Bibliothèque</a>

                        </li>

                        <li>
                            <a href="/messages">
                                <img src="/images/icon-messagerie.png" alt="TomTroc" class="icon-messagerie"> Messagerie
                                <img src="/images/messagerie.png" alt="TomTroc" class="messagerie">
                            </a>
                        </li>

                        <!-- MON COMPTE : non visible -->
                        <li>
                            <a href="/compte">
                                <img src="/images/icon-compte.png" alt="TomTroc" class="compte"> Mon compte
                            </a>
                        </li>

                        <!-- DÉCONNEXION non visible-->
                        <li>
                            <a href="/deconnexion" class="btn">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <!-- MESSAGERIE : toujours visible -->
                        <li>
                            <a href="/connexion" class="btn">Connexion</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </nav>
        <?php showFlash(); ?>

    </header>