<?php require_once __DIR__ . '/layout/header.php'; ?>

<main class="messages-page">

    <h1 class="page-title">Messagerie</h1>

    <section class="messages-container">

        <!-- Liste des conversations -->
        <aside class="conversations" aria-label="Liste des conversations">
            <ul>
                <?php if (!empty($conversations)): ?>
                    <?php foreach ($conversations as $conv): ?>
                        <?php 
                            $isActive = ($currentConversationUserId == $conv['id']) ? 'active' : '';
                        ?>
                        <li class="conversation <?= $isActive ?>">
                            <a href="/messagerie?user=<?= $conv['id'] ?>">
                                <strong><?= e($conv['username']) ?></strong>
                                <span class="time">
                                    <!-- On peut afficher la dernière date de message si souhaité -->
                                </span>
                                <p>
                                    <?php
                                        // Aperçu du dernier message avec cet utilisateur
                                        $lastMsg = end($messages);
                                        if ($lastMsg && ($lastMsg['sender_id'] == $conv['id'] || $lastMsg['receiver_id'] == $conv['id'])) {
                                            echo e(substr($lastMsg['content'], 0, 50)) . '…';
                                        }
                                    ?>
                                </p>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucune conversation</li>
                <?php endif; ?>
            </ul>
        </aside>

        <!-- Discussion -->
        <section class="chat" aria-label="Discussion">
            <?php if ($currentConversationUserId && !empty($messages)): ?>
                <header class="chat-header">
                    <h2>
                        <?php 
                            $currentUser = array_filter($conversations, fn($c) => $c['id'] == $currentConversationUserId);
                            $currentUser = reset($currentUser);
                            echo e($currentUser['username'] ?? 'Conversation');
                        ?>
                    </h2>
                </header>

                <div class="chat-messages">
                    <?php foreach ($messages as $msg): ?>
                        <?php $isSent = ($msg['sender_id'] == $_SESSION['user']['id']); ?>
                        <div class="message <?= $isSent ? 'sent' : 'received' ?>">
                            <time><?= e($msg['created_at']) ?></time>
                            <p><?= e($msg['content']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <form class="chat-form" action="/messagerie" method="POST" aria-label="Envoyer un message">
                    <input type="hidden" name="receiver_id" value="<?= $currentConversationUserId ?>">
                    <label for="message" class="sr-only">Votre message</label>
                    <textarea id="message" name="content" placeholder="Tapez votre message ici" required></textarea>
                    <button type="submit" class="btn-primary">Envoyer</button>
                </form>

            <?php else: ?>
                <p class="no-conversation">Sélectionnez une conversation pour voir les messages.</p>
            <?php endif; ?>
        </section>

    </section>

</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
