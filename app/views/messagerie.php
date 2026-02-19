<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../../app/helpers.php'; // inclus helpers.php si pas déjà inclus

// 🔹 ID de l'utilisateur courant
$currentUserId = $_SESSION['user']['id'] ?? null;

// 🔹 ID de la conversation sélectionnée (GET param ?user=)
$currentConversationUserId = $_GET['user'] ?? null;

// 🔹 Instancier le MessageManager
$messageManager = new \App\Managers\MessageManager();

// 🔹 Récupérer toutes les conversations de l'utilisateur courant
$conversations = $messageManager->getUserConversations($currentUserId);

// 🔹 Si une conversation est sélectionnée, récupérer ses messages
$messages = [];
if ($currentConversationUserId) {
    $currentConversationUserId = (int)$currentConversationUserId;
    $messages = $messageManager->getConversation($currentUserId, $currentConversationUserId);
}
?>

<main class="messages-page">

    <h1 class="page-title">Messagerie</h1>

    <section class="messages-container">

        <!-- Liste des conversations -->
        <aside class="conversations" aria-label="Liste des conversations">
            <ul>
                <?php if (!empty($conversations)): ?>
                    <?php foreach ($conversations as $conv): ?>
                        <?php 
                            // 🔹 Déterminer l'autre utilisateur de la conversation
                            $otherUserId = ($conv['sender_id'] == $currentUserId) ? $conv['receiver_id'] : $conv['sender_id'];
                            $isActive = ($currentConversationUserId == $otherUserId) ? 'active' : '';
                        ?>
                        <li class="conversation <?= $isActive ?>">
                            <a href="/messagerie?user=<?= $otherUserId ?>">
                                <strong>User #<?= $otherUserId ?></strong>
                                <span class="time">
                                    <?= e($conv['created_at']) ?>
                                </span>
                                <p>
                                    <?= e(substr($conv['content'], 0, 50)) ?>…
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
                        User #<?= $currentConversationUserId ?>
                    </h2>
                </header>

                <div class="chat-messages">
                    <?php foreach ($messages as $msg): ?>
                        <?php $isSent = ($msg['sender_id'] == $currentUserId); ?>
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
