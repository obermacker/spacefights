-- phpMyAdmin SQL Dump
-- version 4.9.7deb1
-- https://www.phpmyadmin.net/
--
-- Erstellungszeit: 28. Jan 2024 um 23:09
-- Server-Version: 8.0.35-27
-- PHP-Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `galaxy1`
--
CREATE DATABASE IF NOT EXISTS `galaxy1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `galaxy1`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bauschleifeflotte`
--

CREATE TABLE `bauschleifeflotte` (
  `ID` int NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `Planet_ID` int NOT NULL,
  `Typ` int NOT NULL,
  `Eisen` bigint NOT NULL,
  `Silizium` bigint NOT NULL,
  `Wasser` bigint NOT NULL,
  `Karma` int NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Anzahl` int NOT NULL,
  `Bauzeit_Von` int NOT NULL,
  `Bauzeit_Einzel` int NOT NULL,
  `Bauzeit_Bis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `chat`
--

CREATE TABLE `chat` (
  `ID` int NOT NULL,
  `PlayerId` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MessageFromPlayerName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MessageText` varchar(550) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MessageTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `chat_color` varchar(6) NOT NULL DEFAULT 'FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `construction_loops_defense`
--

CREATE TABLE `construction_loops_defense` (
  `id` int NOT NULL,
  `player_id` varchar(58) NOT NULL,
  `planet_id` int NOT NULL,
  `defense_id` int NOT NULL,
  `required_iron` bigint NOT NULL,
  `required_silicon` bigint NOT NULL,
  `required_water` bigint NOT NULL,
  `required_karma` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` int NOT NULL,
  `construction_time_start` int NOT NULL,
  `construction_time` int NOT NULL,
  `construction_time_end` int NOT NULL,
  `required_bots` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `flotten`
--

CREATE TABLE `flotten` (
  `ID` int NOT NULL,
  `Ankunft` int NOT NULL,
  `Start` int NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `x1` int NOT NULL,
  `y1` int NOT NULL,
  `z1` int NOT NULL,
  `x2` int NOT NULL,
  `y2` int NOT NULL,
  `z2` int NOT NULL,
  `Ziel_Spieler_ID` varchar(58) NOT NULL,
  `Start_Planet_ID` int NOT NULL,
  `Ziel_Planet_ID` int NOT NULL,
  `Startplanet_Name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Zielplanet_Name` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Besitzer_Spieler_Name` varchar(18) NOT NULL,
  `Ziel_Spieler_Name` varchar(18) NOT NULL,
  `Mission` varchar(58) NOT NULL,
  `Kapazitaet` int NOT NULL,
  `Ausladen_Eisen` bigint NOT NULL,
  `Ausladen_Silizium` bigint NOT NULL,
  `Ausladen_Wasser` bigint NOT NULL,
  `Einladen_Eisen` bigint NOT NULL,
  `Einladen_Silizium` bigint NOT NULL,
  `Einladen_Wasser` bigint NOT NULL,
  `Schiff_Typ_1` int DEFAULT NULL,
  `Schiff_Typ_2` int DEFAULT NULL,
  `Schiff_Typ_3` int DEFAULT NULL,
  `Schiff_Typ_4` int DEFAULT NULL,
  `Schiff_Typ_5` int DEFAULT NULL,
  `Schiff_Typ_6` int DEFAULT NULL,
  `Schiff_Typ_7` int DEFAULT NULL,
  `Schiff_Typ_8` int DEFAULT NULL,
  `Schiff_Typ_9` int DEFAULT NULL,
  `Schiff_Typ_10` int DEFAULT NULL,
  `Schiff_Typ_11` int DEFAULT NULL,
  `Schiff_Typ_12` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `handelsangebot`
--

CREATE TABLE `handelsangebot` (
  `ID` int NOT NULL,
  `Spieler_ID` int NOT NULL,
  `Planet_ID` int NOT NULL,
  `Verkauf` varchar(10) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Verkauf_Menge` int NOT NULL,
  `Kaufe` varchar(10) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Kaufe_Menge` int NOT NULL,
  `Spielername` varchar(100) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Flugzeit` int NOT NULL,
  `Locked` int NOT NULL,
  `X` int NOT NULL,
  `Y` int NOT NULL,
  `Z` int NOT NULL,
  `Bemerkung` varchar(10) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login`
--

CREATE TABLE `login` (
  `ID` int NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Last_Planet` int NOT NULL,
  `Max_Planeten` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message`
--

CREATE TABLE `message` (
  `Spieler_ID` varchar(58) NOT NULL,
  `Planet_ID` int NOT NULL,
  `typ` varchar(58) NOT NULL,
  `text` text NOT NULL,
  `gelesen` tinyint(1) NOT NULL,
  `erstellt` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nachrichten`
--

CREATE TABLE `nachrichten` (
  `ID` int NOT NULL,
  `Zeit` int NOT NULL,
  `Absender_ID` varchar(58) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Absender_Name` varchar(20) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_ID` varchar(58) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_Name` varchar(20) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Gelesen` int NOT NULL DEFAULT '0',
  `Betreff` varchar(80) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Text` text CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Logbuch` tinyint(1) NOT NULL,
  `Chatbot` tinyint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `planet`
--

CREATE TABLE `planet` (
  `ID` int NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `Spieler_Name` varchar(20) NOT NULL,
  `Planet_Name` varchar(50) NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `z` int NOT NULL,
  `Planet_ID` int NOT NULL,
  `Ressource_Eisen` decimal(20,2) NOT NULL,
  `Ressource_Silizium` decimal(20,2) NOT NULL,
  `Ressource_Wasser` decimal(20,2) NOT NULL,
  `Ressource_Bot` decimal(20,6) NOT NULL,
  `Stationiert_Bot` decimal(20,6) NOT NULL,
  `Stufe_Gebaeude_1` int NOT NULL,
  `Stufe_Gebaeude_2` int NOT NULL,
  `Stufe_Gebaeude_3` int NOT NULL,
  `Stufe_Gebaeude_4` int NOT NULL,
  `Stufe_Gebaeude_5` int NOT NULL,
  `Stufe_Gebaeude_6` int NOT NULL,
  `Stufe_Gebaeude_7` int NOT NULL,
  `Stufe_Gebaeude_8` int NOT NULL,
  `Stufe_Gebaeude_9` int NOT NULL,
  `Stufe_Gebaeude_10` int NOT NULL,
  `Stufe_Gebaeude_11` int NOT NULL,
  `Grund_Prod_Eisen` int NOT NULL DEFAULT '20',
  `Grund_Prod_Silizium` int NOT NULL DEFAULT '10',
  `Grund_Prod_Wasser` int NOT NULL DEFAULT '5',
  `Prod_Eisen` int NOT NULL,
  `Prod_Silizium` int NOT NULL,
  `Prod_Wasser` int NOT NULL,
  `Produktion_Zeit` int NOT NULL,
  `Ressource_Energie` int NOT NULL,
  `Ressource_Karma` int NOT NULL,
  `Bauschleife_Gebaeude_ID` int NOT NULL,
  `Bauschleife_Gebaeude_Start` int NOT NULL,
  `Bauschleife_Gebaeude_Bis` int NOT NULL,
  `Bauschleife_Gebaeude_Name` varchar(22) NOT NULL,
  `Bunker_Kapa` bigint NOT NULL,
  `Bunker_Eisen` bigint NOT NULL,
  `Bunker_Silizium` bigint NOT NULL,
  `Bunker_Wasser` bigint NOT NULL,
  `Bauschleife_Flotte_ID` int NOT NULL,
  `Schiff_Typ_1` int DEFAULT NULL,
  `Schiff_Typ_2` int DEFAULT NULL,
  `Schiff_Typ_3` int DEFAULT NULL,
  `Schiff_Typ_4` int DEFAULT NULL,
  `Schiff_Typ_5` int DEFAULT NULL,
  `Schiff_Typ_6` int DEFAULT NULL,
  `Schiff_Typ_7` int DEFAULT NULL,
  `Schiff_Typ_8` int DEFAULT NULL,
  `Schiff_Typ_9` int DEFAULT NULL,
  `Schiff_Typ_10` int DEFAULT NULL,
  `Schiff_Typ_11` int DEFAULT NULL,
  `Schiff_Typ_12` int DEFAULT NULL,
  `Deff_Typ_1` int NOT NULL,
  `Deff_Typ_2` int NOT NULL,
  `Deff_Typ_3` int NOT NULL,
  `Deff_Typ_4` int NOT NULL,
  `Deff_Typ_5` int NOT NULL,
  `Deff_Typ_6` int NOT NULL,
  `Handel_Kapa` bigint NOT NULL,
  `Handel_Eisen` bigint NOT NULL,
  `Handel_Silizium` bigint NOT NULL,
  `Handel_Wasser` bigint NOT NULL,
  `punkte` decimal(11,5) NOT NULL,
  `Gesamt_Bot` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sonnensystem`
--

CREATE TABLE `sonnensystem` (
  `ID` int NOT NULL,
  `Spieler_ID` varchar(58) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `x` int NOT NULL,
  `y` int NOT NULL,
  `Entdeckt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `locked` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieler`
--

CREATE TABLE `spieler` (
  `ID` int NOT NULL,
  `Spieler_ID` varchar(58) NOT NULL,
  `Spieler_Name` varchar(30) NOT NULL,
  `Typ` int NOT NULL,
  `Bot_Produktion_Zeit` int NOT NULL,
  `Tech_1` int NOT NULL,
  `Tech_2` int NOT NULL,
  `Tech_3` int NOT NULL,
  `Tech_4` int NOT NULL,
  `Tech_5` int NOT NULL,
  `Tech_6` int NOT NULL,
  `Tech_7` int NOT NULL,
  `Tech_8` int NOT NULL,
  `Tech_9` int NOT NULL,
  `Tech_10` int NOT NULL,
  `Tech_11` int NOT NULL,
  `Tech_12` int NOT NULL,
  `Tech_Schleife_ID` int NOT NULL,
  `Tech_Schleife_Eisen` int NOT NULL,
  `Tech_Schleife_Name` varchar(50) NOT NULL,
  `Tech_Schleife_Silizium` int NOT NULL,
  `Tech_Schleife_Wasser` int NOT NULL,
  `Tech_Schleife_Bauzeit_Start` int NOT NULL,
  `Tech_Schleife_Bauzeit_Bis` int NOT NULL,
  `Tech_Schleife_Planet` int NOT NULL,
  `punkte_structur` int NOT NULL,
  `punkte_flotte` int NOT NULL,
  `punkte_forschung` int NOT NULL,
  `Letzter_Planet` int NOT NULL,
  `avatar` varchar(58) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bauschleifeflotte`
--
ALTER TABLE `bauschleifeflotte`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `construction_loops_defense`
--
ALTER TABLE `construction_loops_defense`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT für Tabelle `bauschleifeflotte`
--
ALTER TABLE `bauschleifeflotte`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `chat`
--
ALTER TABLE `chat`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `construction_loops_defense`
--
ALTER TABLE `construction_loops_defense`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `flotten`
--
ALTER TABLE `flotten`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `handelsangebot`
--
ALTER TABLE `handelsangebot`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `login`
--
ALTER TABLE `login`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `nachrichten`
--
ALTER TABLE `nachrichten`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `planet`
--
ALTER TABLE `planet`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `sonnensystem`
--
ALTER TABLE `sonnensystem`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `spieler`
--
ALTER TABLE `spieler`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
