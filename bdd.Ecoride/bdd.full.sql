-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 12 déc. 2025 à 11:16
-- Version du serveur : 8.0.44-0ubuntu0.24.04.1
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Ecoride`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `email`, `roles`, `password`) VALUES
(1, 'admin@email.com', '[\"ROLE_ADMIN\"]', '$2y$13$seFEZYEdVrlpXOtHHGPDNONNGMz9yqGXYqjkmtWE.C4ts7MPk3hYG');

-- --------------------------------------------------------

--
-- Structure de la table `brand`
--

CREATE TABLE `brand` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `brand`
--

INSERT INTO `brand` (`id`, `name`) VALUES
(1, 'Toyota'),
(2, 'Renault'),
(3, 'Peugeot'),
(4, 'Citroen');

-- --------------------------------------------------------

--
-- Structure de la table `car`
--

CREATE TABLE `car` (
  `id` int NOT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `immatriculation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `energy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_immatriculation_at` date NOT NULL,
  `brand_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `car`
--

INSERT INTO `car` (`id`, `model`, `immatriculation`, `energy`, `color`, `first_immatriculation_at`, `brand_id`, `user_id`) VALUES
(1, 'C3', 'AA-229-AA', 'HYBRID', '#000cad', '2024-09-21', 4, 3),
(3, 'R4', 'AA-229-CC', 'ELECTRIC', '#643a3a', '2025-11-14', 3, 1),
(4, 'Clio 4', 'AA-229-DD', 'THERMIC', '#000000', '2025-09-10', 2, 2),
(6, 'Yaris', 'AA-229-GG', 'ELECTRIC', '#000000', '2025-10-17', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251201210512', '2025-12-01 21:05:32', 20),
('DoctrineMigrations\\Version20251202085346', '2025-12-02 08:53:56', 121),
('DoctrineMigrations\\Version20251202091150', '2025-12-02 09:12:00', 584),
('DoctrineMigrations\\Version20251202095741', '2025-12-02 09:57:52', 145),
('DoctrineMigrations\\Version20251202130403', '2025-12-02 13:04:16', 153),
('DoctrineMigrations\\Version20251204094153', '2025-12-04 09:42:07', 145),
('DoctrineMigrations\\Version20251205090620', '2025-12-05 09:06:30', 119),
('DoctrineMigrations\\Version20251208114851', '2025-12-08 11:51:05', 134),
('DoctrineMigrations\\Version20251211151636', '2025-12-11 15:16:47', 90),
('DoctrineMigrations\\Version20251211203105', '2025-12-11 20:31:16', 114);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

CREATE TABLE `reset_password_request` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trip`
--

CREATE TABLE `trip` (
  `id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `starting_point` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starting_time` time NOT NULL COMMENT '(DC2Type:time_immutable)',
  `ending_time` time NOT NULL,
  `price` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `car_id` int NOT NULL,
  `places` int DEFAULT NULL,
  `driver_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trip`
--

INSERT INTO `trip` (`id`, `start_date`, `end_date`, `starting_point`, `destination`, `starting_time`, `ending_time`, `price`, `status`, `car_id`, `places`, `driver_id`) VALUES
(2, '2025-12-19', '2025-12-23', 'Marseille', 'Paris', '19:27:00', '19:28:00', 52, 'DISPONIBLE', 3, 3, 1),
(3, '2025-12-25', '2025-12-27', 'Marseille', 'Paris', '20:31:00', '18:31:00', 18, 'DISPONIBLE', 4, 2, 2),
(4, '2025-12-22', '2025-12-23', 'Aix', 'Marseille', '19:19:00', '18:22:00', 45, 'DISPONIBLE', 4, 3, 2),
(5, '2025-12-10', '2025-12-10', 'Martigues', 'Salon de provence', '10:16:00', '11:16:00', 17, 'DISPONIBLE', 1, 3, 3),
(6, '2025-12-14', '2025-12-14', 'Marseille', 'Grenoble', '23:59:00', '01:59:00', 15, 'DISPONIBLE', 1, 3, 3),
(7, '2025-12-09', '2025-12-09', 'Marseille', 'Toulon', '12:34:00', '13:34:00', 21, 'PASSÉ', 1, 3, 3),
(8, '2025-12-11', '2025-12-23', 'Marseille', 'New Delhi', '16:44:00', '15:44:00', 80, 'DISPONIBLE', 6, 3, 3),
(9, '2025-12-09', '2025-12-12', 'Lyon', 'Gardanne', '22:08:00', '22:08:00', 54, 'DISPONIBLE', 1, 4, 3);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` int NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `thumbnail` longblob,
  `create_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `roles` json NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `credits` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `last_name`, `pseudo`, `email`, `password`, `number`, `adress`, `dob`, `thumbnail`, `create_at`, `roles`, `is_verified`, `credits`) VALUES
