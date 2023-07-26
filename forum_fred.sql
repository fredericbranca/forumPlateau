-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum_fred
CREATE DATABASE IF NOT EXISTS `forum_fred` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum_fred`;

-- Listage de la structure de table forum_fred. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.categorie : ~5 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
	(1, 'Sport'),
	(2, 'Animaux'),
	(3, 'Technologie'),
	(4, 'Voyages'),
	(5, 'Cuisine');

-- Listage de la structure de table forum_fred. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.post : ~9 rows (environ)
INSERT INTO `post` (`id_post`, `topic_id`, `user_id`, `message`, `creationdate`) VALUES
	(16, 16, NULL, '&#60;p&#62;J&#39;aime bien les chats aussi !&#60;/p&#62;', '2023-07-24 08:58:35'),
	(75, 16, 7, '&#60;p&#62;Yos&#60;/p&#62;', '2023-07-24 21:17:39'),
	(78, 24, 6, '&#60;p&#62;&#60;strong&#62;bonjour&#60;/strong&#62;&#60;/p&#62;', '2023-07-25 13:30:36'),
	(79, 24, 6, '&#60;p&#62;freg gfre fr&#60;/p&#62;', '2023-07-25 16:07:50'),
	(82, 26, NULL, '&#60;p&#62;&#60;em&#62;ezaeazeaze&#60;/em&#62;&#60;/p&#62;', '2023-07-26 10:09:30'),
	(84, 27, NULL, '&#60;p&#62;gregergher&#60;/p&#62;', '2023-07-26 11:13:55'),
	(85, 23, 6, '&#60;p&#62;Test&#60;/p&#62;', '2023-07-26 13:30:04'),
	(86, 27, 6, '&#60;p&#62;test&#60;/p&#62;', '2023-07-26 13:32:07'),
	(87, 27, 7, '&#60;p&#62;test&#60;/p&#62;', '2023-07-26 13:32:23');

-- Listage de la structure de table forum_fred. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `cat_id` (`categorie_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`),
  CONSTRAINT `FK_sujet_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.topic : ~6 rows (environ)
INSERT INTO `topic` (`id_topic`, `categorie_id`, `user_id`, `titre`, `message`, `creationdate`, `closed`) VALUES
	(16, 2, NULL, 'Mon animal préféré', '&#60;p&#62;Quel est votre animal pr&#38;eacute;f&#38;eacute;r&#38;eacute; ? Le mien c&#39;est la Panth&#38;egrave;re noir&#60;/p&#62;', '2023-07-21 12:34:56', 0),
	(23, 1, 6, 'test', '&#60;p&#62;test&#60;/p&#62;', '2023-07-25 08:37:37', 0),
	(24, 1, 7, 'test', '&#60;p&#62;aaa&#60;/p&#62;', '2023-07-25 08:38:49', 0),
	(25, 2, 6, 'gebet', '&#60;p&#62;bethne&#60;/p&#62;', '2023-07-25 15:59:15', 0),
	(26, 4, NULL, 'Bonjour tout le monde', '&#60;p&#62;Comment allez vous&#38;nbsp; ?&#60;/p&#62;', '2023-07-26 10:09:15', 0),
	(27, 1, NULL, 'gtryh,', '&#60;p&#62;&#60;strong&#62;rtyjzrg&#60;/strong&#62;&#60;/p&#62;', '2023-07-26 11:13:43', 0);

-- Listage de la structure de table forum_fred. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ROLE_USER',
  `statut` datetime DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.user : ~2 rows (environ)
INSERT INTO `user` (`id_user`, `nickname`, `email`, `password`, `creationdate`, `role`, `statut`) VALUES
	(6, 'Admin', 'admin@gmail.com', '$2y$10$GmvYym/qu5Up33aDFHjbx.JPKKOf80fshtCvx1rQ07Bnr5s4vY6Zy', '2023-07-24 13:42:26', 'ROLE_ADMIN', NULL),
	(7, 'Snoux', 'snoux@gmail.com', '$2y$10$A5/YH4k3P3e.T6JBwGPnCeirYw.vd6WS6a7WBpw16gfSqiS2Dh6iu', '2023-07-24 15:02:51', 'ROLE_USER', '2023-07-26 11:12:00');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
