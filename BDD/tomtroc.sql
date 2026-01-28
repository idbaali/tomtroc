CREATE DATABASE IF NOT EXISTS tomtroc
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tomtroc;

-- =========================
-- TABLE USERS
-- =========================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    description TEXT DEFAULT NULL,
    avatar VARCHAR(255) DEFAULT 'default-user.png',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- TABLE BOOKS
-- =========================
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    author VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    owner_id INT NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================
-- TABLE MESSAGES
-- =========================
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =========================
-- TABLE EXCHANGES
-- =========================
CREATE TABLE IF NOT EXISTS exchanges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    requester_id INT NOT NULL,
    status ENUM('pending','accepted','rejected') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (requester_id) REFERENCES users(id) ON DELETE CASCADE
);


INSERT INTO users (username, email, password, description, avatar) VALUES
('Nathalire', 'nathalire@example.com', 'password1', 'Passionnée de romans.', 'nathalire.png'),
('CamilleClubLit', 'camille@example.com', 'password2', 'Bibliophile et organisatrice.', 'camille.png'),
('Alexlecture', 'alex@example.com', 'password3', 'Toujours à la recherche de nouvelles histoires.', 'alexlecture.png'),
('Hugo1990_12', 'hugo@example.com', 'password4', 'Fan de poésie.', 'hugo.png');

INSERT INTO books (title, author, description, image, owner_id, slug) VALUES
('Alabaster', 'Nathan Williams', 'Un roman captivant sur la famille et les secrets.', 'esther-alabaster.png', 1, 'alabaster'),
('The Kinfolk Table', 'Esther', 'Découvrez l’art de partager les repas et les histoires.', 'kinfolk.png', 2, 'the-kinfolk-table'),
('Wabi Sabi', 'Beth Kempton', 'Un guide sur la simplicité et la beauté imparfaite.', 'wabi-sabi.png', 3, 'wabi-sabi'),
('Milk & Honey', 'Rupi Kaur', 'Recueil poétique sur l’amour, la perte et la guérison.', 'milk-honey.png', 4, 'milk-honey'),
('Delight!', 'Justin Rossow', 'Un livre inspirant sur la joie de vivre.', 'delight.png', 1, 'delight'),
('Milwaukee Mission', 'Elder Cooper Low', 'Mission et valeurs à travers les histoires.', 'milwaukee.png', 2, 'milwaukee-mission'),
('Minimalist Graphics', 'Julia Schonlau', 'Le minimalisme appliqué au design graphique.', 'minimalist.png', 3, 'minimalist-graphics'),
('Hygge', 'Meik Wiking', 'Découvrir l’art du bien-être et du confort.', 'hygge.png', 4, 'hygge'),
('Innovation', 'Matt Ridley', 'Les clés de l’innovation dans le monde moderne.', 'innovation.png', 1, 'innovation'),
('Psalms', 'Alabaster', 'Psaumes et méditations inspirantes.', 'psalms.png', 2, 'psalms'),
('Thinking, Fast & Slow', 'Daniel Kahneman', 'Comprendre la psychologie de la décision.', 'thinking-fast-slow.png', 3, 'thinking-fast-slow'),
('A Book Full Of Hope', 'Rupi Kaur', 'Recueil d’espoir et de poésie.', 'book-full-hope.png', 4, 'a-book-full-of-hope'),
('The Subtle Art Of...', 'Mark Manson', 'Conseils pour vivre mieux et plus sereinement.', 'subtle-art.png', 1, 'the-subtle-art-of'),
('Narnia', 'C.S Lewis', 'Aventures fantastiques dans un monde magique.', 'narnia.png', 2, 'narnia'),
('Company Of One', 'Paul Jarvis', 'Réflexion sur l’entrepreneuriat et le travail.', 'company-of-one.png', 3, 'company-of-one'),
('The Two Towers', 'J.R.R Tolkien', 'Le deuxième tome de la trilogie du Seigneur des Anneaux.', 'two-towers.png', 4, 'the-two-towers');

INSERT INTO messages (sender_id, receiver_id, content, is_read) VALUES
(1, 2, 'Salut Camille, tu as vu le nouveau livre Alabaster ?', 0),
(2, 1, 'Oui, il est super ! Merci pour le conseil.', 1),
(3, 4, 'Hugo, est-ce que tu veux échanger Milk & Honey ?', 0);

INSERT INTO exchanges (book_id, requester_id, status) VALUES
(1, 2, 'pending'),
(4, 3, 'accepted');
