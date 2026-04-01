<?php require __DIR__ . '/layout/header.php'; ?>

<?php
$otherUserId = $otherUserId ?? null;
$otherUser = $otherUser ?? null;

/**
 * Retourne un chemin d'avatar valide pour l'affichage
 */
function getAvatarPath(?string $avatar): string
{
    $default = '/images/profiles/default-user.png';

    if (empty($avatar)) {
        return $default;
    }

    $avatar = trim($avatar);

    // Si la valeur contient déjà le chemin complet public
    if (str_starts_with($avatar, '/images/profiles/')) {
        $filename = basename($avatar);
    }
    // Si la valeur contient "profiles/nomfichier"
    elseif (str_starts_with($avatar, 'profiles/')) {
        $filename = basename($avatar);
    }
    // Si la valeur contient juste le nom du fichier
    else {
        $filename = basename($avatar);
    }

    $fullPath = __DIR__ . '/../../public/images/profiles/' . $filename;

    if (!file_exists($fullPath) || !is_file($fullPath)) {
        return $default;
    }

    return '/images/profiles/' . $filename;
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
                        $avatarPath = getAvatarPath($other->getAvatar());
                        ?>

                        <a href="/messagerie?user=<?= $other->getId(); ?>" class="conversation-item <?= $isActive; ?>">
                            <img
                                src="<?= htmlspecialchars($avatarPath); ?>"
                                alt="Photo de profil de <?= htmlspecialchars($other->getUsername()); ?>"
                                class="conversation-avatar"
                            >

                            <div class="conversation-content">
                                <div class="conversation-top">
                                    <h2 class="conversation-name"><?= htmlspecialchars($other->getUsername()); ?></h2>
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
                    <?php $headerAvatarPath = getAvatarPath($otherUser->getAvatar()); ?>

                    <img
                        src="<?= htmlspecialchars($headerAvatarPath); ?>"
                        alt="Photo de profil de <?= htmlspecialchars($otherUser->getUsername()); ?>"
                        class="chat-header-avatar"
                    >

                    <div class="chat-header-info">
                        <h2 class="chat-header-name"><?= htmlspecialchars($otherUser->getUsername()); ?></h2>
                        <p class="chat-header-status">Conversation ouverte</p>
                    </div>
                <?php else: ?>
                    <div class="chat-header-info">
                        <h2 class="chat-header-name">Messagerie</h2>
                        <p class="chat-header-status">Sélectionnez une conversation</p>
                    </div>
                <?php endif; ?>
            </header>

            <div class="chat-messages">
                <?php if ($otherUserId && !empty($messages)): ?>
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

                <?php elseif ($otherUserId): ?>
                    <p>Aucun message pour le moment.</p>

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
                            required
                        >

                        <button type="submit" class="chat-submit">Envoyer</button>
                    </form>
                </div>
            <?php endif; ?>
        </section>
    </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>