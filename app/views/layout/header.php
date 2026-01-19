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
        <div class="nav-center" aria-hidden="true"></div>

        <!-- DROITE -->
        <div class="nav-right">
            <ul class="nav-list">
                <li>
                    <a href="/messages">
                        <i class="fa fa-thin fa-comment"></i> Messagerie
                        <span class="badge" aria-label="1 nouveau message">1</span>
                    </a>
                </li>
                <li><a href="/compte"><i class="fas fa-circle-user me-2"></i>Mon compte</a></li>
                <li><a href="/connexion" class="btn">Connexion</a></li>
            </ul>
        </div>

    </nav>
</header>