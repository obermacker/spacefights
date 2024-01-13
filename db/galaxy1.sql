-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2024 at 02:45 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `galaxy1`
--
CREATE DATABASE IF NOT EXISTS `galaxy1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `galaxy1`;

-- --------------------------------------------------------

--
-- Table structure for table `bauschleifedeff`
--

CREATE TABLE `bauschleifedeff` (
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
-- Table structure for table `bauschleifeflotte`
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
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `ID` int NOT NULL,
  `PlayerId` varchar(58) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MessageFromPlayerName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MessageText` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `MessageTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flotten`
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
  `Startplanet_Name` varchar(20) NOT NULL,
  `Zielplanet_Name` varchar(20) NOT NULL,
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
  `Schiff_Typ_1` int NOT NULL,
  `Schiff_Typ_2` int NOT NULL,
  `Schiff_Typ_3` int NOT NULL,
  `Schiff_Typ_4` int NOT NULL,
  `Schiff_Typ_5` int NOT NULL,
  `Schiff_Typ_6` int NOT NULL,
  `Schiff_Typ_7` int NOT NULL,
  `Schiff_Typ_8` int NOT NULL,
  `Schiff_Typ_9` int NOT NULL,
  `Schiff_Typ_10` int NOT NULL,
  `Schiff_Typ_11` int NOT NULL,
  `Schiff_Typ_12` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `handelsangebot`
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
-- Table structure for table `login`
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
-- Table structure for table `message`
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
-- Table structure for table `nachrichten`
--

CREATE TABLE `nachrichten` (
  `ID` int NOT NULL,
  `Zeit` int NOT NULL,
  `Absender_ID` varchar(58) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Absender_Name` varchar(20) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_ID` varchar(58) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Empfaenger_Name` varchar(20) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Gelesen` int NOT NULL,
  `Betreff` varchar(80) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Text` text CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL,
  `Logbuch` int NOT NULL,
  `Chatbot` tinyint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `planet`
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
  `Ressource_Eisen` decimal(20,2) DEFAULT '0.00',
  `Ressource_Silizium` decimal(20,2) DEFAULT '0.00',
  `Ressource_Wasser` decimal(20,2) NOT NULL DEFAULT '0.00',
  `Ressource_Bot` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `Stationiert_Bot` decimal(20,6) NOT NULL DEFAULT '0.000000',
  `Stufe_Gebaeude_1` int DEFAULT '0',
  `Stufe_Gebaeude_2` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_3` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_4` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_5` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_6` int DEFAULT '0',
  `Stufe_Gebaeude_7` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_8` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_9` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_10` int NOT NULL DEFAULT '0',
  `Stufe_Gebaeude_11` int NOT NULL DEFAULT '0',
  `Grund_Prod_Eisen` int NOT NULL DEFAULT '20',
  `Grund_Prod_Silizium` int NOT NULL DEFAULT '10',
  `Grund_Prod_Wasser` int NOT NULL DEFAULT '5',
  `Prod_Eisen` int NOT NULL DEFAULT '0',
  `Prod_Silizium` int NOT NULL DEFAULT '0',
  `Prod_Wasser` int NOT NULL DEFAULT '0',
  `Produktion_Zeit` int NOT NULL DEFAULT '0',
  `Ressource_Energie` int NOT NULL DEFAULT '0',
  `Ressource_Karma` int NOT NULL DEFAULT '0',
  `Bauschleife_Gebaeude_ID` int NOT NULL DEFAULT '0',
  `Bauschleife_Gebaeude_Start` int NOT NULL DEFAULT '0',
  `Bauschleife_Gebaeude_Bis` int NOT NULL DEFAULT '0',
  `Bauschleife_Gebaeude_Name` varchar(22) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `Bunker_Kapa` bigint NOT NULL DEFAULT '0',
  `Bunker_Eisen` bigint NOT NULL DEFAULT '0',
  `Bunker_Silizium` bigint NOT NULL DEFAULT '0',
  `Bunker_Wasser` bigint NOT NULL DEFAULT '0',
  `Bauschleife_Flotte_ID` int NOT NULL DEFAULT '0',
  `Schiff_Typ_1` int NOT NULL DEFAULT '0',
  `Schiff_Typ_2` int NOT NULL DEFAULT '0',
  `Schiff_Typ_3` int NOT NULL DEFAULT '0',
  `Schiff_Typ_4` int NOT NULL DEFAULT '0',
  `Schiff_Typ_5` int NOT NULL DEFAULT '0',
  `Schiff_Typ_6` int NOT NULL DEFAULT '0',
  `Schiff_Typ_7` int NOT NULL DEFAULT '0',
  `Schiff_Typ_8` int NOT NULL DEFAULT '0',
  `Schiff_Typ_9` int NOT NULL DEFAULT '0',
  `Schiff_Typ_10` int NOT NULL DEFAULT '0',
  `Schiff_Typ_11` int NOT NULL DEFAULT '0',
  `Schiff_Typ_12` int NOT NULL DEFAULT '0',
  `Deff_Typ_1` int NOT NULL DEFAULT '0',
  `Deff_Typ_2` int NOT NULL DEFAULT '0',
  `Deff_Typ_3` int NOT NULL DEFAULT '0',
  `Deff_Typ_4` int NOT NULL DEFAULT '0',
  `Deff_Typ_5` int NOT NULL DEFAULT '0',
  `Deff_Typ_6` int NOT NULL DEFAULT '0',
  `Handel_Kapa` bigint NOT NULL DEFAULT '0',
  `Handel_Eisen` bigint NOT NULL DEFAULT '0',
  `Handel_Silizium` bigint NOT NULL DEFAULT '0',
  `Handel_Wasser` bigint NOT NULL DEFAULT '0',
  `punkte` decimal(11,5) NOT NULL DEFAULT '0.00000',
  `Gesamt_Bot` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sonnensystem`
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
-- Table structure for table `spieler`
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
-- Indexes for dumped tables
--

--
-- Indexes for table `bauschleifedeff`
--
ALTER TABLE `bauschleifedeff`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `bauschleifeflotte`
--
ALTER TABLE `bauschleifeflotte`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `flotten`
--
ALTER TABLE `flotten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `handelsangebot`
--
ALTER TABLE `handelsangebot`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `nachrichten`
--
ALTER TABLE `nachrichten`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sonnensystem`
--
ALTER TABLE `sonnensystem`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bauschleifedeff`
--
ALTER TABLE `bauschleifedeff`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bauschleifeflotte`
--
ALTER TABLE `bauschleifeflotte`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flotten`
--
ALTER TABLE `flotten`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `handelsangebot`
--
ALTER TABLE `handelsangebot`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nachrichten`
--
ALTER TABLE `nachrichten`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `planet`
--
ALTER TABLE `planet`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sonnensystem`
--
ALTER TABLE `sonnensystem`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spieler`
--
ALTER TABLE `spieler`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
