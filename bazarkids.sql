-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 30 Mars 2018 à 22:11
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `bazarkids`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `id_categorie` int(11) NOT NULL,
  `id_taille` int(11) DEFAULT NULL,
  `uniqid` varchar(8) NOT NULL,
  `nom_article` varchar(150) NOT NULL,
  `date_article` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `codebarre_article` varchar(50) DEFAULT NULL,
  `prix_article` tinytext NOT NULL,
  `prix_achat` tinytext NOT NULL,
  `pourcentage` int(4) NOT NULL,
  `nbre_stock_article` int(11) NOT NULL DEFAULT '1',
  `article_commentaire` text NOT NULL,
  PRIMARY KEY (`id_article`),
  KEY `articles_codebarre_article` (`codebarre_article`) USING BTREE,
  KEY `articles_id_categorie` (`id_categorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `articles`
--

INSERT INTO `articles` (`id_article`, `id_categorie`, `id_taille`, `uniqid`, `nom_article`, `date_article`, `codebarre_article`, `prix_article`, `prix_achat`, `pourcentage`, `nbre_stock_article`, `article_commentaire`) VALUES
(2, 2, 1, 'CD3410EN', 'Ensemble spiderman', '2018-03-30 20:05:42', '8901117021051', '9000', '4500', 100, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'),
(4, 3, NULL, 'N56AJ92E', 'Ballon de basket', '2018-03-30 19:48:42', '8901157105056', '5000', '4000', 25, 5, ''),
(5, 1, NULL, 'NC6IJ90E', 'Lettres magnétiques', '2018-03-22 21:02:15', '4051528143867', '12500', '10000', 25, 25, ''),
(6, 5, 1, '92E85LA4', 'Barbie', '2018-03-30 15:06:39', '9434927012128', '93750', '75000', 25, 18, ''),
(7, 5, NULL, 'H7NKLAB1', 'Barbie et sa Fiat 500', '2018-03-16 15:53:39', '1109054503655', '22500', '18000', 25, 43, ''),
(8, 6, 1, 'AJ12EFC6', 'Une batterie de cuisine et ses ustensiles', '2018-03-21 22:03:25', '1109054270564', '25000', '20000', 25, 4, ''),
(9, 6, 2, 'E85LIBG2', 'Des fruits à couper Melissa & Doug ', '2018-03-17 11:25:26', '1109054901017', '16250', '13000', 25, 4, ''),
(10, 5, 1, '3B1HMFKD', 'Salade du jardin Hape', '2018-03-26 10:36:39', '5832369892348', '3600', '3000', 20, 118, ''),
(11, 1, NULL, 'NKDA4GHM', 'Des légo Duplo ', '2018-03-21 22:16:14', '1109054525091', '20000', '10000', 100, 1, ''),
(12, 1, 1, 'CDAJ92MF', 'Marionnettes à doigts', '2018-03-30 18:50:38', '9434927707437', '90000', '45000', 100, 3, '');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
  `uniqid` varchar(8) NOT NULL,
  `nom_categorie` varchar(150) NOT NULL,
  `commentaire_categorie` text NOT NULL,
  `ordre_categorie` int(11) NOT NULL,
  `date_categorie` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `uniqid`, `nom_categorie`, `commentaire_categorie`, `ordre_categorie`, `date_categorie`) VALUES
(1, '07F563B1', 'Jouets', 'Jouets\r\n', 1, '2018-03-14 11:50:27'),
(2, 'B12M85LI', 'Habillement', 'Habillement pour enfant(s)', 2, '2018-03-14 11:50:33'),
(3, 'F5DABGH7', 'Accessoires', 'Accessoire pour enfant(s)', 3, '2018-03-14 11:50:36'),
(4, 'LI4G278C', 'Divers', 'Divers', 4, '2018-03-14 11:50:40'),
(5, 'I410MF56', 'Poupée', 'Tous les types de poupées', 5, '2018-03-14 11:50:44'),
(6, 'EFK6IB12', 'Dinette', 'cuisine', 6, '2018-03-14 11:45:45'),
(7, '2EF5L3J1', 'Figurine', 'Figurine', 7, '2018-03-30 19:46:02');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE IF NOT EXISTS `factures` (
  `id_facture` int(11) NOT NULL AUTO_INCREMENT,
  `mode_paiement` int(11) NOT NULL,
  `facture_numero` varchar(15) NOT NULL,
  `facture_details` text NOT NULL,
  `facture_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facture_montant` int(11) DEFAULT NULL,
  `montant_recu` int(11) DEFAULT NULL,
  `rr` varchar(255) NOT NULL,
  PRIMARY KEY (`id_facture`),
  KEY `factures_modePaiement` (`mode_paiement`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `factures`
--

INSERT INTO `factures` (`id_facture`, `mode_paiement`, `facture_numero`, `facture_details`, `facture_date`, `facture_montant`, `montant_recu`, `rr`) VALUES
(1, 1, '1', 'Essai', '2018-03-30 22:03:27', 13955, 15000, '1045'),
(2, 1, '2', 'Essai', '2018-03-30 22:03:17', 5000, 5000, '0'),
(3, 1, '3', 'Essai', '2018-03-30 22:03:54', 8955, 10000, '1045'),
(4, 1, '4', 'Essai', '2018-03-30 22:03:16', 8955, 9000, '45'),
(5, 1, '5', 'Essai', '2018-03-30 22:03:39', 8955, 9000, '45');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE IF NOT EXISTS `historique` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `type` enum('ajout','vente') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ajout',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `historique_article_id` (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Contenu de la table `historique`
--

INSERT INTO `historique` (`id`, `article_id`, `quantite`, `facture_id`, `type`, `create_time`) VALUES
(1, 4, 1, 1, 'vente', '2018-03-30 19:47:27'),
(2, 2, 1, 1, 'vente', '2018-03-30 19:47:27'),
(3, 4, 1, 2, 'vente', '2018-03-30 19:48:18'),
(4, 2, 1, 3, 'vente', '2018-03-30 19:48:54'),
(5, 2, 1, 4, 'vente', '2018-03-30 19:51:16'),
(6, 2, 1, 5, 'vente', '2018-03-30 19:51:39');

-- --------------------------------------------------------

--
-- Structure de la table `medias`
--

CREATE TABLE IF NOT EXISTS `medias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `caption` mediumtext,
  `alt` mediumtext,
  `description` mediumtext,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `medias`
--

INSERT INTO `medias` (`id`, `id_user`, `filename`, `title`, `caption`, `alt`, `description`, `create_time`, `update_time`) VALUES
(1, 1, '5aad8eea2ab46-source.jpg', '12938313_258392621169238_8499640141697737216_n', NULL, NULL, NULL, '2018-03-17 21:55:54', '2018-03-17 21:55:54'),
(2, 1, '5aad8eeb6ff41-source.jpg', '14117936_1164230563638031_1739516779589066023_n', NULL, NULL, NULL, '2018-03-17 21:55:55', '2018-03-17 21:55:55'),
(3, NULL, '5aaf9137b2ad7-source.jpg', '12932665_620068044815445_1391025024814271790_n', NULL, NULL, NULL, '2018-03-19 10:30:15', '2018-03-19 10:30:15');

-- --------------------------------------------------------

--
-- Structure de la table `medias_metas`
--

CREATE TABLE IF NOT EXISTS `medias_metas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(50) DEFAULT NULL,
  `id_item` int(11) unsigned DEFAULT NULL,
  `id_media` int(11) unsigned DEFAULT NULL,
  `type` varchar(50) DEFAULT '',
  `order_item` int(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mm_fk1` (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `mode_paiement`
--

CREATE TABLE IF NOT EXISTS `mode_paiement` (
  `id_mp` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `prefixe` varchar(255) NOT NULL,
  `RR` int(11) NOT NULL COMMENT 'Rendu ou Reference',
  PRIMARY KEY (`id_mp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `mode_paiement`
--

INSERT INTO `mode_paiement` (`id_mp`, `type`, `prefixe`, `RR`) VALUES
(1, 'Espèce', '', 1),
(2, 'Airtel Money', '033', 0),
(3, 'Orange Money', '032', 0),
(4, 'MVola', '034', 0),
(5, 'Chèque', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`meta_key`),
  KEY `key` (`meta_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `options`
--

INSERT INTO `options` (`meta_key`, `meta_value`) VALUES
('codebarre', '9434927'),
('footer_caisse', 'BAZAR KIDS vous remercie de votre visite'),
('header_caisse', 'BAZARKIDS\r\nAnkazomanga\r\nTel : +261344454512\r\nOuvert de 7:00 à 18:00\r\nLundi à Samedi'),
('version', '2');

-- --------------------------------------------------------

--
-- Structure de la table `taille`
--

CREATE TABLE IF NOT EXISTS `taille` (
  `id_taille` int(11) NOT NULL AUTO_INCREMENT,
  `nom_taille` varchar(150) NOT NULL,
  `date_taille` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_taille`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `taille`
--

INSERT INTO `taille` (`id_taille`, `nom_taille`, `date_taille`) VALUES
(1, 'L', '2018-03-12 12:39:54'),
(2, 'XS', '2018-03-12 12:40:06'),
(3, 'XXL', '2018-03-12 22:17:09'),
(4, 'M', '2018-03-30 19:45:37');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `activate` tinyint(1) DEFAULT '0',
  `token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_activity` datetime DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `activate`, `token`, `last_activity`, `create_time`, `update_time`, `role`) VALUES
(1, 'bora', 'taksbeh@gmail.com', '123456', 1, 'a3417653af1dd614f8f8fa6d001502b3b272af29', '2018-03-30 20:46:24', '2015-03-14 10:41:00', '2018-03-19 15:15:35', 'admin'),
(4, 'caisse', 'tahina.randriamahefa@yahoo.com', '123456', 1, NULL, '2018-03-26 22:45:02', '2018-03-19 15:15:51', NULL, 'caissier');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE IF NOT EXISTS `ventes` (
  `id_vente` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `vente_quantite` int(11) NOT NULL,
  `vente_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facture_id` int(11) NOT NULL,
  PRIMARY KEY (`id_vente`),
  KEY `ventes_article_id` (`article_id`),
  KEY `ventes_facture_id` (`facture_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `ventes`
--

INSERT INTO `ventes` (`id_vente`, `article_id`, `vente_quantite`, `vente_date`, `facture_id`) VALUES
(1, 4, 1, '2018-03-30 22:03:27', 1),
(2, 2, 1, '2018-03-30 22:03:27', 1),
(3, 4, 1, '2018-03-30 22:03:17', 2),
(4, 2, 1, '2018-03-30 22:03:54', 3),
(5, 2, 1, '2018-03-30 22:03:16', 4),
(6, 2, 1, '2018-03-30 22:03:39', 5);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_id_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_modePaiement` FOREIGN KEY (`mode_paiement`) REFERENCES `mode_paiement` (`id_mp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `medias_metas`
--
ALTER TABLE `medias_metas`
  ADD CONSTRAINT `mm_fk1` FOREIGN KEY (`id_media`) REFERENCES `medias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ventes_facture_id` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id_facture`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
