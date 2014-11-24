-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 24 Novembre 2014 à 23:59
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
(1, '3+'),
(2, '7+'),
(3, '10+'),
(4, '12+'),
(5, '16+'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`IDCommande`, `DateCommande`, `DateRetour`, `HoraireCommande`, `IDClient`, `NbMois`) VALUES
(80, '2014-11-30', '2015-01-30', '15', 2, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Contenu de la table `commandefinale`
--

INSERT INTO `commandefinale` (`IDCommandeFinale`, `IDCommande`, `IDJeux`) VALUES
(17, 80, 13),
(18, 80, 9),
(19, 80, 11);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `jeux`
--

INSERT INTO `jeux` (`IDJeux`, `NomJeu`, `Descriptif`, `Image`, `DateDeSortie`, `Stock`, `IDCateg`, `IDAge`) VALUES
(2, 'Uno', 'Le but ? Recouvrir la carte jouée précédemment avec une carte de la même couleur ou avec le même symbole. Mais attention aux cartes Action... et aux coups de bluff que chacun peut tenter à tout instant ! 2 à 10 joueurs', 'uno.jpg', '2006-08-20', 50, 1, 2),
(3, 'Tomb Raider', 'Tomb Raider est un jeu d''action-aventure sur Playstation 3. On y incarne la jeune Lara, âgée de 21 ans, qui va devoir survivre sur une île à la suite d''un naufrage. Pour ce faire, elle devra se nourrir, chasser mais aussi faire attention aux menaces qui planent sur elle.\n', 'tombraider.jpg', '2013-03-05', 10, 2, 6),
(6, 'Farcry 4', 'Far Cry 4 est un jeu de tir à la première personne sur PC. Le joueur incarne Ajay, un natif de la région de Kyrat, dans l''Himalaya. A son retour au pays, il prend part à la rébellion pour le soulèvement de son pays face au dictateur Pagan Min. Le titre offre une aventure solo en monde ouvert que l''on peut explorer en coopération à deux, mais également un multijoueur compétitif et un éditeur de cartes.', 'farcry4.jpg', '2014-11-18', 20, 2, 6),
(7, 'SOS Ouistiti', 'Retirez les baguettes de la couleur indiquée par le dé, mais attention aux singes ! Car c''est le joueur qui en aura fait tomber le moins qui gagne la partie. Alors qui sera le plus habile ?', 'sosouistiti.jpg', '2014-12-18', 30, 1, 2),
(8, 'Pokémon Rubis Omega', 'Pokémon Rubis Omega est un jeu de rôle disponible sur 3DS. Remake de la version Rubis sortie sur Game Boy Advance, cet épisode reprend les Méga-Evolutions et une partie de l''interface de Pokémon X et Y pour vous offrir une version revue de la région de Hoenn. Vous pourrez également parcourir librement les cieux à dos de Pokémon et explorer les bases secrètes de vos amis.', 'pokemonrubis.jpg', '2014-11-28', 100, 2, 2),
(9, 'Mikado', 'Qui récoltera le plus de mikado ? Celui qui remporte le plus de points sera le gagnant.', 'mikado.jpg', '2013-01-23', 20, 1, 1),
(10, 'Puissance 4', 'Puissance 4, la grille devenu classique se refait une jeunesse avec cette nouvelle version. Il a un nouveau nom, Connect 4 et de nouvelles couleurs, mais le jeu est toujours simple est efficace: 4 pions alignés et c’est gagné. De nouvelles façons de jouer sont aussi disponible dans les instructions.', 'puissance4.jpg', '2011-11-05', 50, 1, 2),
(11, 'DmC Devil May Cry', 'DmC Devil May Cry est un Beat''em all sur Playstation 3. L''univers du jeu s''est assombri et cet épisode vous permet d''incarner Dante dans sa jeunesse. Conservant le gameplay propre à la série, le titre comprend des armes inédites ainsi que de nouveaux pouvoirs.', 'devilmaycry.jpg', '2013-01-15', 10, 2, 5),
(12, 'Metal Gear Solid V - Ground Zeroes', 'MGS V - Ground Zeroes sur PC est le prologue de The Phantom Pain. Le titre est vendu séparément et plonge le joueur dans l''introduction du 5ème épisode de la saga. En plus de la mission principale scénarisée, on retrouve 5 missions annexes visant à faire découvrir aux joueurs les subtilités du gameplay.', 'mgs5.jpg', '2014-12-18', 15, 2, 6),
(13, 'Monopoly', 'Achetez, vendez et spéculez pour être le joueur le plus riche à la fin de la partie !', 'monopoly.jpg', '2014-05-23', 50, 1, 3);

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
