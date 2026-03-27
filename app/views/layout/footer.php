    <!-- ========================= FOOTER ========================= -->
    <footer class="footer" role="contentinfo" aria-label="Pied de page">
        <nav class="footer-legal" role="navigation" aria-label="Liens légaux">
            <ul>
                <li><a href="#">Politique de confidentialité</a></li>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Tom Troc ©</a></li>
                <li>
                    <a href="#">
                        <img src="/images/tt.png" alt="TomTroc" class="tt-image">
                    </a>
                </li>
            </ul>
        </nav>
    </footer>

    <script>
        document.querySelectorAll('.exchange-card').forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id;
                if (id) {
                    window.location.href = '/livre/' + id;
                }
            });
        });
    </script>

</body>
</html>