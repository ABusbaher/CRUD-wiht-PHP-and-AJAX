-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2017 at 08:54 PM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `komitent_baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `drzava`
--

CREATE TABLE `drzava` (
  `drz_id` int(11) NOT NULL,
  `drz_sifra` int(11) NOT NULL,
  `drz_naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drzava`
--

INSERT INTO `drzava` (`drz_id`, `drz_sifra`, `drz_naziv`) VALUES
(1, 381, 'Srbija'),
(2, 56, 'Španija');

-- --------------------------------------------------------

--
-- Table structure for table `komitent`
--

CREATE TABLE `komitent` (
  `kom_id` int(11) NOT NULL,
  `mes_id` int(11) NOT NULL,
  `kom_sifra` int(11) NOT NULL,
  `kom_naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kom_opis` text COLLATE utf8_unicode_ci,
  `kom_pib` int(11) DEFAULT '0',
  `kom_mbr` int(11) DEFAULT '0',
  `kom_vrsta` char(1) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `komitent`
--

INSERT INTO `komitent` (`kom_id`, `mes_id`, `kom_sifra`, `kom_naziv`, `kom_opis`, `kom_pib`, `kom_mbr`, `kom_vrsta`) VALUES
(2, 6, 56, 'Komitent2', 'lčlfdlčkdfajk jklasdfklkl časdfčk', 112, 56879, 'k'),
(3, 3, 5645654, 'sdfdfssdf sdf', ' sdffsda', 546523, 5456456, 'k'),
(6, 5, 1111, 'fss fsda', 'sdffsd sdfdfs', 445, 546, 'o'),
(16, 6, 12, '2112', '', 1, 0, 'd'),
(19, 7, 12323, 'afsd assa', 'www', 12, 21, 'd'),
(22, 3, 7575, 'ew', 'sd sdf', 23, 234, 'o'),
(38, 1, 123323, 'asd ', 'sadd', 123121, 123321, 'd'),
(46, 6, 8799, 'asd asd', 'asd as sadas ', 12332, 12312, 'o'),
(47, 7, 789, 'lčl lččl', '', 889, 0, 'k');

-- --------------------------------------------------------

--
-- Table structure for table `mesto`
--

CREATE TABLE `mesto` (
  `mes_id` int(11) NOT NULL,
  `drz_id` int(11) NOT NULL,
  `mes_sifra` int(11) NOT NULL,
  `mes_naziv` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mesto`
--

INSERT INTO `mesto` (`mes_id`, `drz_id`, `mes_sifra`, `mes_naziv`) VALUES
(1, 1, 11, 'Beograd'),
(3, 1, 21, 'Novi Sad'),
(5, 2, 65, 'Barselona'),
(6, 2, 456, 'Madrid'),
(7, 1, 24, 'Subotica');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drzava`
--
ALTER TABLE `drzava`
  ADD PRIMARY KEY (`drz_id`);

--
-- Indexes for table `komitent`
--
ALTER TABLE `komitent`
  ADD PRIMARY KEY (`kom_id`),
  ADD KEY `mesto_idx` (`mes_id`);

--
-- Indexes for table `mesto`
--
ALTER TABLE `mesto`
  ADD PRIMARY KEY (`mes_id`),
  ADD KEY `drz_id_idx` (`drz_id`),
  ADD KEY `drzava_idx` (`drz_id`),
  ADD KEY `_idx` (`drz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drzava`
--
ALTER TABLE `drzava`
  MODIFY `drz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `komitent`
--
ALTER TABLE `komitent`
  MODIFY `kom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `mesto`
--
ALTER TABLE `mesto`
  MODIFY `mes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `komitent`
--
ALTER TABLE `komitent`
  ADD CONSTRAINT `mesto` FOREIGN KEY (`mes_id`) REFERENCES `mesto` (`mes_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `mesto`
--
ALTER TABLE `mesto`
  ADD CONSTRAINT `drzava` FOREIGN KEY (`drz_id`) REFERENCES `drzava` (`drz_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
