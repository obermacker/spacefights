-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bauschleifedeff`;
CREATE TABLE `bauschleifedeff` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Spieler_ID` varchar(58) NOT NULL,
  `Planet_ID` int(11) NOT NULL,
  `Typ` int(11) NOT NULL,
  `Eisen` bigint(20) NOT NULL,
  `Silizium` bigint(20) NOT NULL,
  `Wasser` bigint(20) NOT NULL,
  `Karma` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Anzahl` int(11) NOT NULL,
  `Bauzeit_Von` int(9) NOT NULL,
  `Bauzeit_Einzel` int(9) NOT NULL,
  `Bauzeit_Bis` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `bauschleifeflotte`;
CREATE TABLE `bauschleifeflotte` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Spieler_ID` varchar(58) NOT NULL,
  `Planet_ID` int(11) NOT NULL,
  `Typ` int(11) NOT NULL,
  `Eisen` bigint(20) NOT NULL,
  `Silizium` bigint(20) NOT NULL,
  `Wasser` bigint(20) NOT NULL,
  `Karma` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Anzahl` int(11) NOT NULL,
  `Bauzeit_Von` int(9) NOT NULL,
  `Bauzeit_Einzel` int(9) NOT NULL,
  `Bauzeit_Bis` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `flotten`;
CREATE TABLE `flotten` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ankunft` int(9) NOT NULL,
  `Start` int(9) NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `x1` int(11) NOT NULL,
  `y1` int(11) NOT NULL,
  `z1` int(11) NOT NULL,
  `x2` int(11) NOT NULL,
  `y2` int(11) NOT NULL,
  `z2` int(11) NOT NULL,
  `Ziel_Spieler_ID` varchar(58) NOT NULL,
  `Start_Planet_ID` int(11) NOT NULL,
  `Ziel_Planet_ID` int(11) NOT NULL,
  `Startplanet_Name` varchar(50) NOT NULL,
  `Zielplanet_Name` varchar(50) NOT NULL,
  `Besitzer_Spieler_Name` varchar(18) NOT NULL,
  `Ziel_Spieler_Name` varchar(18) NOT NULL,
  `Mission` varchar(58) NOT NULL DEFAULT '0',
  `Kapazitaet` int(9) NOT NULL DEFAULT 0,
  `Ausladen_Eisen` bigint(20) NOT NULL DEFAULT 0,
  `Ausladen_Silizium` bigint(20) NOT NULL DEFAULT 0,
  `Ausladen_Wasser` bigint(20) NOT NULL DEFAULT 0,
  `Einladen_Eisen` bigint(20) NOT NULL DEFAULT 0,
  `Einladen_Silizium` bigint(20) NOT NULL DEFAULT 0,
  `Einladen_Wasser` bigint(20) NOT NULL DEFAULT 0,
  `Schiff_Typ_1` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_2` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_3` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_4` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_5` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_6` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_7` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_8` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_9` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_10` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_11` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_12` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `handelsangebot`;
CREATE TABLE `handelsangebot` (
  `ID` int(9) NOT NULL AUTO_INCREMENT,
  `Spieler_ID` int(9) NOT NULL,
  `Planet_ID` int(9) NOT NULL,
  `Verkauf` varchar(10) COLLATE latin1_german2_ci NOT NULL,
  `Verkauf_Menge` int(9) NOT NULL,
  `Kaufe` varchar(10) COLLATE latin1_german2_ci NOT NULL,
  `Kaufe_Menge` int(11) NOT NULL,
  `Spielername` varchar(100) COLLATE latin1_german2_ci NOT NULL,
  `Flugzeit` int(8) NOT NULL,
  `Locked` int(11) NOT NULL,
  `X` int(9) NOT NULL,
  `Y` int(9) NOT NULL,
  `Z` int(9) NOT NULL,
  `Bemerkung` varchar(10) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;


DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Last_Planet` int(11) NOT NULL,
  `Max_Planeten` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `Spieler_ID` varchar(58) NOT NULL,
  `Planet_ID` int(11) NOT NULL,
  `typ` varchar(58) NOT NULL,
  `text` text NOT NULL,
  `gelesen` tinyint(1) NOT NULL,
  `erstellt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `nachrichten`;
CREATE TABLE `nachrichten` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Zeit` int(11) NOT NULL,
  `Absender_ID` varchar(58) COLLATE latin1_german2_ci NOT NULL,
  `Absender_Name` varchar(20) COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_ID` varchar(58) COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_Name` varchar(20) COLLATE latin1_german2_ci NOT NULL,
  `Gelesen` int(9) NOT NULL DEFAULT 0,
  `Betreff` varchar(80) COLLATE latin1_german2_ci NOT NULL,
  `Text` text COLLATE latin1_german2_ci NOT NULL,
  `Logbuch` int(9) NOT NULL,
  `Chatbot` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;


