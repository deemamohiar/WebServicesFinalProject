-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2022 at 09:01 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

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

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `clientName`, `email`, `passwordHash`, `licenseNumber`, `licenseStartDate`, `licenseEndDate`, `APIKey`) VALUES
(10, 'Deema Mohiar', 'deema2002@live.ca', '$2y$10$7ersSpEmdctJg1CrkPt1cupTWWXhYKA7P8juuqpusvIzF.uqjOeF.', '6272cb76f07aa', '2022-05-04 14:52:38', '2023-05-04 14:52:38', 'countrySearchKey'),
(11, 'Lisa Hanna', 'lisa@hotmail.com', '$2y$10$KUxh/qyb2/e2vr3/681eO.HFmAYf/AC/eghkufzCH3bt1o1nlr3ke', '6272cb875bee6', '2022-05-04 14:52:55', '2023-05-04 14:52:55', 'countrySearchKey');

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
  `userInput` varchar(100) DEFAULT NULL,
  `searchResult` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `countrysearch`
--

INSERT INTO `countrysearch` (`searchID`, `clientID`, `searchDate`, `searchCompletionDate`, `userInput`, `searchResult`) VALUES
(71, 10, '2022-05-04 20:57:11', '2022-05-04 20:57:11', '', '[{\"name\":{\"common\":\"Uruguay\",\"official\":\"Oriental Republic of Uruguay\",\"nativeName\":{\"spa\":{\"official\":\"República Oriental del Uruguay\",\"common\":\"Uruguay\"}}},\"tld\":[\".uy\"],\"cca2\":\"UY\",\"ccn3\":\"858\",\"cca3\":\"URY\",\"cioc\":\"URU\",\"independent\":true,\"status\":\"officially-assigned\",\"unMember\":true,\"currencies\":{\"UYU\":{\"name\":\"Uruguayan peso\",\"symbol\":\"$\"}},\"idd\":{\"root\":\"+5\",\"suffixes\":[\"98\"]},\"capital\":[\"Montevideo\"],\"altSpellings\":[\"UY\",\"Oriental Republic of Uruguay\",\"República Oriental del Uruguay\"],\"region\":\"Americas\",\"subregion\":\"South America\",\"languages\":{\"spa\":\"Spanish\"},\"translations\":{\"ara\":{\"official\":\"جمهورية الأوروغواي الشرقية\",\"common\":\"الأوروغواي\"},\"ces\":{\"official\":\"Uruguayská východní republika\",\"common\":\"Uruguay\"},\"cym\":{\"official\":\"Oriental Republic of Uruguay\",\"common\":\"Uruguay\"},\"deu\":{\"official\":\"Republik Östlich des Uruguay\",\"common\":\"Uruguay\"},\"est\":{\"official\":\"Uruguay Idavabariik\",\"common\":\"Uruguay\"},\"fin\":{\"official\":\"Uruguayn itäinen tasavalta\",\"common\":\"Uruguay\"},\"fra\":{\"official\":\"République orientale de l\'Uruguay\",\"common\":\"Uruguay\"},\"hrv\":{\"official\":\"Orijentalna Republika Urugvaj\",\"common\":\"Urugvaj\"},\"hun\":{\"official\":\"Uruguayi Keleti Köztársaság\",\"common\":\"Uruguay\"},\"ita\":{\"official\":\"Repubblica Orientale dell\'Uruguay\",\"common\":\"Uruguay\"},\"jpn\":{\"official\":\"ウルグアイ東方共和国\",\"common\":\"ウルグアイ\"},\"kor\":{\"official\":\"우루과이 동방 공화국\",\"common\":\"우루과이\"},\"nld\":{\"official\":\"Oosterse Republiek Uruguay\",\"common\":\"Uruguay\"},\"per\":{\"official\":\"جمهوری اروگوئه\",\"common\":\"اروگوئه\"},\"pol\":{\"official\":\"Wschodnia Republika Urugwaju\",\"common\":\"Urugwaj\"},\"por\":{\"official\":\"República Oriental do Uruguai\",\"common\":\"Uruguai\"},\"rus\":{\"official\":\"Восточной Республики Уругвай\",\"common\":\"Уругвай\"},\"slk\":{\"official\":\"Uruguajská východná republika\",\"common\":\"Uruguaj\"},\"spa\":{\"official\":\"República Oriental del Uruguay\",\"common\":\"Uruguay\"},\"swe\":{\"official\":\"Republiken Uruguay\",\"common\":\"Uruguay\"},\"urd\":{\"official\":\"جمہوریہ شرقیہ یوراگوئے\",\"common\":\"یوراگوئے\"},\"zho\":{\"official\":\"乌拉圭东岸共和国\",\"common\":\"乌拉圭\"}},\"latlng\":[-33.0,-56.0],\"landlocked\":false,\"borders\":[\"ARG\",\"BRA\"],\"area\":181034.0,\"demonyms\":{\"eng\":{\"f\":\"Uruguayan\",\"m\":\"Uruguayan\"},\"fra\":{\"f\":\"Uruguayenne\",\"m\":\"Uruguayen\"}},\"flag\":\"\\uD83C\\uDDFA\\uD83C\\uDDFE\",\"maps\":{\"googleMaps\":\"https://goo.gl/maps/tiQ9Baekb1jQtDSD9\",\"openStreetMaps\":\"https://www.openstreetmap.org/relation/287072\"},\"population\":3473727,\"gini\":{\"2019\":39.7},\"fifa\":\"URU\",\"car\":{\"signs\":[\"ROU\"],\"side\":\"right\"},\"timezones\":[\"UTC-03:00\"],\"continents\":[\"South America\"],\"flags\":{\"png\":\"https://flagcdn.com/w320/uy.png\",\"svg\":\"https://flagcdn.com/uy.svg\"},\"coatOfArms\":{\"png\":\"https://mainfacts.com/media/images/coats_of_arms/uy.png\",\"svg\":\"https://mainfacts.com/media/images/coats_of_arms/uy.svg\"},\"startOfWeek\":\"monday\",\"capitalInfo\":{\"latlng\":[-34.85,-56.17]},\"postalCode\":{\"format\":\"#####\",\"regex\":\"^(\\\\d{5})$\"}},{\"name\":{\"common\":\"Paraguay\",\"official\":\"Republic of Paraguay\",\"nativeName\":{\"grn\":{\"official\":\"Tetã Paraguái\",\"common\":\"Paraguái\"},\"spa\":{\"official\":\"República de Paraguay\",\"common\":\"Paraguay\"}}},\"tld\":[\".py\"],\"cca2\":\"PY\",\"ccn3\":\"600\",\"cca3\":\"PRY\",\"cioc\":\"PAR\",\"independent\":true,\"status\":\"officially-assigned\",\"unMember\":true,\"currencies\":{\"PYG\":{\"name\":\"Paraguayan guaraní\",\"symbol\":\"₲\"}},\"idd\":{\"root\":\"+5\",\"suffixes\":[\"95\"]},\"capital\":[\"Asunción\"],\"altSpellings\":[\"PY\",\"Republic of Paraguay\",\"República del Paraguay\",\"Tetã Paraguái\"],\"region\":\"Americas\",\"subregion\":\"South America\",\"languages\":{\"grn\":\"Guaraní\",\"spa\":\"Spanish\"},\"translations\":{\"ara\":{\"official\":\"جمهورية باراغواي\",\"common\":\"باراغواي\"},\"ces\":{\"official\":\"Paraguayská republika\",\"common\":\"Paraguay\"},\"cym\":{\"official\":\"Republic of Paraguay\",\"common\":\"Paraguay\"},\"deu\":{\"official\":\"Republik Paraguay\",\"common\":\"Paraguay\"},\"est\":{\"official\":\"Paraguay Vabariik\",\"common\":\"Paraguay\"},\"fin\":{\"official\":\"Paraguayn tasavalta\",\"common\":\"Paraguay\"},\"fra\":{\"official\":\"République du Paraguay\",\"common\":\"Paraguay\"},\"hrv\":{\"official\":\"Republika Paragvaj\",\"common\":\"Paragvaj\"},\"hun\":{\"official\":\"Paraguayi Köztársaság\",\"common\":\"Paraguay\"},\"ita\":{\"official\":\"Repubblica del Paraguay\",\"common\":\"Paraguay\"},\"jpn\":{\"official\":\"パラグアイ共和国\",\"common\":\"パラグアイ\"},\"kor\":{\"official\":\"파라과이 공화국\",\"common\":\"파라과이\"},\"nld\":{\"official\":\"Republiek Paraguay\",\"common\":\"Paraguay\"},\"per\":{\"official\":\"جمهوری پاراگوئه\",\"common\":\"پاراگوئه\"},\"pol\":{\"official\":\"Republika Paragwaju\",\"common\":\"Paragwaj\"},\"por\":{\"official\":\"República do Paraguai\",\"common\":\"Paraguai\"},\"rus\":{\"official\":\"Республика Парагвай\",\"common\":\"Парагвай\"},\"slk\":{\"official\":\"Paraguajská republika\",\"common\":\"Paraguaj\"},\"spa\":{\"official\":\"República de Paraguay\",\"common\":\"Paraguay\"},\"swe\":{\"official\":\"Republiken Paraguay\",\"common\":\"Paraguay\"},\"urd\":{\"official\":\"جمہوریہ پیراگوئے\",\"common\":\"پیراگوئے\"},\"zho\":{\"official\":\"巴拉圭共和国\",\"common\":\"巴拉圭\"}},\"latlng\":[-23.0,-58.0],\"landlocked\":true,\"borders\":[\"ARG\",\"BOL\",\"BRA\"],\"area\":406752.0,\"demonyms\":{\"eng\":{\"f\":\"Paraguayan\",\"m\":\"Paraguayan\"},\"fra\":{\"f\":\"Paraguayenne\",\"m\":\"Paraguayen\"}},\"flag\":\"\\uD');

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
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `countrysearch`
--
ALTER TABLE `countrysearch`
  MODIFY `searchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

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
