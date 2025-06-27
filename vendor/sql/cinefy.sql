# ************************************************************
# Sequel Ace SQL dump
# Version 20094
#
# https://sequel-ace.com/
# https://github.com/Sequel-Ace/Sequel-Ace
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.6.12-MariaDB-1:10.6.12+maria~ubu2004-log)
# Database: cinefy
# Generation Time: 2025-06-27 19:23:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE='NO_AUTO_VALUE_ON_ZERO', SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table movies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movies`;

CREATE TABLE `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `movies` WRITE;
/*!40000 ALTER TABLE `movies` DISABLE KEYS */;

INSERT INTO `movies` (`id`, `title`, `photo_url`, `description`)
VALUES
	(1,'28 Years Later','28_years_later.webp','Jeden z ocalałych po epidemii groźnego wirusa opuszcza małą wyspę i udaje się na stały ląd. Wkrótce odkrywa, że zmutowali nie tylko zarażeni, ale także ci, którzy przetrwali.'),
	(2,'Amateur','amateur.webp','Żona zatrudnionego w CIA kryptologa ginie w zamachu terrorystycznym w Londynie. Nie zważając na konsekwencje mężczyzna postanawia znaleźć winnych.'),
	(3,'Captain America','captain_america.webp','Sam Wilson, który oficjalnie przyjął rolę Kapitana Ameryki, znajduje się w samym środku międzynarodowego incydentu.'),
	(4,'Criminal Minds','criminal_minds.webp','Członkowie Jednostki Analiz Behawioralnych pomagają w ujęciu najgroźniejszych morderców.'),
	(5,'Ironheart','ironheart.webp','Riri Williams, genialna wynalazczyni, tworzy najbardziej zaawansowany kostium od czasów Iron Mana.');

/*!40000 ALTER TABLE `movies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table movies_seat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movies_seat`;

CREATE TABLE `movies_seat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `movies_seat` WRITE;
/*!40000 ALTER TABLE `movies_seat` DISABLE KEYS */;

INSERT INTO `movies_seat` (`id`, `session_id`, `seat_id`)
VALUES
	(1,4,13),
	(2,4,16),
	(3,4,17),
	(13,2,15),
	(14,2,16),
	(15,2,17),
	(19,2,21),
	(20,2,22),
	(21,2,23);

/*!40000 ALTER TABLE `movies_seat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table movies_session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movies_session`;

CREATE TABLE `movies_session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `movies_session` WRITE;
/*!40000 ALTER TABLE `movies_session` DISABLE KEYS */;

INSERT INTO `movies_session` (`id`, `movie_id`, `date`, `type`)
VALUES
	(1,2,'2025-06-26 14:30:00',1),
	(2,2,'2025-06-26 17:45:00',1),
	(3,2,'2025-06-26 15:30:00',2),
	(4,2,'2025-06-26 18:25:00',2),
	(6,2,'2025-06-26 21:30:00',3),
	(7,2,'2025-06-27 20:45:00',1);

/*!40000 ALTER TABLE `movies_session` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
