# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Värd: localhost (MySQL 5.5.42)
# Databas: test
# Genereringstid: 2016-12-13 14:04:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Tabelldump status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL DEFAULT '' COMMENT 'Account activation code.',
  `user_id` int(11) unsigned NOT NULL,
  `active` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `status` WRITE;
/*!40000 ALTER TABLE `status` DISABLE KEYS */;

INSERT INTO `status` (`id`, `code`, `user_id`, `active`)
VALUES
	(1,'abc123',1,1),
	(4,'8778dd',18,1);

/*!40000 ALTER TABLE `status` ENABLE KEYS */;
UNLOCK TABLES;


# Tabelldump user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `activity` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `username`, `password`, `email`, `name`, `activity`)
VALUES
	(1,'kalle','$2y$10$c4JYh.najxW9XLMHXLLLj.cTvcGlKrbqgYD.VyrCZniFAqJzqpJ0y','','Admin Steve','2016-12-13 13:08:59'),
	(2,'','','test@example.com','Aron Author',NULL),
	(3,'','','joe@example.com','Joe User',NULL),
	(4,'','','penny@example.com','Penny Premium',NULL),
	(5,'anka','$2y$10$h72/dDJH.ypqiC4jIul24.tZ0UMwKYsT7CwLy8eI.sHSRlT08LK8q','anka@example.com','',NULL),
	(6,'panda','$2y$10$88eGE0eqxRk7we0bNVrEBuPX6UJoJOIqeH7hYiTBfOpZOCTHPRA5q','panda@example.com','',NULL),
	(9,'arne','$2y$10$Dm6hQGKLEkjmTq7S0QTd1ulpAlvWt0Q3c56uxh5ZPUPQg4MY3waWm','arne@example.com','',NULL),
	(11,'knasboll','$2y$10$RgSE.dkpj5V43fuLyddTVOnD1QRkH0zCw4TxEikpG5AoH8tFanJ.y','knasboll@example.com','',NULL),
	(18,'keha76','$2y$10$N5JaJcUUQi9H0l9odpvsLO18oQ8QIGYvyl2YxYwUZXhPrOneA/GOS','keha76@example.com','',NULL);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;