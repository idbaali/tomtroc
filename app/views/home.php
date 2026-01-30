<?php require __DIR__ . '/layout/header.php'; ?>
<!-- <pre><?php var_dump($books); ?></pre> -->

<!-- =========================
   MAIN CONTENT
========================= -->
<main id="main-content">

    <!-- TITRE DE PAGE ACCESSIBLE -->
    <!-- Ce h1 est invisible mais lisible pour les lecteurs d'écran et SEO -->
    <!-- Le <title> change selon la variable $title passée par le contrôleur. -->
    <h1 class="visually-hidden"><?= htmlspecialchars($title ?? 'TomTroc') ?></h1>

    <!-- =========================
       HERO ACCUEIL
    ========================= -->
    <section class="hero hero-split">
        <div class="hero-text">
            <!-- Titre visible du hero -->
            <h2>Rejoignez nos <br> lecteurs passionnés</h2>
            <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
            <a href="/livres" class="btn-primary">Découvrir</a>
        </div>

        <div class="hero-image-wrapper">
            <img src="/images/hero-books.png" alt="Lecteur tenant un livre dans une bibliothèque partagée" class="hero-image">
        </div>
    </section>

    <!-- =========================
       DERNIERS LIVRES
    ========================= -->
    <section class="books" id="books">
        <h2>Les derniers livres ajoutés</h2>

        <!-- <ul class="book-list"> -->
        <?php if (!empty($books)): ?>
            <ul class="exchange-list">
                <?php foreach ($books as $book): ?>
                    <?php include __DIR__ . '/components/_book_component.php'; ?>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun livre pour le moment.</p>
        <?php endif; ?>


        <div class="see-all-books">
            <a href="/livres" class="btn-secondary">Voir tous les livres</a>
        </div>
    </section>

    <!-- =========================
       COMMENT ÇA MARCHE
    ========================= -->
    <section class="steps">
        <h2>Comment ça marche ?</h2>
        <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
        <ol class="steps-list">
            <li>Inscrivez-vous gratuitement sur notre plateforme.</li>
            <li>Ajoutez les livres que vous souhaitez échanger à votre profil.</li>
            <li>Parcourez les livres disponibles chez d'autres membres.</li>
            <li>Proposez un échange et discutez avec des passionnés de lecture.</li>
        </ol>
        <div class="see-all-books">
            <a href="/livres" class="btn-third">Voir tous les livres</a>
        </div>
    </section>

    <div class="steps-image-wrapper steps">
        <img src="/images/exchange-books.png"
            alt="Deux personnes échangeant des livres dans une bibliothèque conviviale"
            class="steps-image">
    </div>

    <!-- =========================
       NOS VALEURS
    ========================= -->
    <section class="values steps1">
        <h2>Nos valeurs</h2>
        <p>Chez TomTroc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
        <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
        <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
        <p class="Team">L’équipe TomTroc</p>
        <p><img src="/images/Vector.svg" alt="Vector" class="Vector-image"></p>
    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>