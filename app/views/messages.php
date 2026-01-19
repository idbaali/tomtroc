<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="messages-page">

    <h1 class="page-title">Messagerie</h1>

    <section class="messages-container">

        <!-- Liste des conversations -->
        <aside class="conversations" aria-label="Liste des conversations">
            <ul>
                <li class="conversation active">
                    <strong>Alexlecture</strong>
                    <span class="time">15:43</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit…</p>
                </li>

                <li class="conversation">
                    <strong>Nathalire</strong>
                    <span class="time">20.08</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit…</p>
                </li>

                <li class="conversation">
                    <strong>Sas634</strong>
                    <span class="time">15.08</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit…</p>
                </li>
            </ul>
        </aside>

        <!-- Discussion -->
        <section class="chat" aria-label="Discussion avec Alexlecture">

            <header class="chat-header">
                <h2>Alexlecture</h2>
            </header>

            <div class="chat-messages">
                <div class="message received">
                    <time>21.08 · 15:48</time>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.</p>
                </div>

                <div class="message sent">
                    <time>21.08 · 15:50</time>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>

            <form class="chat-form" aria-label="Envoyer un message">
                <label for="message" class="sr-only">Votre message</label>
                <textarea id="message" placeholder="Tapez votre message ici" required></textarea>
                <button type="submit" class="btn-primary">Envoyer</button>
            </form>

        </section>

    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
