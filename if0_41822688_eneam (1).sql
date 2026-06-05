-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 juin 2026 à 00:22
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
-- Base de données : `if0_41822688_eneam`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id_article` varchar(20) NOT NULL,
  `design` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `categorie` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `design`, `prix`, `categorie`) VALUES
('23312', 'LENOVO Core I7 RAM 16 GB SSD 512GB', 429998.00, 'Informatique'),
('3587', 'HIRA 50Cl', 800.00, 'Autres'),
('56', 'SAC NEW MOD PL POWER', 13500.00, 'Autres'),
('6547', 'PROJECTEUR 12A', 26000.00, 'Électronique'),
('6668', 'REDMI 14C 256 GB', 70000.00, 'Informatique'),
('73737', 'CLIMATISEUR', 85000.00, 'Électronique'),
('780', 'LAROUSSE', 7500.00, 'Fournitures'),
('MT320', 'ROLEX OYSTER', 35000.00, 'Vêtements'),
('SM2631', 'SAMSUNG RAM 4GB 128 GB', 85000.00, 'Électronique'),
('VT5399', 'MANCHETTE OR', 3200.00, 'Vêtements');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `age` tinyint(3) UNSIGNED DEFAULT NULL,
  `adresse` varchar(100) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `mail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `age`, `adresse`, `ville`, `mail`) VALUES
(1, 'Edi', 'TOSEOU', 53, 'Gbagamey', 'COTONOU', 'calebvic5@gmail.com'),
(2, 'DOSON', 'Deuni', 8, 'Pobox25', 'Cotonou', 'donu@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_comm` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `id_client` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_comm`, `date`, `montant`, `id_client`) VALUES
(1, '2026-05-04', 530798.00, 1),
(2, '2026-05-05', 2869988.00, 2);

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `id_comm` int(10) UNSIGNED NOT NULL,
  `id_article` varchar(20) NOT NULL,
  `qtecomm` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`id_comm`, `id_article`, `qtecomm`) VALUES
(1, '23312', 1),
(1, '3587', 1),
(1, '6668', 1),
(1, '780', 4),
(2, '23312', 6),
(2, '73737', 2),
(2, 'MT320', 1),
(2, 'SM2631', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `contact`, `login`, `password`) VALUES
(1, 'CHABI', 'Affolabi Esdras Daldio', '0197331555', 'GNALO26', '$2y$10$szNzS/2DdUF1YYpBEjwvbuEc2omq7h8TNOLE7sKVeOqlEToIej8e.'),
(2, 'AMOUSSOU', 'Lewis', '0154766900', 'prof', '$2y$10$HQ7DXHgGb.hmAVfn/o/uMuDLgwVZHY3WAiTKjTLYTSgunfipuRTUq'),
(3, 'ALOGNISSOU', 'Astrid', '0198464263', 'Etu1', '$2y$10$HRXnlH2z1RkaKp9LTErqYuXtohbdrjKUK0ikhfm3PbDKAtVTVpL8a'),
(4, 'Glazaï', 'Jolie', '26789087', 'Etu', '$2y$10$6lmV7S.CVpZfEMHFf2byeeCYfIGWUSJ4eA6fT4tF6jclTDdMyMuxO'),
(5, 'Bohinou', 'Debora', '0167896789', 'Deb7', '$2y$10$hcy0Kl1EMpcpjfJq2H1l2.bA8Nk.k7lbKI7h9uSN9QQXBdJVK.HJW'),
(6, 'DJANGONI', 'Baudouin', '0190575678', 'djangoni@001', '$2y$10$mblI/Iyq3hyBt.KKrwKMjeu5M0SZNL8vfBfTFg8.TYSfCRulbRYQm'),
(7, 'ADODE', 'Flos', '0145678390', 'adodeme@001', '$2y$10$eX.bkblXnVq.nEiVftF.Z.wS.Bv7srVEJPAAOAssb12.CIYuk8G5C'),
(8, 'Koukponou', 'Obed', '+2290140690762', 'Ert344', '$2y$10$Pb76vcEpotVoXmBGMKMQseVgokiGlKJxJYinCYlwsXxyfuK8kPX5G');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_comm`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`id_comm`,`id_article`),
  ADD KEY `id_article` (`id_article`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_comm` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ibfk_1` FOREIGN KEY (`id_comm`) REFERENCES `commande` (`id_comm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contenir_ibfk_2` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
