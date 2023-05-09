-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 09 mai 2023 à 15:39
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `webtical`
--

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

CREATE TABLE `likes` (
  `idLike` int(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `idPub` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`idLike`, `username`, `idPub`) VALUES
(51, 'badr_azz', 21),
(44, 'badr_azz', 23),
(50, 'badr_azz', 24),
(25, '_pp', 24);

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `idPub` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `contenuPub` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `datePub` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`idPub`, `username`, `contenuPub`, `image`, `datePub`) VALUES
(1, '_pp', 'hello world it\'s my first post', NULL, '0000-00-00 00:00:00'),
(2, '_pp', 'let\'s try adding post', NULL, '2023-05-05 16:53:00'),
(17, '_pp', '', 'ofppt-logo3.png', '2023-05-06 00:03:49'),
(18, '_pp', '', 'ofppt-logo2.png', '2023-05-06 00:10:05'),
(19, '_pp', '', 'Screenshot_2023-02-22_000137-removebg-preview.png', '2023-05-06 01:05:46'),
(20, '_pp', 'im happy that this is working', '', '2023-05-06 01:06:09'),
(21, 'badr_azz', 'hi community this is badr happy to be here ', '', '2023-05-06 01:11:17'),
(23, 'badr_azz', 'hello world', '', '2023-05-08 06:47:08'),
(24, 'badr_azz', '', 'Screenshot 2023-02-21 234651.png', '2023-05-08 06:47:22');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `username` varchar(40) NOT NULL,
  `fullname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `bio` text DEFAULT NULL,
  `profilepic` text DEFAULT NULL,
  `coverpic` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`username`, `fullname`, `email`, `password`, `dob`, `bio`, `profilepic`, `coverpic`) VALUES
('badr_azz', 'badr azz', 'badr@gmail.com', 'badr1234', '2003-06-11', '', 'data:image/jpeg;base64,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', NULL),
('_pp', 'oussama', 'admin@gmail.com', 'admin1234', '05-04-2002', NULL, 'https://i.pinimg.com/736x/a1/d3/af/a1d3af721e2a201a844169bd86173156.jpg', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`idLike`),
  ADD KEY `username` (`username`,`idPub`),
  ADD KEY `idPub` (`idPub`);

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`idPub`),
  ADD KEY `username` (`username`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `likes`
--
ALTER TABLE `likes`
  MODIFY `idLike` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `idPub` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utilisateur` (`username`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`idPub`) REFERENCES `publication` (`idPub`);

--
-- Contraintes pour la table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utilisateur` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
