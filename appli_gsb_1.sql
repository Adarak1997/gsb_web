-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 02 juin 2019 à 17:00
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `appli_gsb`
--

-- --------------------------------------------------------

--
-- Structure de la table `details_frais_forfait`
--

DROP TABLE IF EXISTS `details_frais_forfait`;
CREATE TABLE IF NOT EXISTS `details_frais_forfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantite` int(11) NOT NULL,
  `frais_forfait_id` int(11) NOT NULL,
  `fiche_frais_id` int(11) NOT NULL,
  `etat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_details_frais_forfait_frais_forfait` (`frais_forfait_id`),
  KEY `fk_details_frais_forfait_fiche_frais` (`fiche_frais_id`),
  KEY `etat_id` (`etat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `details_frais_forfait`
--

INSERT INTO `details_frais_forfait` (`id`, `quantite`, `frais_forfait_id`, `fiche_frais_id`, `etat_id`) VALUES
(1, 100, 1, 19, 1),
(2, 5, 4, 19, 1),
(3, 3, 2, 19, 1),
(4, 3, 3, 19, 1),
(5, 5, 4, 20, 2),
(6, 100, 1, 20, 1);

-- --------------------------------------------------------

--
-- Structure de la table `details_frais_non_forfait`
--

DROP TABLE IF EXISTS `details_frais_non_forfait`;
CREATE TABLE IF NOT EXISTS `details_frais_non_forfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `montant` decimal(10,0) NOT NULL,
  `fiche_frais_id` int(11) NOT NULL,
  `etat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_details_frais_non_forfait_fiche_frais` (`fiche_frais_id`),
  KEY `fk_details_frais_non_forfait_etat` (`etat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `details_frais_non_forfait`
--

INSERT INTO `details_frais_non_forfait` (`id`, `libelle`, `montant`, `fiche_frais_id`, `etat_id`) VALUES
(1, 'pot de départ', '130', 19, 1),
(2, 'repas d\'affaire', '150', 19, 1),
(3, 'concert', '90', 20, 2),
(4, 'voyage d\'affaire', '0', 20, 3);

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
(1, 'en attente'),
(2, 'valide'),
(3, 'refuse');

-- --------------------------------------------------------

--
-- Structure de la table `fiche_frais`
--

DROP TABLE IF EXISTS `fiche_frais`;
CREATE TABLE IF NOT EXISTS `fiche_frais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mois` int(2) NOT NULL,
  `annee` int(4) NOT NULL,
  `etat_id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fiche_frais_etat` (`etat_id`),
  KEY `fk_fiche_frais_utilisateur` (`utilisateur_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fiche_frais`
--

INSERT INTO `fiche_frais` (`id`, `mois`, `annee`, `etat_id`, `utilisateur_id`) VALUES
(19, 6, 2019, 1, 30),
(20, 5, 2019, 1, 30);

-- --------------------------------------------------------

--
-- Structure de la table `frais_forfait`
--

DROP TABLE IF EXISTS `frais_forfait`;
CREATE TABLE IF NOT EXISTS `frais_forfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `frais_forfait`
--

INSERT INTO `frais_forfait` (`id`, `libelle`, `montant`) VALUES
(1, 'kilometrage', '0.10'),
(2, 'repas_midi', '20.00'),
(3, 'relais_etape', '90.00'),
(4, 'nuitee', '60.00');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `libelle`) VALUES
(1, 'Visiteur'),
(2, 'Comptable'),
(3, 'Administrateur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `date_naissance` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `code_postal` varchar(255) NOT NULL,
  `date_embauche` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_utilisateur_role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `tel`, `date_naissance`, `adresse`, `ville`, `code_postal`, `date_embauche`, `pseudo`, `mdp`, `role_id`) VALUES
(28, 'DURAND', 'Jean', 'jeandurand@gsb.com', '0658425147', '1985-04-02', '7 rue Jean Jaurès', 'Lyon', '69007', '2007-08-05', 'admin', '21232f297a57a5a743894a0e4a801fc3', 3),
(29, 'HENRY', 'Jade', 'jadehenry@gsb.com', '0654238754', '1992-08-30', '250 Rue Victor Hugo ', 'Lyon', '69004', '2016-08-07', 'comptable', '0230782c6665a4465ee7ddaf7207935a', 2),
(30, 'BERNARD', 'Christophe', 'bernardchristophe@gsb.com', '0621253954', '1987-01-04', '9 Avenue Michel ', 'St-Genis', '01630', '2009-08-05', 'visiteur', 'dcaa6e60155776107c638af755498759', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `details_frais_forfait`
--
ALTER TABLE `details_frais_forfait`
  ADD CONSTRAINT `fk_details_frais_forfait_etat` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fk_details_frais_forfait_fiche_frais` FOREIGN KEY (`fiche_frais_id`) REFERENCES `fiche_frais` (`id`),
  ADD CONSTRAINT `fk_details_frais_forfait_frais_forfait` FOREIGN KEY (`frais_forfait_id`) REFERENCES `frais_forfait` (`id`);

--
-- Contraintes pour la table `details_frais_non_forfait`
--
ALTER TABLE `details_frais_non_forfait`
  ADD CONSTRAINT `fk_details_frais_non_forfait_etat` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fk_details_frais_non_forfait_fiche_frais` FOREIGN KEY (`fiche_frais_id`) REFERENCES `fiche_frais` (`id`);

--
-- Contraintes pour la table `fiche_frais`
--
ALTER TABLE `fiche_frais`
  ADD CONSTRAINT `fk_fiche_frais_etat` FOREIGN KEY (`etat_id`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fk_fiche_frais_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `fk_utilisateur_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
