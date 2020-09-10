-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2020 at 07:30 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekat1`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID_KORISNIKA` int(11) NOT NULL,
  `ID_RADNOG_MJESTA` int(11) NOT NULL,
  `ID_ROLE` int(11) NOT NULL,
  `KORISNICKA_LOZINKA` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `IME` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PREZIME` varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `EMAIL` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `DATUM_ZASNIVANJA_RADNOG_ODNOSA` date NOT NULL,
  `GODINE_RADNOG_STAZA` decimal(2,0) NOT NULL,
  `ID_ORGANIZACIONE_JEDINICE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID_KORISNIKA`, `ID_RADNOG_MJESTA`, `ID_ROLE`, `KORISNICKA_LOZINKA`, `IME`, `PREZIME`, `EMAIL`, `DATUM_ZASNIVANJA_RADNOG_ODNOSA`, `GODINE_RADNOG_STAZA`, `ID_ORGANIZACIONE_JEDINICE`) VALUES
(20, 102, 2, '$2y$10$bmQLsJEIs.stcj4bYANS..JNdFER8FveqYeLBdaLHBjiRW2zMegGK', 'Natasa', 'Jugovic', 'natasa.jugovic@walter.ba', '2018-09-27', '16', 1),
(30, 3, 2, '$2y$10$8MSnoAXPc2Gb4QnrqOAgveoh/WsZcRZtHksJ4gFsTZXHiduBJuUja', 'Dragana', 'Cajic', 'dragana.cajic@walter.ba', '2018-08-15', '16', 1),
(36, 102, 3, '$2y$10$oWBn4erqnQYhLRGZWmyalOmZi/fVi1i/W27jRKXdRVjcrRVKjGuRW', 'Pavle', 'Poljčić', 'pavlepoljcic@gmail.com', '2018-09-28', '13', 0),
(141, 102, 1, '$2y$10$zxkS5eM4kTpfWTUvzUSbieGUjl3RfnUq4ljydGr0wed47KFVEqDHi', 'pavle ', 'poljcic', 'pavle_poljcic@yahoo.com', '2020-08-17', '6', 1),
(146, 104, 2, '$2y$10$lQl3.jNcdcckr4AQ0LbZK.qIZXAk239voEuCnaMDuhRggqkxsTBMm', 'sonja', 'poljcic', 'sonjapoljcic@gmail.com', '2020-08-19', '5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizaciona_jedinica`
--

CREATE TABLE `organizaciona_jedinica` (
  `ID_ORGANIZACIONE_JEDINICE` int(11) NOT NULL,
  `NAZIV_ORGANIZACIONE_JEDINICE` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizaciona_jedinica`
--

INSERT INTO `organizaciona_jedinica` (`ID_ORGANIZACIONE_JEDINICE`, `NAZIV_ORGANIZACIONE_JEDINICE`) VALUES
(1, 'ETF'),
(3, 'Ekonomija'),
(5, 'Pravo');

-- --------------------------------------------------------

--
-- Table structure for table `radno_mjesto`
--

CREATE TABLE `radno_mjesto` (
  `ID_RADNOG_MJESTA` int(11) NOT NULL,
  `NAZIV_RADNOG_MJESTA` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `radno_mjesto`
--

INSERT INTO `radno_mjesto` (`ID_RADNOG_MJESTA`, `NAZIV_RADNOG_MJESTA`) VALUES
(102, 'Inženjer softveraa'),
(103, 'Menadžer'),
(104, 'Dizajner zvuka'),
(105, 'Developer'),
(107, 'radnik1'),
(108, 'radnik2'),
(109, 'radnik3'),
(111, 'radnik5');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `ID_ROLE` int(11) NOT NULL,
  `TIP_ROLE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`ID_ROLE`, `TIP_ROLE`) VALUES
(1, 'Admin'),
(2, 'Radnik'),
(3, 'Glavni_admin');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `STATUS_ID` int(11) NOT NULL,
  `OPIS` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`STATUS_ID`, `OPIS`) VALUES
(1, 'Podnesen'),
(2, 'Odbijen'),
(3, 'Iskorišćen'),
(4, 'Odobren');

-- --------------------------------------------------------

