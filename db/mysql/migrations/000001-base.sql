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

-- Дамп структуры для таблица phamily_test.gender
CREATE TABLE IF NOT EXISTS `gender` (
  `gender` varchar(6) NOT NULL,
  PRIMARY KEY (`gender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.gender: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `gender` DISABLE KEYS */;
INSERT INTO `gender` (`gender`) VALUES
	('female'),
	('male');
/*!40000 ALTER TABLE `gender` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.name_type
CREATE TABLE IF NOT EXISTS `name_type` (
  `name_type` varchar(50) NOT NULL,
  PRIMARY KEY (`name_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.name_type: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `name_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `name_type` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.persona
CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `father_id` int(10) unsigned DEFAULT NULL,
  `mother_id` int(10) unsigned DEFAULT NULL,
  `gender` varchar(6) NOT NULL,
  `dateOfBirth` bigint(20) unsigned DEFAULT NULL,
  `dateOfDeath` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_persona_persona` (`father_id`),
  KEY `FK_persona_persona_2` (`mother_id`),
  KEY `FK_persona_gender` (`gender`),
  CONSTRAINT `FK_persona_gender` FOREIGN KEY (`gender`) REFERENCES `gender` (`gender`),
  CONSTRAINT `FK_persona_persona` FOREIGN KEY (`father_id`) REFERENCES `persona` (`id`),
  CONSTRAINT `FK_persona_persona_2` FOREIGN KEY (`mother_id`) REFERENCES `persona` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.persona: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;


-- Дамп структуры для таблица phamily_test.persona_has_names
CREATE TABLE IF NOT EXISTS `persona_has_names` (
  `persona_id` int(11) unsigned NOT NULL,
  `name_type` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`persona_id`,`name_type`),
  KEY `FK_persona_has_names_name_type` (`name_type`),
  CONSTRAINT `FK_persona_has_names_name_type` FOREIGN KEY (`name_type`) REFERENCES `name_type` (`name_type`),
  CONSTRAINT `FK_persona_has_names_persona` FOREIGN KEY (`persona_id`) REFERENCES `persona` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы phamily_test.persona_has_names: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `persona_has_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `persona_has_names` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
