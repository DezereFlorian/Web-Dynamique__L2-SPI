-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 24 Novembre 2014 à 00:53
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ludotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `age`
--

CREATE TABLE IF NOT EXISTS `age` (
  `IDAge` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `TrancheAge` varchar(20) NOT NULL,
  PRIMARY KEY (`IDAge`),
  UNIQUE KEY `ID` (`IDAge`),
  KEY `IDAge` (`IDAge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `age`
--

INSERT INTO `age` (`IDAge`, `TrancheAge`) VALUES
(1, '3-6'),
(2, '6-9'),
(3, '9-12'),
(4, '12-16'),
(5, '16-18'),
(6, '18+'),
(7, 'Tout public');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `IDCategorie` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NomCateg` varchar(30) NOT NULL,
  PRIMARY KEY (`IDCategorie`),
  UNIQUE KEY `ID` (`IDCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`IDCategorie`, `NomCateg`) VALUES
(1, 'Société'),
(2, 'Vidéo');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `IDClient` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `AdresseMail` varchar(70) NOT NULL,
  `Pseudo` varchar(30) NOT NULL,
  `Mdp` varchar(30) NOT NULL,
  `Adresse` varchar(100) NOT NULL,
  `CodeActivation` int(10) NOT NULL,
  `ClientActif` tinyint(1) NOT NULL,
  UNIQUE KEY `ID` (`IDClient`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`IDClient`, `Nom`, `Prenom`, `AdresseMail`, `Pseudo`, `Mdp`, `Adresse`, `CodeActivation`, `ClientActif`) VALUES
(1, 'Dezere', 'Florian', 'florian.dezere@gmail.com', 'Bull', 'technoki', '359 bis rue de Sablé 72000 Le Mans', 2147483647, 0),
(2, 'Provost', 'Valentin', 'Valent72-1706@hotmail.fr', 'Chouwibaka', 'alizee', '15 cour Charles Delescluze 72100 Le Mans', 2147483647, 0);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `IDCommande` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `DateCommande` date NOT NULL,
  `DateRetour` date NOT NULL,
  `HoraireCommande` varchar(15) NOT NULL,
  `IDClient` bigint(20) unsigned NOT NULL,
  `NbMois` int(11) NOT NULL,
  UNIQUE KEY `ID` (`IDCommande`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=80 ;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`IDCommande`, `DateCommande`, `DateRetour`, `HoraireCommande`, `IDClient`, `NbMois`) VALUES
(70, '2014-11-29', '2015-01-29', '14', 2, 2),
(71, '2014-11-30', '2014-12-30', '9', 2, 1),
(72, '2014-11-30', '2015-02-28', '17', 2, 3),
(74, '2015-01-16', '2015-03-16', '10', 2, 2),
(75, '2015-02-21', '2015-04-21', '15', 2, 2),
(76, '2014-11-30', '2015-02-28', '16', 2, 3),
(77, '2014-11-23', '2014-12-23', '9', 2, 1),
(79, '2014-11-30', '2015-02-28', '9', 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `commandefinale`
--

CREATE TABLE IF NOT EXISTS `commandefinale` (
  `IDCommandeFinale` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `IDCommande` bigint(20) unsigned NOT NULL,
  `IDJeux` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `ID` (`IDCommandeFinale`),
  KEY `IDCommande` (`IDCommande`),
  KEY `IDJeux` (`IDJeux`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `commandefinale`
--

INSERT INTO `commandefinale` (`IDCommandeFinale`, `IDCommande`, `IDJeux`) VALUES
(3, 70, 3),
(4, 71, 5),
(5, 71, 2),
(6, 72, 5),
(7, 72, 2),
(10, 74, 3),
(11, 75, 3),
(12, 76, 2),
(13, 77, 3),
(14, 77, 2),
(16, 79, 2);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE IF NOT EXISTS `jeux` (
  `IDJeux` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `NomJeu` varchar(50) NOT NULL,
  `Descriptif` varchar(500) NOT NULL,
  `Image` varchar(50) NOT NULL,
  `DateDeSortie` date NOT NULL,
  `Stock` int(11) NOT NULL,
  `IDCateg` bigint(20) unsigned NOT NULL,
  `IDAge` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`IDJeux`),
  UNIQUE KEY `ID` (`IDJeux`),
  KEY `IDCateg` (`IDCateg`),
  KEY `IDAge` (`IDAge`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `jeux`
--

INSERT INTO `jeux` (`IDJeux`, `NomJeu`, `Descriptif`, `Image`, `DateDeSortie`, `Stock`, `IDCateg`, `IDAge`) VALUES
(2, 'Uno', 'Jeu de carte très sympathique, peut se jouer de 2 à 6 joueurs', 'uno.jpg', '2006-08-20', 50, 1, 2),
(3, 'Tomb Raider', 'Tomb Raider, le dernier.\r\nAvec des boobs et des fesses. Et aussi des jolis paysages (éventuellement).', 'tombraider.jpg', '2012-07-01', 10, 2, 6),
(5, 'Call of Duty Bie-Zom', 'Le nouveau Call of Duty.', 'codbison.jpg', '2015-03-25', 500, 2, 6);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commandefinale`
--
ALTER TABLE `commandefinale`
  ADD CONSTRAINT `idcommande` FOREIGN KEY (`IDCommande`) REFERENCES `commande` (`IDCommande`),
  ADD CONSTRAINT `idjeux` FOREIGN KEY (`IDJeux`) REFERENCES `jeux` (`IDJeux`);

--
-- Contraintes pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD CONSTRAINT `idage` FOREIGN KEY (`IDAge`) REFERENCES `age` (`IDAge`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `idcateg` FOREIGN KEY (`IDCateg`) REFERENCES `categorie` (`IDCategorie`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