--
-- Table structure for table `zahtjev`
--

CREATE TABLE `zahtjev` (
  `ID_ZAHTJEVA` int(11) NOT NULL,
  `ID_KORISNIKA` int(11) NOT NULL,
  `ID_ADMINA` int(11) DEFAULT NULL,
  `STATUS_ID` int(11) NOT NULL,
  `DATUM_POCETKA_GODISNJEG` date NOT NULL,
  `DATUM_POVRATKA` date NOT NULL,
  `KOMENTAR` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `GODINA` decimal(4,0) NOT NULL,
  `BROJ_DANA` decimal(2,0) NOT NULL,
  `BONUS_DANI` decimal(2,0) NOT NULL,
  `PRVI_DIO_ODMORA` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zahtjev`
--

INSERT INTO `zahtjev` (`ID_ZAHTJEVA`, `ID_KORISNIKA`, `ID_ADMINA`, `STATUS_ID`, `DATUM_POCETKA_GODISNJEG`, `DATUM_POVRATKA`, `KOMENTAR`, `GODINA`, `BROJ_DANA`, `BONUS_DANI`, `PRVI_DIO_ODMORA`) VALUES
(360, 141, 141, 4, '2020-08-17', '2020-08-19', '', '2020', '15', '1', 0),
(370, 36, 36, 4, '2020-08-21', '2020-08-31', '', '2020', '13', '3', 1),
(383, 36, 36, 4, '2020-08-21', '2020-08-26', '', '2020', '9', '3', 0),
(385, 36, 36, 4, '2020-08-21', '2020-08-24', '', '2020', '7', '3', 0),
(386, 20, 20, 4, '2020-09-07', '2020-09-16', '', '2020', '16', '4', 0),
(387, 141, 141, 4, '2020-09-07', '2020-09-21', '', '2020', '10', '1', 1),
(388, 141, 141, 4, '2020-09-07', '2020-09-09', '', '2020', '7', '1', 0),
(389, 146, 146, 4, '2020-09-07', '2020-09-10', '', '2020', '17', '1', 0),
(390, 141, 141, 4, '2020-09-08', '2020-09-09', '', '2020', '5', '1', 0),
(392, 146, 146, 2, '2020-09-08', '2020-09-09', '', '2020', '17', '1', 0),
(393, 146, 146, 4, '2020-09-09', '2020-09-10', '', '2020', '15', '1', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID_KORISNIKA`),
  ADD KEY `FK_EVIDENCIJA` (`ID_ROLE`),
  ADD KEY `FK_RADI` (`ID_RADNOG_MJESTA`),
  ADD KEY `FK_ORGANIZACIJA` (`ID_ORGANIZACIONE_JEDINICE`) USING BTREE;

--
-- Indexes for table `organizaciona_jedinica`
--
ALTER TABLE `organizaciona_jedinica`
  ADD PRIMARY KEY (`ID_ORGANIZACIONE_JEDINICE`),
  ADD KEY `ID_organizacione_jedinice` (`ID_ORGANIZACIONE_JEDINICE`);

--
-- Indexes for table `radno_mjesto`
--
ALTER TABLE `radno_mjesto`
  ADD PRIMARY KEY (`ID_RADNOG_MJESTA`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`ID_ROLE`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`STATUS_ID`);

--
-- Indexes for table `zahtjev`
--
ALTER TABLE `zahtjev`
  ADD PRIMARY KEY (`ID_ZAHTJEVA`),
  ADD KEY `FK_KREIRANJE_ZAHTJEVA` (`ID_KORISNIKA`),
  ADD KEY `FK_AZURIRANJE_ZAHTJEVA` (`ID_ADMINA`),
  ADD KEY `FK_STANJE` (`STATUS_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID_KORISNIKA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `organizaciona_jedinica`
--
ALTER TABLE `organizaciona_jedinica`
  MODIFY `ID_ORGANIZACIONE_JEDINICE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `radno_mjesto`
--
ALTER TABLE `radno_mjesto`
  MODIFY `ID_RADNOG_MJESTA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `ID_ROLE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `STATUS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zahtjev`
--
ALTER TABLE `zahtjev`
  MODIFY `ID_ZAHTJEVA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
