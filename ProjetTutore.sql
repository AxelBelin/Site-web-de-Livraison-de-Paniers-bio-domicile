-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 19 jan. 2021 à 19:40
-- Version du serveur :  5.7.24
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projettutore`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `numClient` int(4) NOT NULL,
  `nomclient` varchar(30) NOT NULL,
  `prenomclient` varchar(30) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `limitdeprix` float DEFAULT NULL,
  `tel` varchar(30) NOT NULL,
  `groupe` int(4) DEFAULT NULL,
  `numLivreur` int(4) DEFAULT NULL,
  `numCommande` int(4) DEFAULT NULL,
  `numCartier` int(4) DEFAULT NULL,
  `numCompte` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`numClient`, `nomclient`, `prenomclient`, `mail`, `adresse`, `limitdeprix`, `tel`, `groupe`, `numLivreur`, `numCommande`, `numCartier`, `numCompte`) VALUES
(6, 'Test', 'Titit', 'titi@gmail.com', '56 rue des prunes', 10, '0654125689', 4, NULL, 18, 3, 9);

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `numCommande` int(4) NOT NULL,
  `commandegroupe` tinyint(1) DEFAULT NULL,
  `jourlivrasion` varchar(30) DEFAULT NULL,
  `hebdomadaire` tinyint(1) DEFAULT NULL,
  `etatCommande` varchar(60) DEFAULT NULL,
  `datecommande` date NOT NULL,
  `prixTotal` double NOT NULL,
  `TVA` float NOT NULL,
  `prixtotalnet` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`numCommande`, `commandegroupe`, `jourlivrasion`, `hebdomadaire`, `etatCommande`, `datecommande`, `prixTotal`, `TVA`, `prixtotalnet`) VALUES
(11, NULL, NULL, NULL, NULL, '2021-01-18', 29, 1.2, 696),
(12, NULL, NULL, NULL, NULL, '2021-01-18', 15.5, 1.2, 696),
(18, 1, 'jeudi', 1, 'Livraison', '2021-01-19', 46.5, 1.2, 55.8);

-- --------------------------------------------------------

--
-- Structure de la table `commandepanier`
--

CREATE TABLE `commandepanier` (
  `numCommande` int(4) NOT NULL,
  `numPanier` int(4) NOT NULL,
  `quantite` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commandepanier`
--

INSERT INTO `commandepanier` (`numCommande`, `numPanier`, `quantite`) VALUES
(11, 11, 25),
(12, 12, 1),
(18, 11, 3);

-- --------------------------------------------------------

--
-- Structure de la table `commandeproduit`
--

