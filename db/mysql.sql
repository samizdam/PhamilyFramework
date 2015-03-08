-- --------------------------------------------------------
-- Хост:                         192.168.1.42
-- Версия сервера:               5.5.38-0ubuntu0.14.04.1 - (Ubuntu)
-- ОС Сервера:                   debian-linux-gnu
-- HeidiSQL Версия:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица phamily_test.anthroponym
DROP TABLE IF EXISTS `anthroponym`;
CREATE TABLE IF NOT EXISTS `anthroponym` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`type`,`value`),
  UNIQUE KEY `id` (`id`),
  CONSTRAINT `fk_anthroponym_anthroponym_type` FOREIGN KEY (`type`) REFERENCES `anthroponym_type` (`anthroponym_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.anthroponym: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `anthroponym` DISABLE KEYS */;
/*!40000 ALTER TABLE `anthroponym` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.anthroponym_type
DROP TABLE IF EXISTS `anthroponym_type`;
CREATE TABLE IF NOT EXISTS `anthroponym_type` (
  `anthroponym_type` varchar(255) NOT NULL,
  PRIMARY KEY (`anthroponym_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.anthroponym_type: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `anthroponym_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `anthroponym_type` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.gender
DROP TABLE IF EXISTS `gender`;
CREATE TABLE IF NOT EXISTS `gender` (
  `gender` varchar(6) NOT NULL,
  PRIMARY KEY (`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.gender: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` (`gender`) VALUES
	('female'),
	('male');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.persona
DROP TABLE IF EXISTS `persona`;
CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fatherId` int(10) unsigned DEFAULT NULL,
  `motherId` int(10) unsigned DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `dateOfBirth` bigint(20) unsigned DEFAULT NULL,
  `dateOfDeath` bigint(20) unsigned DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_persona_gender` (`gender`),
  KEY `fk_persona_father` (`fatherId`),
  KEY `fk_persona_mother` (`motherId`),
  CONSTRAINT `fk_persona_father` FOREIGN KEY (`fatherId`) REFERENCES `persona` (`id`),
  CONSTRAINT `fk_persona_gender` FOREIGN KEY (`gender`) REFERENCES `gender` (`gender`),
  CONSTRAINT `fk_persona_mother` FOREIGN KEY (`motherId`) REFERENCES `persona` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.persona: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.persona_has_names
DROP TABLE IF EXISTS `persona_has_names`;
CREATE TABLE IF NOT EXISTS `persona_has_names` (
  `personaId` int(11) unsigned NOT NULL,
  `nameId` int(11) unsigned NOT NULL,
  KEY `fk_persona_has_names_anthroponym` (`nameId`),
  KEY `fk_persona_has_names_persona` (`personaId`),
  CONSTRAINT `fk_persona_has_names_anthroponym` FOREIGN KEY (`nameId`) REFERENCES `anthroponym` (`id`),
  CONSTRAINT `fk_persona_has_names_persona` FOREIGN KEY (`personaId`) REFERENCES `persona` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.persona_has_names: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `persona_has_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona_has_names` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.spouse_relationship
DROP TABLE IF EXISTS `spouse_relationship`;
CREATE TABLE IF NOT EXISTS `spouse_relationship` (
  `husbandId` int(10) unsigned NOT NULL,
  `wifeId` int(10) unsigned NOT NULL,
  KEY `fk_persona_husband` (`husbandId`),
  KEY `fk_persona_wife` (`wifeId`),
  CONSTRAINT `fk_persona_husband` FOREIGN KEY (`husbandId`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_persona_wife` FOREIGN KEY (`wifeId`) REFERENCES `persona` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.spouse_relationship: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `spouse_relationship` DISABLE KEYS */;
/*!40000 ALTER TABLE `spouse_relationship` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
