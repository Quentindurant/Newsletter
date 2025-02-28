-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `tp1 news` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Création de l'utilisateur et attribution des privilèges
CREATE USER IF NOT EXISTS 'TP1 News'@'localhost' IDENTIFIED BY 'caca1';
GRANT ALL PRIVILEGES ON `tp1 news`.* TO 'TP1 News'@'localhost';
FLUSH PRIVILEGES;

-- Utilisation de la base de données
USE `tp1 news`;

-- Création de la table newsletter
CREATE TABLE IF NOT EXISTS `newsletter` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nom` VARCHAR(100) NOT NULL,
    `prenom` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `date_inscription` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table admin (pour le carré admin)
CREATE TABLE IF NOT EXISTS `admin` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `date_creation` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion d'un administrateur par défaut (mot de passe: admin123)
INSERT INTO `admin` (`username`, `password`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Ajout de quelques données de test pour la newsletter
INSERT INTO `newsletter` (`nom`, `prenom`, `email`) VALUES
('Dupont', 'Jean', 'jean.dupont@example.com'),
('Martin', 'Marie', 'marie.martin@example.com'),
('Bernard', 'Pierre', 'pierre.bernard@example.com');
