<?php include __DIR__.'/layout/header.php'; ?>

<main class="page">

    <h1 class="page-title">Nos livres à l’échange</h1>

    <div class="search-bar">
        <input type="search" placeholder="Rechercher un livre…">
    </div>

    <section class="books-grid">

        <article class="book-card">
            <img src="../assets/images/kinfolk.png" alt="The Kinfolk Table">
            <h3>The Kinfolk Table</h3>
            <p class="author">Esther</p>
            <p class="seller">Vendu par : CamilleClubLit</p>
        </article>

        <article class="book-card">
            <img src="../assets/images/wabi-sabi.png" alt="Wabi Sabi">
            <h3>Wabi Sabi</h3>
            <p class="author">Beth Kempton</p>
            <p class="seller">Vendu par : Alexlecture</p>
        </article>

        <article class="book-card">
            <img src="../assets/images/milk-honey.png" alt="Milk & Honey">
            <h3>Milk & Honey</h3>
            <p class="author">Rupi Kaur</p>
            <p class="seller">Vendu par : Hugo1990_12</p>
            <span class="badge indispo">non dispo.</span>
        </article>

        <article class="book-card">
            <img src="../assets/images/alabaster.png" alt="Alabaster">
            <h3>Alabaster</h3>
            <p class="author">Nathan Williams</p>
            <p class="seller">Vendu par : Nathalire</p>
        </article>

    </section>

</main>

<?php include __DIR__.'/layout/footer.php'; ?>
