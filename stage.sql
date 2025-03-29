-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 29 mars 2025 à 17:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `stage`
--

-- --------------------------------------------------------

--
-- Structure de la table `demandes_stage`
--

CREATE TABLE `demandes_stage` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `etablissement` varchar(255) NOT NULL,
  `niveau_etudes` varchar(255) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `type_stage` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` varchar(50) DEFAULT 'pending',
  `tuteur_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demandes_stage`
--

INSERT INTO `demandes_stage` (`id`, `nom`, `prenom`, `email`, `telephone`, `etablissement`, `niveau_etudes`, `date_debut`, `date_fin`, `type_stage`, `created_at`, `statut`, `tuteur_id`, `notes`) VALUES
(1, 'mfmfl', 'sf', 'ee@gmail.com', '065245598', 'isss', 'bac+3', '2025-03-04', '2025-03-29', 'd\'application', '2025-03-21 16:59:08', 'pending', NULL, NULL),
(3, 'tgu', 'nijji', 'hiop@gmail.com', '523568', 'hjkl', 'jh', '2025-03-14', '2025-03-16', 'Fin detude', '2025-03-21 17:22:24', 'pending', NULL, NULL),
(4, 'jjk', 'hjk', 'ghjk@gmail.com', '85256', 'fghjk', 'hjkl', '2025-03-02', '2025-03-07', 'pre-embauche', '2025-03-21 17:23:10', 'pending', NULL, NULL),
(5, 'ghjklm', 'yg', 'gyi@gmail.com', '468545554', 'bn,;l', 'nhy', '2025-03-07', '2025-03-19', 'fin d\'etude', '2025-03-21 17:23:51', 'pending', NULL, NULL),
(6, 'gyuiopp', 'bkjk', 'ze@gmail.com', '852369', 'mmmmm', 'dddd', '2025-03-12', '2025-03-18', 'd\'application', '2025-03-21 17:24:33', 'pending', NULL, NULL),
(7, 'gyuiopp', 'bkjk', 'ze@gmail.com', '852369', 'mmmmm', 'dddd', '2025-03-12', '2025-03-18', 'd\'application', '2025-03-21 17:25:58', 'pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `offres_stage`
--

CREATE TABLE `offres_stage` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `entreprise` varchar(255) NOT NULL,
  `duree` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offres_stage`
--

INSERT INTO `offres_stage` (`id`, `titre`, `description`, `entreprise`, `duree`, `created_at`) VALUES
(1, 'stage d\'application', '......................n', 'onep', '1', '2025-03-27 14:02:57'),
(2, 'stage de fin d\'etude', 'description', 'onep', '2', '2025-03-27 14:07:50');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'morpho@gmail.com', '$2y$10$RZHIZ1FEubjJSuHz4U/R0Ovitm1fcoIBPP46SG3/5rma8bXqhA4oe', '2025-03-21 16:49:57', 'user'),
(2, 'ayman@gmail.com', '$2y$10$PPdkILZkD1kJNMEAIlr8Q.N15jKXCHkjjvxintI.e6K4y250AG2hu', '2025-03-27 13:57:59', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demandes_stage`
--
ALTER TABLE `demandes_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tuteur_id` (`tuteur_id`);

--
-- Index pour la table `offres_stage`
--
ALTER TABLE `offres_stage`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demandes_stage`
--
ALTER TABLE `demandes_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `offres_stage`
--
ALTER TABLE `offres_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demandes_stage`
--
ALTER TABLE `demandes_stage`
  ADD CONSTRAINT `demandes_stage_ibfk_1` FOREIGN KEY (`tuteur_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
