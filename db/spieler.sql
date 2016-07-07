-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Jul 2016 um 23:16
-- Server-Version: 5.6.24
-- PHP-Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `galaxy1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieler`
--

CREATE TABLE IF NOT EXISTS `spieler` (
  `ID` int(11) NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `Spieler_Name` varchar(30) NOT NULL,
  `Bot_Produktion_Zeit` int(11) NOT NULL,
  `Typ` int(9) NOT NULL,
  `Tech_1` int(11) NOT NULL,
  `Tech_2` int(11) NOT NULL,
  `Tech_3` int(11) NOT NULL,
  `Tech_4` int(11) NOT NULL,
  `Tech_5` int(11) NOT NULL,
  `Tech_6` int(11) NOT NULL,
  `Tech_7` int(11) NOT NULL,
  `Tech_8` int(11) NOT NULL,
  `Tech_9` int(11) NOT NULL,
  `Tech_10` int(11) NOT NULL,
  `Tech_11` int(11) NOT NULL,
  `Tech_12` int(11) NOT NULL,
  `Tech_Schleife_ID` int(11) NOT NULL,
  `Tech_Schleife_Eisen` int(11) NOT NULL,
  `Tech_Schleife_Name` varchar(50) NOT NULL,
  `Tech_Schleife_Silizium` int(11) NOT NULL,
  `Tech_Schleife_Wasser` int(11) NOT NULL,
  `Tech_Schleife_Bauzeit_Start` int(11) NOT NULL,
  `Tech_Schleife_Bauzeit_Bis` int(11) NOT NULL,
  `Tech_Schleife_Planet` int(11) NOT NULL,
  `punkte_structur` decimal(11,5) NOT NULL,
  `punkte_flotte` decimal(11,5) NOT NULL,
  `punkte_forschung` decimal(11,5) NOT NULL,
  `avatar` varchar(58) NOT NULL,
  `Letzter_Planet` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `spieler`
--
ALTER TABLE `spieler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
