<?php require __DIR__ . '/layout/header.php'; ?>

<main class="profile-page">

    <!-- ===========================
         COLONNE GAUCHE
    ============================ -->
    <aside class="profile-left">

        <div class="avatar-wrapper">
            <img src="/images/avatars/default-user.png" alt="Photo de Alexlecture" class="avatar">
            <span class="status-online">En ligne</span>
        </div>

        <h2 class="username">Alexlecture</h2>
        <p class="member-since">Membre depuis 1 an</p>

        <div class="library-summary">
            <h3>BIBLIOTHÈQUE</h3>
            <p class="book-count">4 livres</p>
        </div>

        <a href="#" class="btn-primary-profile">Écrire un message</a>

    </aside>


    <!-- ===========================
         COLONNE DROITE
    ============================ -->
    <section class="profile-right">

        <!-- Bibliothèque -->
        <section class="profile-library">
            <h2>Bibliothèque</h2>

            <div class="library-books">

                <!-- EN-TÊTES row -->
                <div class="library-header">
                    <div>PHOTO</div>
                    <div>TITRE</div>
                    <div>AUTEUR</div>
                    <div>DESCRIPTION</div>
                </div>

                <!-- ROW 1 -->
                <article class="library-book">
                    <div class="library-photo">
                        <img src="/images/books/kinfolk.png" alt="The Kinfolk Table">
                    </div>
                    <div class="library-title">The Kinfolk Table</div>
                    <div class="library-author">Nathan Williams</div>
                    <div class="library-description">
                        J'ai récemment plongé dans les pages de 'The Kinfolk Table' et j'ai été enchanté par cette œuvre captivante...
                    </div>
                </article>

                <!-- ROW 2 -->
                <article class="library-book">
                    <div class="library-photo">
                        <img src="/images/books/alabaster.png" alt="Alabaster">
                    </div>
                    <div class="library-title">Alabaster</div>
                    <div class="library-author">Esther</div>
                    <div class="library-description">
                        Une lecture captivante qui explore la résilience et la beauté dans les petites choses de la vie...
                    </div>
                </article>

                <!-- ROW 3 -->
                <article class="library-book">
                    <div class="library-photo">
                        <img src="/images/books/wabisabi.png" alt="Wabi Sabi">
                    </div>
                    <div class="library-title">Wabi Sabi</div>
                    <div class="library-author">Beth Kempton</div>
                    <div class="library-description">
                        Une invitation à découvrir la beauté de l’imperfection et à vivre plus sereinement...
                    </div>
                </article>

                <!-- ROW 4 -->
                <article class="library-book">
                    <div class="library-photo">
                        <img src="/images/books/milkhoney.png" alt="Milk & Honey">
                    </div>
                    <div class="library-title">Milk & Honey</div>
                    <div class="library-author">Rupi Kaur</div>
                    <div class="library-description">
                        Une poésie moderne qui touche le cœur, explorant l’amour, la douleur et la guérison...
                    </div>
                </article>

            </div>
        </section>


    </section>

</main>

<?php require __DIR__ . '/layout/footer.php'; ?>