CREATE TABLE `commandeproduit` (
  `numCommande` int(4) NOT NULL,
  `numProduit` int(4) NOT NULL,
  `quantite` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `compofamille`
--

CREATE TABLE `compofamille` (
  `numTypeProduit` int(4) NOT NULL,
  `numFamille` int(4) NOT NULL,
  `nomProduit` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compofamille`
--

INSERT INTO `compofamille` (`numTypeProduit`, `numFamille`, `nomProduit`) VALUES
(1, 4, 'pastÃ¨que'),
(1, 19, 'prune'),
(2, 31, 'ognion');

-- --------------------------------------------------------

--
-- Structure de la table `compopanier`
--

CREATE TABLE `compopanier` (
  `numPanier` int(4) NOT NULL,
  `numProduit` int(4) NOT NULL,
  `qteProduitParArt` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compopanier`
--

INSERT INTO `compopanier` (`numPanier`, `numProduit`, `qteProduitParArt`) VALUES
(14, 23, 1.56);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `numCompte` int(4) NOT NULL,
  `profil` varchar(30) NOT NULL,
  `indentifiant` varchar(30) NOT NULL,
  `motdepasse` varchar(100) NOT NULL,
  `numCB` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`numCompte`, `profil`, `indentifiant`, `motdepasse`, `numCB`) VALUES
(3, 'Client', 'toto92', '882baf28143fb700b388a87ef561a6e5', NULL),
(4, 'Client', 'tata93', '882baf28143fb700b388a87ef561a6e5', 'db6617f158128375995d8546153fa9b5'),
(5, 'Livreur', 'toto92', '04a9a6f87ae889f62352df96f71860ff', NULL),
(6, 'Livreur', 'toto91', '1697918c7f9551712f531143df2f8a37', NULL),
(7, 'Livreur', 'test124', 'ea35d61ea10a2abdff6a4f290b2658e3', NULL),
(9, 'Client', 'totoClient', 'b52ae2695993501f6f613f350ec60efb', NULL),
(10, 'Livreur', 'totoLivreur', '8022934df0c16c0a2c7534e3f896a979', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `famille`
--

CREATE TABLE `famille` (
  `numFamille` int(4) NOT NULL,
  `saison` varchar(30) NOT NULL,
  `categorie` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `famille`
--

INSERT INTO `famille` (`numFamille`, `saison`, `categorie`) VALUES
(4, 'ete', 'fruit juteux'),
(7, 'hiver', 'fruit hiver'),
(12, 'automne', 'soupe automne'),
(19, 'ete', 'salade de fruit'),
(31, 'hiver', 'salades chaude');

-- --------------------------------------------------------

--
-- Structure de la table `livreur`
--

CREATE TABLE `livreur` (
  `numLivreur` int(4) NOT NULL,
  `nomlivreur` varchar(60) NOT NULL,
  `prenomLivreur` varchar(50) NOT NULL,
  `datelivraison` date DEFAULT NULL,
  `telLivreur` varchar(30) NOT NULL,
  `mailLivreur` varchar(100) NOT NULL,
  `numCompte` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `livreur`
--

INSERT INTO `livreur` (`numLivreur`, `nomlivreur`, `prenomLivreur`, `datelivraison`, `telLivreur`, `mailLivreur`, `numCompte`) VALUES
(2, 'Toto', 'Tata', NULL, '0625413514', 'toto@gmail.com', 6),
(3, 'Tutu', 'Titi', NULL, '0625413514', 'axu@gmail.com', 7),
(4, 'Belin', 'Axel', NULL, '0612121212', 'axel@gmail.com', 10);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `numPanier` int(4) NOT NULL,
  `nomPanier` varchar(60) DEFAULT NULL,
  `nbProduit` varchar(30) NOT NULL,
  `quantite` int(4) NOT NULL,
  `prixpanier` float NOT NULL,
  `poids` float DEFAULT NULL,
  `saison` varchar(25) DEFAULT NULL,
  `nomImg` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`numPanier`, `nomPanier`, `nbProduit`, `quantite`, `prixpanier`, `poids`, `saison`, `nomImg`) VALUES
(11, 'lÃ©gumes d\'Ã©tÃ©', '4', 6, 14.5, 12.2, 'Ã©tÃ©', 'panierLegume.jpg'),
(12, 'lÃ©gumes d\'hiver', '4', 17, 15.5, 12.2, 'hiver', 'panier-fruit-legume-bio.jpg'),
(13, 'salade de fruits', '7', 15, 9.47, 3.85, 'Ã©tÃ©', 'panier-de-fruits.jpg'),
(14, 'lÃ©gumes pour salade', '4', 20, 11.2, 0.95, 'hiver', 'panierLegume2.png');

-- --------------------------------------------------------

--
-- Structure de la table `producteur`
--

CREATE TABLE `producteur` (
  `identifiant` varchar(30) NOT NULL,
  `mdp` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `producteur`
--

INSERT INTO `producteur` (`identifiant`, `mdp`) VALUES
('totoAgriculteur', 'totoA1234');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `numProduit` int(4) NOT NULL,
  `nomproduit` varchar(30) NOT NULL,
  `quantite` float NOT NULL,
  `prixproduit` float NOT NULL,
  `numTypeProduit` int(4) NOT NULL,
  `nomImg` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`numProduit`, `nomproduit`, `quantite`, `prixproduit`, `numTypeProduit`, `nomImg`) VALUES
(2, 'pomme', 18, 3, 1, 'pomme granny.jpg'),
(5, 'poire', 3, 7, 1, 'poire.jpg'),
(6, 'carotte', 5, 10, 2, 'carottes.jpg'),
(10, 'potiron', 8, 20, 2, 'potiron.png'),
(11, 'fraise', 3, 25, 1, 'fraise.jpg'),
(12, 'melon', 2.5, 8.9, 1, 'melon.jpg'),
(19, 'pastÃ¨que', 10.54, 6.5, 1, 'pasteque.jpg'),
(20, 'raisin', 12.75, 5.45, 1, 'raisins.jpg'),
(21, 'concombre', 6.4, 3.52, 2, 'concombre.png'),
(22, 'prune', 8.8, 5.6, 1, 'prune.jpg'),
(23, 'ognion', 6, 3.6, 2, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `quartier`
--

CREATE TABLE `quartier` (
  `numCartier` int(4) NOT NULL,
  `nomCartier` varchar(30) NOT NULL,
  `lienMaps` varchar(200) DEFAULT NULL,
  `numVille` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `quartier`
--

INSERT INTO `quartier` (`numCartier`, `nomCartier`, `lienMaps`, `numVille`) VALUES
(1, 'Les Baconnets', NULL, 1),
(2, 'Les Blagis', NULL, 2),
(3, 'Fontaine-Michalon', 'https://goo.gl/maps/wCFoYY5phV9HKBJs8', 1),
(4, 'Moulon', NULL, 4);

-- --------------------------------------------------------

--
-- Structure de la table `typeproduit`
--

CREATE TABLE `typeproduit` (
  `numTypeProduit` int(4) NOT NULL,
  `nomtypeproduit` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeproduit`
--

INSERT INTO `typeproduit` (`numTypeProduit`, `nomtypeproduit`) VALUES
(1, 'fruit'),
(2, 'légume'),
(3, 'céréale'),
(4, 'plante'),
(5, 'autre');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `numVille` int(4) NOT NULL,
  `nomville` varchar(30) NOT NULL,
  `CP` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`numVille`, `nomville`, `CP`) VALUES
(1, 'Antony', 92160),
(2, 'Sceaux', 92168),
(4, 'Orsay', 91320);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vueclient`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vueclient` (
`numClient` int(4)
,`nomclient` varchar(30)
,`prenomclient` varchar(30)
,`mail` varchar(100)
,`adresse` varchar(100)
,`limitdeprix` float
,`tel` varchar(30)
,`groupe` int(4)
,`numLivreur` int(4)
,`numCommande` int(4)
,`numCartier` int(4)
,`numCompte` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuecommande`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuecommande` (
`numCommande` int(4)
,`commandegroupe` tinyint(1)
,`jourlivrasion` varchar(30)
,`hebdomadaire` tinyint(1)
,`etatCommande` varchar(60)
,`datecommande` date
,`prixTotal` double
,`TVA` float
,`prixtotalnet` double
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuecommandepanier`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuecommandepanier` (
`numCommande` int(4)
,`numPanier` int(4)
,`quantite` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuecommandeproduit`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuecommandeproduit` (
`numCommande` int(4)
,`numProduit` int(4)
,`quantite` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuecompofamille`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuecompofamille` (
`numTypeProduit` int(4)
,`numFamille` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuecompopanier`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuecompopanier` (
`numPanier` int(4)
,`numProduit` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuecompte`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuecompte` (
`numCompte` int(4)
,`profil` varchar(30)
,`indentifiant` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuefamille`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuefamille` (
`numFamille` int(4)
,`saison` varchar(30)
,`categorie` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuelivreur`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuelivreur` (
`numLivreur` int(4)
,`nomlivreur` varchar(60)
,`prenomLivreur` varchar(50)
,`datelivraison` date
,`telLivreur` varchar(30)
,`mailLivreur` varchar(100)
,`numCompte` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuepanier`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuepanier` (
`numPanier` int(4)
,`nomPanier` varchar(60)
,`nbProduit` varchar(30)
,`quantite` int(4)
,`prixpanier` float
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vueproduit`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vueproduit` (
`numProduit` int(4)
,`nomproduit` varchar(30)
,`quantite` float
,`prixproduit` float
,`numTypeProduit` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuequartier`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuequartier` (
`numCartier` int(4)
,`nomCartier` varchar(30)
,`numVille` int(4)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vuetypeproduit`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vuetypeproduit` (
`numTypeProduit` int(4)
,`nomtypeproduit` varchar(30)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vueville`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vueville` (
`numVille` int(4)
,`nomville` varchar(30)
,`CP` int(5)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vueclient`
--
DROP TABLE IF EXISTS `vueclient`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vueclient`  AS SELECT `client`.`numClient` AS `numClient`, `client`.`nomclient` AS `nomclient`, `client`.`prenomclient` AS `prenomclient`, `client`.`mail` AS `mail`, `client`.`adresse` AS `adresse`, `client`.`limitdeprix` AS `limitdeprix`, `client`.`tel` AS `tel`, `client`.`groupe` AS `groupe`, `client`.`numLivreur` AS `numLivreur`, `client`.`numCommande` AS `numCommande`, `client`.`numCartier` AS `numCartier`, `client`.`numCompte` AS `numCompte` FROM `client` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuecommande`
--
DROP TABLE IF EXISTS `vuecommande`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuecommande`  AS SELECT `commande`.`numCommande` AS `numCommande`, `commande`.`commandegroupe` AS `commandegroupe`, `commande`.`jourlivrasion` AS `jourlivrasion`, `commande`.`hebdomadaire` AS `hebdomadaire`, `commande`.`etatCommande` AS `etatCommande`, `commande`.`datecommande` AS `datecommande`, `commande`.`prixTotal` AS `prixTotal`, `commande`.`TVA` AS `TVA`, `commande`.`prixtotalnet` AS `prixtotalnet` FROM `commande` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuecommandepanier`
--
DROP TABLE IF EXISTS `vuecommandepanier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuecommandepanier`  AS SELECT `commandepanier`.`numCommande` AS `numCommande`, `commandepanier`.`numPanier` AS `numPanier`, `commandepanier`.`quantite` AS `quantite` FROM `commandepanier` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuecommandeproduit`
--
DROP TABLE IF EXISTS `vuecommandeproduit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuecommandeproduit`  AS SELECT `commandeproduit`.`numCommande` AS `numCommande`, `commandeproduit`.`numProduit` AS `numProduit`, `commandeproduit`.`quantite` AS `quantite` FROM `commandeproduit` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuecompofamille`
--
DROP TABLE IF EXISTS `vuecompofamille`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuecompofamille`  AS SELECT `compofamille`.`numTypeProduit` AS `numTypeProduit`, `compofamille`.`numFamille` AS `numFamille` FROM `compofamille` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuecompopanier`
--
DROP TABLE IF EXISTS `vuecompopanier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuecompopanier`  AS SELECT `compopanier`.`numPanier` AS `numPanier`, `compopanier`.`numProduit` AS `numProduit` FROM `compopanier` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuecompte`
--
DROP TABLE IF EXISTS `vuecompte`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuecompte`  AS SELECT `compte`.`numCompte` AS `numCompte`, `compte`.`profil` AS `profil`, `compte`.`indentifiant` AS `indentifiant` FROM `compte` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuefamille`
--
DROP TABLE IF EXISTS `vuefamille`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuefamille`  AS SELECT `famille`.`numFamille` AS `numFamille`, `famille`.`saison` AS `saison`, `famille`.`categorie` AS `categorie` FROM `famille` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuelivreur`
--
DROP TABLE IF EXISTS `vuelivreur`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuelivreur`  AS SELECT `livreur`.`numLivreur` AS `numLivreur`, `livreur`.`nomlivreur` AS `nomlivreur`, `livreur`.`prenomLivreur` AS `prenomLivreur`, `livreur`.`datelivraison` AS `datelivraison`, `livreur`.`telLivreur` AS `telLivreur`, `livreur`.`mailLivreur` AS `mailLivreur`, `livreur`.`numCompte` AS `numCompte` FROM `livreur` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuepanier`
--
DROP TABLE IF EXISTS `vuepanier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuepanier`  AS SELECT `panier`.`numPanier` AS `numPanier`, `panier`.`nomPanier` AS `nomPanier`, `panier`.`nbProduit` AS `nbProduit`, `panier`.`quantite` AS `quantite`, `panier`.`prixpanier` AS `prixpanier` FROM `panier` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vueproduit`
--
DROP TABLE IF EXISTS `vueproduit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vueproduit`  AS SELECT `produit`.`numProduit` AS `numProduit`, `produit`.`nomproduit` AS `nomproduit`, `produit`.`quantite` AS `quantite`, `produit`.`prixproduit` AS `prixproduit`, `produit`.`numTypeProduit` AS `numTypeProduit` FROM `produit` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuequartier`
--
DROP TABLE IF EXISTS `vuequartier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuequartier`  AS SELECT `quartier`.`numCartier` AS `numCartier`, `quartier`.`nomCartier` AS `nomCartier`, `quartier`.`numVille` AS `numVille` FROM `quartier` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vuetypeproduit`
--
DROP TABLE IF EXISTS `vuetypeproduit`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vuetypeproduit`  AS SELECT `typeproduit`.`numTypeProduit` AS `numTypeProduit`, `typeproduit`.`nomtypeproduit` AS `nomtypeproduit` FROM `typeproduit` ;

-- --------------------------------------------------------

--
-- Structure de la vue `vueville`
--
DROP TABLE IF EXISTS `vueville`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vueville`  AS SELECT `ville`.`numVille` AS `numVille`, `ville`.`nomville` AS `nomville`, `ville`.`CP` AS `CP` FROM `ville` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`numClient`),
  ADD KEY `FK_clilivreur` (`numLivreur`),
  ADD KEY `FK_clicommande` (`numCommande`),
  ADD KEY `FK_clicartier` (`numCartier`),
  ADD KEY `FK_clicompte` (`numCompte`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`numCommande`);

--
-- Index pour la table `commandepanier`
--
ALTER TABLE `commandepanier`
  ADD PRIMARY KEY (`numCommande`,`numPanier`),
  ADD KEY `FK_cppanier` (`numPanier`);

--
-- Index pour la table `commandeproduit`
--
ALTER TABLE `commandeproduit`
  ADD PRIMARY KEY (`numCommande`,`numProduit`),
  ADD KEY `FK_coproproduit` (`numProduit`);

--
-- Index pour la table `compofamille`
--
ALTER TABLE `compofamille`
  ADD PRIMARY KEY (`numTypeProduit`,`numFamille`),
  ADD KEY `FK_cffamille` (`numFamille`);

--
-- Index pour la table `compopanier`
--
ALTER TABLE `compopanier`
  ADD PRIMARY KEY (`numPanier`,`numProduit`),
  ADD KEY `FK_cpaproduit` (`numProduit`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`numCompte`);

--
-- Index pour la table `famille`
--
ALTER TABLE `famille`
  ADD PRIMARY KEY (`numFamille`);

--
-- Index pour la table `livreur`
--
ALTER TABLE `livreur`
  ADD PRIMARY KEY (`numLivreur`),
  ADD KEY `FK_livcompte` (`numCompte`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`numPanier`);

--
-- Index pour la table `producteur`
--
ALTER TABLE `producteur`
  ADD PRIMARY KEY (`identifiant`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`numProduit`),
  ADD KEY `FK_protypeproduit` (`numTypeProduit`);

--
-- Index pour la table `quartier`
--
ALTER TABLE `quartier`
  ADD PRIMARY KEY (`numCartier`),
  ADD KEY `FK_ville` (`numVille`);

--
-- Index pour la table `typeproduit`
--
ALTER TABLE `typeproduit`
  ADD PRIMARY KEY (`numTypeProduit`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`numVille`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `numClient` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `numCommande` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `numCompte` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `famille`
--
ALTER TABLE `famille`
  MODIFY `numFamille` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `livreur`
--
ALTER TABLE `livreur`
  MODIFY `numLivreur` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `numPanier` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `numProduit` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `quartier`
--
ALTER TABLE `quartier`
  MODIFY `numCartier` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `typeproduit`
--
ALTER TABLE `typeproduit`
  MODIFY `numTypeProduit` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `numVille` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `FK_clicartier` FOREIGN KEY (`numCartier`) REFERENCES `quartier` (`numCartier`),
  ADD CONSTRAINT `FK_clicommande` FOREIGN KEY (`numCommande`) REFERENCES `commande` (`numCommande`),
  ADD CONSTRAINT `FK_clicompte` FOREIGN KEY (`numCompte`) REFERENCES `compte` (`numCompte`),
  ADD CONSTRAINT `FK_clilivreur` FOREIGN KEY (`numLivreur`) REFERENCES `livreur` (`numLivreur`);

--
-- Contraintes pour la table `commandepanier`
--
ALTER TABLE `commandepanier`
  ADD CONSTRAINT `FK_cpcommander` FOREIGN KEY (`numCommande`) REFERENCES `commande` (`numCommande`),
  ADD CONSTRAINT `FK_cppanier` FOREIGN KEY (`numPanier`) REFERENCES `panier` (`numPanier`);

--
-- Contraintes pour la table `commandeproduit`
--
ALTER TABLE `commandeproduit`
  ADD CONSTRAINT `FK_coprocommande` FOREIGN KEY (`numCommande`) REFERENCES `commande` (`numCommande`),
  ADD CONSTRAINT `FK_coproproduit` FOREIGN KEY (`numProduit`) REFERENCES `produit` (`numProduit`);

--
-- Contraintes pour la table `compofamille`
--
ALTER TABLE `compofamille`
  ADD CONSTRAINT `FK_cffamille` FOREIGN KEY (`numFamille`) REFERENCES `famille` (`numFamille`),
  ADD CONSTRAINT `FK_cftypeproduit` FOREIGN KEY (`numTypeProduit`) REFERENCES `typeproduit` (`numTypeProduit`);

--
-- Contraintes pour la table `compopanier`
--
ALTER TABLE `compopanier`
  ADD CONSTRAINT `FK_cpapanier` FOREIGN KEY (`numPanier`) REFERENCES `panier` (`numPanier`),
  ADD CONSTRAINT `FK_cpaproduit` FOREIGN KEY (`numProduit`) REFERENCES `produit` (`numProduit`);

--
-- Contraintes pour la table `livreur`
--
ALTER TABLE `livreur`
  ADD CONSTRAINT `FK_livcompte` FOREIGN KEY (`numCompte`) REFERENCES `compte` (`numCompte`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_protypeproduit` FOREIGN KEY (`numTypeProduit`) REFERENCES `typeproduit` (`numTypeProduit`);

--
-- Contraintes pour la table `quartier`
--
ALTER TABLE `quartier`
  ADD CONSTRAINT `FK_ville` FOREIGN KEY (`numVille`) REFERENCES `ville` (`numVille`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
