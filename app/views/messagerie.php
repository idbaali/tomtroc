<?php require __DIR__ . '/layout/header.php'; ?>

<?php
/** @var int $currentUserId */
/** @var array $messages */
/** @var array $conversations */
/** @var int|null $otherUserId */
/** @var \App\Models\User|null $otherUser */

$otherUserId = $otherUserId ?? null;
$otherUser = $otherUser ?? null;

function getAvatarPath(?string $avatar): string
{
    $default = '/images/avatars/default-user.png';

    if (empty($avatar)) {
        return $default;
    }

    $filename = basename(trim($avatar));
    $fullPath = __DIR__ . '/../../public/images/avatars/' . $filename;

    if (!file_exists($fullPath) || !is_file($fullPath)) {
        return $default;
    }

    return '/images/avatars/' . $filename;
}
?>

<section class="messaging-page">
    <div class="messaging-wrapper">

        <aside class="messaging-sidebar" aria-label="Liste des conversations">
            <h1 class="messaging-title">Messagerie</h1>

            <div class="conversation-list">
                <?php if (!empty($conversations)): ?>
                    <?php foreach ($conversations as $conversation): ?>
                        <?php
                        $sender = $conversation->getSender();
                        $receiver = $conversation->getReceiver();
                        $other = ($sender->getId() === $currentUserId) ? $receiver : $sender;

                        if (!$other) {
                            continue;
                        }

                        $isActive = ($otherUserId == $other->getId()) ? 'active' : '';
                        ?>

                        <a href="/messagerie/<?= $other->getId(); ?>" class="conversation-item <?= $isActive; ?>">
                            <img
                                src="<?= htmlspecialchars(getAvatarPath($other->getAvatar())); ?>"
                                alt="Photo de profil de <?= htmlspecialchars($other->getUsername()); ?>"
                                class="conversation-avatar">

                            <div class="conversation-content">
                                <div class="conversation-top">
                                    <h2 class="conversation-name">
                                        <?= htmlspecialchars($other->getUsername()); ?>
                                    </h2>

                                    <span class="conversation-time">
                                        <?= date('H:i', strtotime($conversation->getCreatedAt())); ?>
                                    </span>
                                </div>

                                <p class="conversation-preview">
                                    <?= htmlspecialchars(mb_strimwidth($conversation->getContent(), 0, 40, '...')); ?>
                                </p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune conversation pour le moment.</p>
                <?php endif; ?>
            </div>
        </aside>

        <section class="messaging-chat" aria-label="Zone de discussion">
            <header class="chat-header">
                <?php if ($otherUser): ?>
                    <a href="/compte-public/<?= $otherUser->getId(); ?>" class="chat-user-link">
                        <img
                            src="<?= htmlspecialchars(getAvatarPath($otherUser->getAvatar())); ?>"
                            alt="Photo de profil de <?= htmlspecialchars($otherUser->getUsername() ?? 'Utilisateur'); ?>"
                            class="chat-header-avatar">

                        <div class="chat-header-info">
                            <h2 class="chat-header-name">
                                <?= htmlspecialchars($otherUser->getUsername() ?? 'Utilisateur'); ?>
                            </h2>
                            <p class="chat-header-status">Conversation ouverte</p>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="chat-header-info">
                        <h2 class="chat-header-name">Messagerie</h2>
                        <p class="chat-header-status">Sélectionnez une conversation</p>
                    </div>
                <?php endif; ?>
            </header>

            <div class="chat-messages">
                <?php if ($otherUserId): ?>

                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <?php
                            $sender = $message->getSender();
                            $isMine = ($sender->getId() === $currentUserId);
                            $class = $isMine ? 'sent' : 'received';
                            ?>

                            <article class="message-row <?= $class; ?>">
                                <span class="message-time">
                                    <?= date('H:i', strtotime($message->getCreatedAt())); ?>
                                </span>

                                <div class="message-bubble">
                                    <?= htmlspecialchars($message->getContent()); ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun message pour le moment.</p>
                    <?php endif; ?>

                <?php else: ?>
                    <p>Sélectionnez une conversation pour afficher les messages.</p>
                <?php endif; ?>
            </div>

            <?php if ($otherUserId): ?>
                <div class="chat-form-wrapper">
                    <form action="/messagerie" method="POST" class="chat-form">
                        <input type="hidden" name="receiver_id" value="<?= $otherUserId; ?>">

                        <label for="content" class="sr-only">Tapez votre message</label>
                        <input
                            type="text"
                            id="content"
                            name="content"
                            class="chat-input"
                            placeholder="Tapez votre message ici"
                            required>

                        <button type="submit" class="chat-submit">Envoyer</button>
                    </form>
                </div>
            <?php endif; ?>
        </section>

    </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>