(1, 'Abderemane', 'Hassani', 'Abdou', 'truc@hotmail.com', '$2y$13$.lrkZ0.gjQAHgqJPwPAquOXPAMgaanEjLL6d7Vsn5VhmCoYYpuB16', 645565456, '11 av garalban', '1999-06-02', NULL, '2025-12-02 13:04:22', '[]', 1, 50),
(2, 'John', 'doe', 'John', 'johndoe@hotmail.com', '$2y$13$9Mnu11d5x1FoBpJ5fHj5Wek7P76nCGfHvu3qUChZbTptt/Y3.TQ/W', 455654568, '10 av garalban', '1999-06-02', NULL, '2025-12-02 13:08:33', '[\"ROLE_USER\", \"ROLE_DRIVER\"]', 1, 35),
(3, 'Jane', 'doe', 'Jane', 'janedoe@hotmail.com', '$2y$13$STwpqN6lHd.b1OyZVNT/bOpq6FJPYUi0qS0a8caOmiDxpMECDN4Su', 636284545, 'abdouu', '2004-06-02', NULL, '2025-12-02 13:11:33', '[\"ROLE_USER\", \"ROLE_DRIVER\"]', 1, 20),
(4, 'Pegasus', 'Maximilien', 'Maxim', 'MaximilienpegasUS@hotmail.com', '$2a$12$6RgrR.qx7GZ53l6sw22Z9.DQLbyDRmDpL5tvRwVtQwO3SZVYXiuNm', 625912301, '110th street', '2002-07-10', NULL, '2025-12-08 13:11:13', '[\"ROLE_USER\", \"ROLE_DRIVER\"]', 1, 120);

-- --------------------------------------------------------

--
-- Structure de la table `user_trip`
--

CREATE TABLE `user_trip` (
  `user_id` int NOT NULL,
  `trip_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_trip`
--

INSERT INTO `user_trip` (`user_id`, `trip_id`) VALUES
(2, 3),
(2, 4),
(2, 6),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Index pour la table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_773DE69D44F5D008` (`brand_id`),
  ADD KEY `IDX_773DE69DA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CE748AA76ED395` (`user_id`);

--
-- Index pour la table `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7656F53BC3C6F69F` (`car_id`),
  ADD KEY `IDX_7656F53BC3423909` (`driver_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`,`pseudo`);

--
-- Index pour la table `user_trip`
--
ALTER TABLE `user_trip`
  ADD PRIMARY KEY (`user_id`,`trip_id`),
  ADD KEY `IDX_CD7B9F2A76ED395` (`user_id`),
  ADD KEY `IDX_CD7B9F2A5BC2E0E` (`trip_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `car`
--
ALTER TABLE `car`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `trip`
--
ALTER TABLE `trip`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `FK_773DE69D44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `FK_773DE69DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `FK_7656F53BC3423909` FOREIGN KEY (`driver_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_7656F53BC3C6F69F` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`);

--
-- Contraintes pour la table `user_trip`
--
ALTER TABLE `user_trip`
  ADD CONSTRAINT `FK_CD7B9F2A5BC2E0E` FOREIGN KEY (`trip_id`) REFERENCES `trip` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CD7B9F2A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
