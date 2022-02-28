-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2022 at 05:15 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wsfinalproj`
--
CREATE DATABASE IF NOT EXISTS `wsfinalproj` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `wsfinalproj`;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `clientID` int(11) NOT NULL,
  `clientName` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `licenseNumber` varchar(250) NOT NULL,
  `licenseStartDate` datetime NOT NULL,
  `licenseEndDate` datetime NOT NULL,
  `APIKey` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `countrysearch`
--

DROP TABLE IF EXISTS `countrysearch`;
CREATE TABLE `countrysearch` (
  `searchID` int(11) NOT NULL,
  `clientID` int(11) NOT NULL,
  `searchDate` datetime NOT NULL,
  `searchCompletionDate` datetime NOT NULL,
  `userInput` varchar(100) NOT NULL,
  `searchResult` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `countrysearch`
--
ALTER TABLE `countrysearch`
  ADD PRIMARY KEY (`searchID`),
  ADD KEY `countrySearch_clientID_fk` (`clientID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countrysearch`
--
ALTER TABLE `countrysearch`
  MODIFY `searchID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `countrysearch`
--
ALTER TABLE `countrysearch`
  ADD CONSTRAINT `countrySearch_clientID_fk` FOREIGN KEY (`clientID`) REFERENCES `client` (`clientID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
