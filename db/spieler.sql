-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `spieler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `spieler_ID` varchar(58) NOT NULL,
  `spieler_name` varchar(30) NOT NULL,
  `name_galaxy_1` varchar(30) NOT NULL,
  `name_galaxy_2` varchar(30) NOT NULL,
  `name_galaxy_3` varchar(30) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `letzter_login` int(9) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `HTTP_USER_AGENT` varchar(255) NOT NULL,
  `spieler_geloescht` int(11) NOT NULL,
  `name_gala_1` varchar(30) NOT NULL,
  `aktiv_gala_1` int(11) NOT NULL,
  `letzter_Planet` int(11) NOT NULL,
  `max_Planeten` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `spieler_ID` (`spieler_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2021-01-23 20:32:41
