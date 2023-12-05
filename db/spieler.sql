-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 05, 2023 at 07:15 PM
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
-- Database: `spieler`
--
CREATE DATABASE IF NOT EXISTS `spieler` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `spieler`;

-- --------------------------------------------------------

--
-- Table structure for table `spieler`
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
  `max_Planeten` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `spieler_ID` (`spieler_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `spieler`
--
ALTER TABLE `spieler`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
