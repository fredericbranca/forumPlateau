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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.categorie : ~0 rows (environ)
INSERT INTO `categorie` (`id_categorie`, `nom`) VALUES
	(1, 'Sport');

-- Listage de la structure de table forum_fred. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_post`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`),
  CONSTRAINT `FK_post_topic` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`),
  CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.post : ~9 rows (environ)
INSERT INTO `post` (`id_post`, `topic_id`, `user_id`, `message`, `creationdate`) VALUES
	(1, 2, 1, '&#60;p&#62;Bogrefr&#60;/p&#62;', '2023-07-19 09:08:22'),
	(2, 2, 1, '&#60;p&#62;daza&#60;/p&#62;', '2023-07-19 09:08:38'),
	(3, 8, 1, '&#60;p&#62;Bonjour&#60;/p&#62;', '2023-07-21 11:23:10'),
	(4, 1, 1, '&#60;p&#62;salut&#60;/p&#62;', '2023-07-21 11:23:53'),
	(5, 9, 1, '&#60;p&#62;gtest&#60;/p&#62;', '2023-07-21 11:26:49'),
	(6, 9, 1, '&#60;p&#62;&#60;strong&#62;Salut &#38;ccedil;a&#60;span style=&#34;background-color: #f1c40f;&#34;&#62; va ?&#38;nbsp;&#60;/span&#62;&#60;/strong&#62;&#60;/p&#62;', '2023-07-21 13:56:50'),
	(7, 9, 1, '&#60;p&#62;test&#60;/p&#62;', '2023-07-21 14:48:28'),
	(8, 9, 1, '&#60;p&#62;test&#60;/p&#62;', '2023-07-21 14:51:16'),
	(9, 2, 1, '&#60;p&#62;xzxz&#60;/p&#62;', '2023-07-21 16:17:26');

-- Listage de la structure de table forum_fred. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `user_id` int NOT NULL,
  `titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `closed` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_topic`) USING BTREE,
  KEY `user_id` (`user_id`),
  KEY `cat_id` (`categorie_id`) USING BTREE,
  CONSTRAINT `FK_sujet_categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`),
  CONSTRAINT `FK_sujet_users` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.topic : ~5 rows (environ)
INSERT INTO `topic` (`id_topic`, `categorie_id`, `user_id`, `titre`, `message`, `creationdate`, `closed`) VALUES
	(1, 1, 1, 'testTitre', '<p><strong>rfzetrhhyrjyujjyjrfr</strong></p>', '2023-07-17 16:07:47', 0),
	(2, 1, 1, 'test2', '&#60;p&#62;salut &#38;ccedil;av a ?2&#60;/p&#62;', '2023-07-17 16:08:11', 0),
	(7, 1, 1, 'aze', '&#60;p&#62;azeeza&#60;/p&#62;', '2023-07-21 09:50:10', 0),
	(8, 1, 1, 'trhet', '&#60;p&#62;egerjtr&#60;/p&#62;', '2023-07-21 10:05:29', 0),
	(9, 1, 1, 'ghyuiykutjytrhergzef', '&#60;p&#62;&#60;strong&#62;trhntrjtr&#60;/strong&#62;&#60;/p&#62;', '2023-07-21 10:08:06', 0);

-- Listage de la structure de table forum_fred. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickname` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creationdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'ROLE_USER',
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum_fred.user : ~1 rows (environ)
INSERT INTO `user` (`id_user`, `nickname`, `email`, `password`, `creationdate`, `role`) VALUES
	(1, 'test', 'test', 'test', '2023-07-17 16:07:25', 'ROLE_USER');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