DROP TABLE IF EXISTS `planet`;
CREATE TABLE `planet` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Spieler_ID` varchar(58) NOT NULL,
  `Spieler_Name` varchar(20) NOT NULL,
  `Planet_Name` varchar(50) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  `Planet_ID` int(11) NOT NULL DEFAULT 0,
  `Ressource_Eisen` decimal(20,2) NOT NULL DEFAULT 0.00,
  `Ressource_Silizium` decimal(20,2) NOT NULL DEFAULT 0.00,
  `Ressource_Wasser` decimal(20,2) NOT NULL DEFAULT 0.00,
  `Ressource_Bot` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `Stationiert_Bot` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `Stufe_Gebaeude_1` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_2` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_3` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_4` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_5` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_6` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_7` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_8` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_9` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_10` int(11) NOT NULL DEFAULT 0,
  `Stufe_Gebaeude_11` int(11) NOT NULL DEFAULT 0,
  `Grund_Prod_Eisen` int(11) NOT NULL DEFAULT 20,
  `Grund_Prod_Silizium` int(11) NOT NULL DEFAULT 10,
  `Grund_Prod_Wasser` int(11) NOT NULL DEFAULT 5,
  `Prod_Eisen` int(11) NOT NULL DEFAULT 0,
  `Prod_Silizium` int(11) NOT NULL DEFAULT 0,
  `Prod_Wasser` int(11) NOT NULL DEFAULT 0,
  `Produktion_Zeit` int(11) NOT NULL DEFAULT 0,
  `Ressource_Energie` int(11) NOT NULL DEFAULT 0,
  `Ressource_Karma` int(11) NOT NULL DEFAULT 0,
  `Bauschleife_Gebaeude_ID` int(11) NOT NULL DEFAULT 0,
  `Bauschleife_Gebaeude_Start` int(11) NOT NULL DEFAULT 0,
  `Bauschleife_Gebaeude_Bis` int(9) NOT NULL DEFAULT 0,
  `Bauschleife_Gebaeude_Name` varchar(22) NOT NULL DEFAULT '''''',
  `Bunker_Kapa` bigint(20) NOT NULL DEFAULT 0,
  `Bunker_Eisen` bigint(20) NOT NULL DEFAULT 0,
  `Bunker_Silizium` bigint(20) NOT NULL DEFAULT 0,
  `Bunker_Wasser` bigint(20) NOT NULL DEFAULT 0,
  `Bauschleife_Flotte_ID` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_1` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_2` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_3` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_4` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_5` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_6` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_7` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_8` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_9` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_10` int(11) NOT NULL DEFAULT 0,
  `Schiff_Typ_11` int(9) NOT NULL DEFAULT 0,
  `Schiff_Typ_12` int(11) NOT NULL DEFAULT 0,
  `Deff_Typ_1` int(11) NOT NULL DEFAULT 0,
  `Deff_Typ_2` int(11) NOT NULL DEFAULT 0,
  `Deff_Typ_3` int(11) NOT NULL DEFAULT 0,
  `Deff_Typ_4` int(11) NOT NULL DEFAULT 0,
  `Deff_Typ_5` int(11) NOT NULL DEFAULT 0,
  `Deff_Typ_6` int(11) NOT NULL DEFAULT 0,
  `Handel_Kapa` bigint(20) NOT NULL DEFAULT 0,
  `Handel_Eisen` bigint(20) NOT NULL DEFAULT 0,
  `Handel_Silizium` bigint(20) NOT NULL DEFAULT 0,
  `Handel_Wasser` bigint(20) NOT NULL DEFAULT 0,
  `punkte` decimal(11,5) NOT NULL DEFAULT 0.00000,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sonnensystem`;
CREATE TABLE `sonnensystem` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Spieler_ID` varchar(58) COLLATE latin1_german2_ci NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `Entdeckt` datetime NOT NULL,
  `locked` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;


DROP TABLE IF EXISTS `spieler`;
CREATE TABLE `spieler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Spieler_ID` varchar(58) NOT NULL,
  `Spieler_Name` varchar(30) NOT NULL,
  `Bot_Produktion_Zeit` int(11) NOT NULL,
  `Typ` varchar(12) NOT NULL,
  `Tech_1` int(11) NOT NULL DEFAULT 0,
  `Tech_2` int(11) NOT NULL DEFAULT 0,
  `Tech_3` int(11) NOT NULL DEFAULT 0,
  `Tech_4` int(11) NOT NULL DEFAULT 0,
  `Tech_5` int(11) NOT NULL DEFAULT 0,
  `Tech_6` int(11) NOT NULL DEFAULT 0,
  `Tech_7` int(11) NOT NULL DEFAULT 0,
  `Tech_8` int(11) NOT NULL DEFAULT 0,
  `Tech_9` int(11) NOT NULL DEFAULT 0,
  `Tech_10` int(11) NOT NULL DEFAULT 0,
  `Tech_11` int(11) NOT NULL DEFAULT 0,
  `Tech_12` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_ID` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_Eisen` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_Name` varchar(50) NOT NULL DEFAULT '0',
  `Tech_Schleife_Silizium` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_Wasser` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_Bauzeit_Start` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_Bauzeit_Bis` int(11) NOT NULL DEFAULT 0,
  `Tech_Schleife_Planet` int(11) NOT NULL DEFAULT 0,
  `punkte_structur` decimal(11,5) NOT NULL DEFAULT 0.00000,
  `punkte_flotte` decimal(11,5) NOT NULL DEFAULT 0.00000,
  `punkte_forschung` decimal(11,5) NOT NULL DEFAULT 0.00000,
  `avatar` varchar(58) NOT NULL DEFAULT '''''',
  `Letzter_Planet` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2021-01-26 20:04:15
