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
  `modifiedmessagedate` datetime DEFAULT NULL,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.post : ~5 rows (environ)
INSERT INTO `post` (`id_post`, `topic_id`, `user_id`, `message`, `creationdate`, `modifiedmessagedate`) VALUES
	(78, 24, 6, '&#60;h1&#62;&#60;span style=&#34;background-color: #000000;&#34;&#62;&#60;em&#62;Bonjour&#60;/em&#62;&#60;/span&#62;&#60;/h1&#62;&#60;p&#62;Ceci est un test&#60;/p&#62;&#60;ul style=&#34;list-style-type: square;&#34;&#62;&#60;li&#62;14&#60;/li&#62;&#60;li&#62;2&#60;/li&#62;&#60;li&#62;3&#60;/li&#62;&#60;li&#62;4&#60;/li&#62;&#60;li&#62;Test&#60;/li&#62;&#60;/ul&#62;', '2023-07-25 13:30:36', '2023-07-31 18:50:22'),
	(79, 24, 6, '&#60;p&#62;freg gfre fr&#60;/p&#62;', '2023-07-25 16:07:50', NULL),
	(82, 26, NULL, '&#60;p&#62;&#60;em&#62;ezaeazeaze&#60;/em&#62;&#60;/p&#62;', '2023-07-26 10:09:30', NULL),
	(88, 24, 7, '&#60;p&#62;htrejetj&#60;/p&#62;', '2023-07-26 14:11:35', '2023-07-28 11:39:59'),
	(89, 26, 6, '&#60;p&#62;Test&#60;/p&#62;', '2023-07-27 22:45:54', NULL),
	(93, 24, 6, '&#60;p&#62;test&#60;/p&#62;', '2023-07-31 20:04:24', NULL);

-- Listage de la structure de table forum_fred. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedmessagedate` datetime DEFAULT NULL,
  `closed` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `cat_id` (`categorie_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`),
  CONSTRAINT `FK_sujet_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.topic : ~4 rows (environ)
INSERT INTO `topic` (`id_topic`, `categorie_id`, `user_id`, `titre`, `message`, `creationdate`, `modifiedmessagedate`, `closed`) VALUES
	(24, 1, 7, 'test', '&#60;p&#62;test&#60;/p&#62;', '2023-07-25 08:38:49', '2023-07-28 11:56:01', 1),
	(25, 2, 6, 'gebet', '&#60;p&#62;bethne&#60;/p&#62;', '2023-07-25 15:59:15', NULL, 0),
	(26, 4, NULL, 'Bonjour tout le monde', '&#60;p&#62;Comment allez vous&#38;nbsp; ?&#38;nbsp;&#38;nbsp;&#60;/p&#62;', '2023-07-26 10:09:15', '2023-07-31 15:36:51', 0),
	(28, 1, 6, 'test', '&#60;p&#62;Bonjour&#60;/p&#62;', '2023-07-28 09:58:25', '2023-07-28 13:27:45', 0),
	(29, 5, 6, 'NOuveau test', '&#60;p&#62;Bonjour, je vais cuisiner des tacos !&#60;/p&#62;', '2023-07-30 01:46:45', NULL, 0);

-- Listage de la structure de table forum_fred. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ROLE_USER',
  `statut` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.user : ~3 rows (environ)
INSERT INTO `user` (`id_user`, `nickname`, `email`, `password`, `creationdate`, `role`, `statut`) VALUES
	(6, 'Snoux', 'snoux@gmail.com', '$2y$10$y0IU0tJT57zgfhFkGW2RC.18viEZwcADae5FXv74sFWzPGZXhJJ9K', '2023-07-24 13:42:26', 'ROLE_ADMIN', '2023-07-27 22:17:19'),
	(7, 'Alice', 'alice@gmail.com', '$2y$10$A5/YH4k3P3e.T6JBwGPnCeirYw.vd6WS6a7WBpw16gfSqiS2Dh6iu', '2023-07-24 13:42:26', 'ROLE_USER', '2023-07-26 18:21:31'),
	(19, 'Paul', 'paul@gmail.com', '$2y$10$gNQJQPJ1.bB6CB8P/Bh3duYDN.q.9laCxpt4aYfjCTHxImPulxqpm', '2023-07-27 21:49:08', 'ROLE_USER', '2023-07-27 22:17:19');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
