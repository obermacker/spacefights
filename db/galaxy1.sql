-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Jul 2016 um 23:15
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
-- Tabellenstruktur für Tabelle `construction_loops_defense`
--

CREATE TABLE IF NOT EXISTS `construction_loops_defense` (
  `id` INT(11) NOT NULL,
  `player_id` VARCHAR(58) NOT NULL,
  `planet_id` int(11) NOT NULL,
  `defense_id` int(11) NOT NULL,
  `required_iron` bigint(20) NOT NULL,
  `required_silicon` bigint(20) NOT NULL,
  `required_water` bigint(20) NOT NULL,
  `required_bots` INT(11) NOT NULL,
  `required_karma` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `construction_time_start` int(9) NOT NULL,
  `construction_time` int(9) NOT NULL,
  `construction_time_end` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bauschleifeflotte`
--

CREATE TABLE IF NOT EXISTS `bauschleifeflotte` (
  `ID` int(11) NOT NULL,
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
  `Bauzeit_Bis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `flotten`
--

CREATE TABLE IF NOT EXISTS `flotten` (
  `ID` int(11) NOT NULL,
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
  `Startplanet_Name` varchar(20) NOT NULL,
  `Zielplanet_Name` varchar(20) NOT NULL,
  `Besitzer_Spieler_Name` varchar(18) NOT NULL,
  `Ziel_Spieler_Name` varchar(18) NOT NULL,
  `Mission` varchar(58) NOT NULL,
  `Kapazitaet` int(9) NOT NULL,
  `Ausladen_Eisen` bigint(20) NOT NULL,
  `Ausladen_Silizium` bigint(20) NOT NULL,
  `Ausladen_Wasser` bigint(20) NOT NULL,
  `Einladen_Eisen` bigint(20) NOT NULL,
  `Einladen_Silizium` bigint(20) NOT NULL,
  `Einladen_Wasser` bigint(20) NOT NULL,
  `Schiff_Typ_1` int(11) NOT NULL,
  `Schiff_Typ_2` int(11) NOT NULL,
  `Schiff_Typ_3` int(11) NOT NULL,
  `Schiff_Typ_4` int(11) NOT NULL,
  `Schiff_Typ_5` int(11) NOT NULL,
  `Schiff_Typ_6` int(11) NOT NULL,
  `Schiff_Typ_7` int(11) NOT NULL,
  `Schiff_Typ_8` int(11) NOT NULL,
  `Schiff_Typ_9` int(11) NOT NULL,
  `Schiff_Typ_10` int(11) NOT NULL,
  `Schiff_Typ_11` int(11) NOT NULL,
  `Schiff_Typ_12` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `handelsangebot`
--

CREATE TABLE IF NOT EXISTS `handelsangebot` (
  `ID` int(9) NOT NULL,
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
  `Bemerkung` varchar(10) COLLATE latin1_german2_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `ID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Last_Planet` int(11) NOT NULL,
  `Max_Planeten` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `Spieler_ID` varchar(58) NOT NULL,
  `Planet_ID` int(11) NOT NULL,
  `typ` varchar(58) NOT NULL,
  `text` text NOT NULL,
  `gelesen` tinyint(1) NOT NULL,
  `erstellt` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachrichten`
--

CREATE TABLE IF NOT EXISTS `nachrichten` (
  `ID` int(11) NOT NULL,
  `Zeit` int(11) NOT NULL,
  `Absender_ID` varchar(58) COLLATE latin1_german2_ci NOT NULL,
  `Absender_Name` varchar(20) COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_ID` varchar(58) COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_Name` varchar(20) COLLATE latin1_german2_ci NOT NULL,
  `Gelesen` int(9) NOT NULL,
  `Betreff` varchar(80) COLLATE latin1_german2_ci NOT NULL,
  `Text` text COLLATE latin1_german2_ci NOT NULL,
  `Logbuch` int(9) NOT NULL,
  `Chatbot` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=307 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `planet`
--

CREATE TABLE IF NOT EXISTS `planet` (
  `ID` int(11) NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `Spieler_Name` varchar(20) NOT NULL,
  `Planet_Name` varchar(50) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  `Planet_ID` int(11) NOT NULL,
  `Ressource_Eisen` decimal(20,2) NOT NULL,
  `Ressource_Silizium` decimal(20,2) NOT NULL,
  `Ressource_Wasser` decimal(20,2) NOT NULL,
  `Ressource_Bot` decimal(20,6) NOT NULL,
  `Stationiert_Bot` decimal(20,6) NOT NULL,
  `Stufe_Gebaeude_1` int(11) NOT NULL,
  `Stufe_Gebaeude_2` int(11) NOT NULL,
  `Stufe_Gebaeude_3` int(11) NOT NULL,
  `Stufe_Gebaeude_4` int(11) NOT NULL,
  `Stufe_Gebaeude_5` int(11) NOT NULL,
  `Stufe_Gebaeude_6` int(11) NOT NULL,
  `Stufe_Gebaeude_7` int(11) NOT NULL,
  `Stufe_Gebaeude_8` int(11) NOT NULL,
  `Stufe_Gebaeude_9` int(11) NOT NULL,
  `Stufe_Gebaeude_10` int(11) NOT NULL,
  `Stufe_Gebaeude_11` int(11) NOT NULL,
  `Grund_Prod_Eisen` int(11) NOT NULL DEFAULT '20',
  `Grund_Prod_Silizium` int(11) NOT NULL DEFAULT '10',
  `Grund_Prod_Wasser` int(11) NOT NULL DEFAULT '5',
  `Prod_Eisen` int(11) NOT NULL,
  `Prod_Silizium` int(11) NOT NULL,
  `Prod_Wasser` int(11) NOT NULL,
  `Produktion_Zeit` int(11) NOT NULL,
  `Ressource_Energie` int(11) NOT NULL,
  `Ressource_Karma` int(11) NOT NULL,
  `Bauschleife_Gebaeude_ID` int(11) NOT NULL,
  `Bauschleife_Gebaeude_Start` int(11) NOT NULL,
  `Bauschleife_Gebaeude_Bis` int(9) NOT NULL,
  `Bauschleife_Gebaeude_Name` varchar(22) NOT NULL,
  `Bunker_Kapa` bigint(20) NOT NULL,
  `Bunker_Eisen` bigint(20) NOT NULL,
  `Bunker_Silizium` bigint(20) NOT NULL,
  `Bunker_Wasser` bigint(20) NOT NULL,
  `Bauschleife_Flotte_ID` int(11) NOT NULL,
  `Schiff_Typ_1` int(11) NOT NULL,
  `Schiff_Typ_2` int(11) NOT NULL,
  `Schiff_Typ_3` int(11) NOT NULL,
  `Schiff_Typ_4` int(11) NOT NULL,
  `Schiff_Typ_5` int(11) NOT NULL,
  `Schiff_Typ_6` int(11) NOT NULL,
  `Schiff_Typ_7` int(11) NOT NULL,
  `Schiff_Typ_8` int(11) NOT NULL,
  `Schiff_Typ_9` int(11) NOT NULL,
  `Schiff_Typ_10` int(11) NOT NULL,
  `Schiff_Typ_11` int(9) NOT NULL,
  `Schiff_Typ_12` int(11) NOT NULL,
  `Deff_Typ_1` int(11) NOT NULL,
  `Deff_Typ_2` int(11) NOT NULL,
  `Deff_Typ_3` int(11) NOT NULL,
  `Deff_Typ_4` int(11) NOT NULL,
  `Deff_Typ_5` int(11) NOT NULL,
  `Deff_Typ_6` int(11) NOT NULL,
  `Handel_Kapa` bigint(20) NOT NULL,
  `Handel_Eisen` bigint(20) NOT NULL,
  `Handel_Silizium` bigint(20) NOT NULL,
  `Handel_Wasser` bigint(20) NOT NULL,
  `punkte` decimal(11,5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sonnensystem`
--

CREATE TABLE IF NOT EXISTS `sonnensystem` (
  `ID` int(11) NOT NULL,
  `Spieler_ID` varchar(58) COLLATE latin1_german2_ci NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `Entdeckt` timestamp NULL DEFAULT NULL,
  `locked` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5395 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

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
  `punkte_structur` int(20) NOT NULL,
  `punkte_flotte` int(20) NOT NULL,
  `punkte_forschung` int(20) NOT NULL,
  `avatar` varchar(58) NOT NULL,
  `Letzter_Planet` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `construction_loops_defense`
--
ALTER TABLE `construction_loops_defense`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bauschleifeflotte`
--
ALTER TABLE `bauschleifeflotte`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `flotten`
--
ALTER TABLE `flotten`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `handelsangebot`
--
ALTER TABLE `handelsangebot`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `nachrichten`
--
ALTER TABLE `nachrichten`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `sonnensystem`
--
ALTER TABLE `sonnensystem`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `construction_loops_defense`
--
ALTER TABLE `construction_loops_defense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `bauschleifeflotte`
--
ALTER TABLE `bauschleifeflotte`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `flotten`
--
ALTER TABLE `flotten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `handelsangebot`
--
ALTER TABLE `handelsangebot`
  MODIFY `ID` int(9) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT für Tabelle `login`
--
ALTER TABLE `login`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `nachrichten`
--
ALTER TABLE `nachrichten`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=307;
--
-- AUTO_INCREMENT für Tabelle `planet`
--
ALTER TABLE `planet`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=188;
--
-- AUTO_INCREMENT für Tabelle `sonnensystem`
--
ALTER TABLE `sonnensystem`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5395;
--
-- AUTO_INCREMENT für Tabelle `spieler`
--
ALTER TABLE `spieler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
