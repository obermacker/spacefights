-- phpMyAdmin SQL Dump
-- version 4.9.7deb1
-- https://www.phpmyadmin.net/
--
-- Host: wp334.webpack.hosteurope.de
-- Erstellungszeit: 28. Jan 2024 um 23:10
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
-- Datenbank: `db12333748-spieler`
--
CREATE DATABASE IF NOT EXISTS `db12333748-spieler` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db12333748-spieler`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieler`
--

CREATE TABLE `spieler` (
  `ID` int NOT NULL,
  `spieler_ID` varchar(58) NOT NULL,
  `spieler_name` varchar(30) NOT NULL,
  `name_galaxy_1` varchar(30) NOT NULL,
  `name_galaxy_2` varchar(30) NOT NULL,
  `name_galaxy_3` varchar(30) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `letzter_login` int NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `HTTP_USER_AGENT` varchar(255) NOT NULL,
  `spieler_geloescht` int NOT NULL,
  `name_gala_1` varchar(30) NOT NULL,
  `aktiv_gala_1` int NOT NULL,
  `letzter_Planet` int NOT NULL,
  `max_Planeten` int NOT NULL,
  `chat_color` varchar(6) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'FFFFFF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `spieler_ID` (`spieler_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `spieler`
--
ALTER TABLE `spieler`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
