-- --------------------------------------------------------
-- Script SQL Final - Projet SAE 203 (Boole & Bin)
-- --------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- 1. Table des UTILISATEURS
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo_user` varchar(50) NOT NULL,
  `mp_user` varchar(255) NOT NULL, -- Mot de passe haché
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `pseudo_user` (`pseudo_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion d'un Admin de test (Pseudo: test / MDP: test)
INSERT INTO `users` (`id_user`, `pseudo_user`, `mp_user`) VALUES
(1, 'test', '$2y$10$I.P.7/8.K.9.L.0.M.1.N.O.P.Q.R.S.T.U.V.W.X.Y.Z.0.1.2.3'),
(2, 'Admin', '$2y$10$I.P.7/8.K.9.L.0.M.1.N.O.P.Q.R.S.T.U.V.W.X.Y.Z.0.1.2.3'); -- J'ai renommé 'Loic' en 'Admin' pour faire plus officiel

-- --------------------------------------------------------

--
-- 2. Table des ARTICLES
--
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id_article` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `resume` text NOT NULL,
  `contenu` longtext NOT NULL,
  
  -- Nouveaux champs pour la communauté
  `id_user` int(11) DEFAULT NULL, -- NULL = Article Officiel, Sinon ID de l'auteur
  `statut` int(1) DEFAULT 0,      -- 0 = En attente, 1 = Approuvé
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id_article`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion des 6 Articles OFFICIELS (Statut = 1, Auteur = NULL)
INSERT INTO `articles` (`id_article`, `titre`, `resume`, `contenu`, `statut`, `id_user`) VALUES
(1, 'Histoire', 'Qui est George Boole ?', 'George Boole (1815-1864) est un mathématicien, logicien et philosophe britannique. Il est le créateur de la logique moderne, l\'algèbre de Boole, qui est à la base de l\'informatique d\'aujourd\'hui.', 1, NULL),
(2, 'Le Booléen', 'Vrai ou Faux ?', 'En informatique, un booléen est un type de variable à deux états. Les valeurs possibles sont TRUE (Vrai) ou FALSE (Faux). C\'est la base de toute condition (IF/ELSE).', 1, NULL),
(3, 'Le Binaire', 'Le langage machine', 'Le système binaire est un système de numération utilisant la base 2. On utilise uniquement deux chiffres : 0 et 1. C\'est ainsi que les ordinateurs stockent et traitent l\'information.', 1, NULL),
(4, 'Booléen et Binaire', 'Le lien logique', 'L\'algèbre de Boole s\'applique parfaitement au système binaire. Le 1 correspond à Vrai, le 0 correspond à Faux. Les portes logiques (AND, OR, NOT) manipulent ces bits.', 1, NULL),
(5, 'Application', 'À quoi ça sert ?', 'Les applications sont partout : processeurs, circuits électroniques, programmation, bases de données... Sans booléens, pas d\'informatique !', 1, NULL),
(6, 'Pour aller plus loin', 'Ressources', 'Voici quelques liens pour approfondir vos connaissances sur l\'algèbre de Boole et l\'architecture des ordinateurs.', 1, NULL);

-- Insertion de l'article de PRÉVENTION (Communauté)
INSERT INTO `articles` (`titre`, `resume`, `contenu`, `statut`, `id_user`, `date_creation`) VALUES
('Test', 'Règles de la communauté', 'Bienvenue sur l\'espace communautaire ! \r\n\r\nMerci de respecter les règles suivantes lors de la rédaction de vos articles :\r\n- Pas de contenu illicite ou illégal.\r\n- Pas de propos blessants, racistes ou haineux.\r\n- Vérifiez vos sources.\r\n\r\nTout contenu ne respectant pas ces règles sera immédiatement supprimé et l\'utilisateur pourra être banni.', 1, 2, NOW());

-- --------------------------------------------------------

--
-- 3. Table des MÉDIAS (Images)
--
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id_media` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'image',
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id_media`),
  KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Images des articles officiels
INSERT INTO `media` (`id_article`, `type`, `url`) VALUES
(1, 'image', 'img/George_Boole.webp'),
(2, 'image', 'img/True_or_False.webp'),
(3, 'image', 'img/Binary.avif'),
(5, 'image', 'img/Booléen_application.webp'),
(6, 'image', 'img/Pour_aller_plus_loin.webp');

-- --------------------------------------------------------

--
-- 4. Table des COMMENTAIRES
--
DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE `commentaires` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date_publication` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_commentaire`),
  KEY `id_user` (`id_user`),
  KEY `id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ajout d'un commentaire de test
INSERT INTO `commentaires` (`id_user`, `id_article`, `contenu`, `date_publication`) VALUES
(2, 1, 'C\'est noté chef !', NOW());

COMMIT;