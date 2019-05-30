-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2019 at 03:44 PM
-- Server version: 10.1.39-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `debieb`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `aantal geleende boeken per lid`
-- (See below for the actual view)
--
CREATE TABLE `aantal geleende boeken per lid` (
`Voornaam` varchar(255)
,`achternaam` varchar(255)
,`geleende boeken` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `auteur`
--

CREATE TABLE `auteur` (
  `Auteur_nr` int(9) NOT NULL,
  `Voorletter` char(1) DEFAULT NULL,
  `Voornaam` varchar(255) DEFAULT NULL,
  `Voorvoegsel` varchar(255) DEFAULT NULL,
  `Achternaam` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auteur`
--

INSERT INTO `auteur` (`Auteur_nr`, `Voorletter`, `Voornaam`, `Voorvoegsel`, `Achternaam`) VALUES
(1, 'G', 'Guy', 'De', 'Tré'),
(2, 'm', 'Mitchell', NULL, 'Waite'),
(3, 'H', 'Hella', NULL, 'Haasse'),
(4, 'L', 'Leon', 'De', 'Winter'),
(5, 'A', 'Antoinette', NULL, 'Hertsensberg'),
(6, 'J', 'Jessica', NULL, 'Nadelin'),
(7, 'A', 'Alexanders', NULL, 'Gershberg'),
(8, 'K', 'Karin', NULL, 'Luiten'),
(9, 'J', 'Jacinta', NULL, 'Bokma'),
(10, 'S', 'Stella', NULL, 'Murphy'),
(11, 'L', 'Laurence', NULL, 'Guarneri'),
(12, 'E', 'Eric', NULL, 'Quon'),
(13, 'J', 'Jamie', NULL, 'Oliver');

-- --------------------------------------------------------

--
-- Stand-in structure for view `auteurs en titels`
-- (See below for the actual view)
--
CREATE TABLE `auteurs en titels` (
`voorletter` char(1)
,`voornaam` varchar(255)
,`voorvoegsel` varchar(255)
,`achternaam` varchar(255)
,`Titel` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `auteurs van boeken met isbn <4000 of >7000`
-- (See below for the actual view)
--
CREATE TABLE `auteurs van boeken met isbn <4000 of >7000` (
`voornaam` varchar(255)
,`achternaam` varchar(255)
,`ISBN` bigint(13)
);

-- --------------------------------------------------------

--
-- Table structure for table `bibliotheek`
--

CREATE TABLE `bibliotheek` (
  `Bibliotheek_nr` int(9) NOT NULL,
  `Naam` varchar(255) DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL,
  `Straatnaam` varchar(255) DEFAULT NULL,
  `Huisnummer` int(5) DEFAULT NULL,
  `Huisnummertoevoeging` varchar(3) DEFAULT NULL,
  `Plaats` varchar(255) DEFAULT NULL,
  `Telefoonnummer` varchar(10) DEFAULT NULL,
  `Emailadres` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bibliotheek`
--

INSERT INTO `bibliotheek` (`Bibliotheek_nr`, `Naam`, `Postcode`, `Straatnaam`, `Huisnummer`, `Huisnummertoevoeging`, `Plaats`, `Telefoonnummer`, `Emailadres`) VALUES
(1, 'Breda Centrum', '4812AA', 'Bibliotheekstraat', 1, NULL, 'Breda', '0761235319', 'bredacentrum@debieb.nl'),
(2, 'Breda Noord', '4813AA', 'Biebstraat', 1, NULL, 'Breda', '0761235320', 'bredanoord@debieb.nl'),
(3, 'Breda zuid', '4814AA', 'Bibliotheeklaan', 1, NULL, 'Breda', '0761235321', 'bredazuid@debieb.nl');

-- --------------------------------------------------------

--
-- Table structure for table `boek`
--

CREATE TABLE `boek` (
  `ISBN` bigint(13) NOT NULL,
  `Titel` varchar(255) NOT NULL,
  `Druk` int(2) NOT NULL,
  `Seriedeelnr` int(3) DEFAULT NULL,
  `Auteur_nr` int(9) NOT NULL,
  `Serie_nr` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boek`
--

INSERT INTO `boek` (`ISBN`, `Titel`, `Druk`, `Seriedeelnr`, `Auteur_nr`, `Serie_nr`) VALUES
(9780672226304, 'Waite Groups MS-DOS Developers Guide', 2, NULL, 2, NULL),
(9789001558536, 'God\'s Gym', 1, NULL, 4, NULL),
(9789021540689, 'Jamie\'s Dinners', 2, 3, 13, 1),
(9789021588490, 'The Naked Chef', 16, 1, 13, 1),
(9789021599205, 'Happy days met the naked chef', 1, 2, 13, 1),
(9789043035804, 'Principes van databases', 2, NULL, 1, NULL),
(9789044718959, 'Heerlijke recepten voor de blender', 1, NULL, 11, NULL),
(9789045200507, 'De Snelle Vegetariër', 1, NULL, 9, NULL),
(9789045204390, 'De Dunne Vegan', 1, NULL, 5, NULL),
(9789045215617, 'Vegan for Friends', 1, NULL, 7, NULL),
(9789046819494, 'Het grote zonder pakjes en zakjes kookboek', 1, NULL, 8, NULL),
(9789048311828, 'Vegan 24/7', 1, NULL, 6, NULL),
(9789059205024, 'De Smoothie Bar', 4, NULL, 10, NULL),
(9789461431110, 'De Slowjuice Bar', 3, NULL, 12, NULL),
(9789462371392, 'Sleuteloog', 1, NULL, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boek_onderwerp`
--

CREATE TABLE `boek_onderwerp` (
  `ISBN` bigint(13) NOT NULL,
  `NUR_CODE` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `boek_onderwerp`
--

INSERT INTO `boek_onderwerp` (`ISBN`, `NUR_CODE`) VALUES
(9780672226304, 120),
(9789001558536, 301),
(9789021540689, 440),
(9789021588490, 440),
(9789021599205, 440),
(9789043035804, 123),
(9789043035804, 995),
(9789044718959, 440),
(9789045200507, 444),
(9789045204390, 422),
(9789045204390, 444),
(9789045215617, 444),
(9789046819494, 441),
(9789048311828, 444),
(9789059205024, 440),
(9789461431110, 440),
(9789462371392, 301);

-- --------------------------------------------------------

--
-- Stand-in structure for view `eigen statement 1, boeken per bibliotheek & uitgever`
-- (See below for the actual view)
--
CREATE TABLE `eigen statement 1, boeken per bibliotheek & uitgever` (
`Aantal Boeken` bigint(21)
,`Gemiddelde Aanschafprijs` decimal(11,2)
,`Bibliotheek` varchar(255)
,`Uitgeverij` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `eigen statement 2, boeken te laat door wie + boetebedrag`
-- (See below for the actual view)
--
CREATE TABLE `eigen statement 2, boeken te laat door wie + boetebedrag` (
`Voornaam` varchar(255)
,`Achternaam` varchar(255)
,`titel` varchar(255)
,`Dagen te laat` int(7)
,`Boetetotaal` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `exemplaar`
--

CREATE TABLE `exemplaar` (
  `Boek_nr` int(9) NOT NULL,
  `Aanschafdatum` date NOT NULL,
  `Aanschafprijs` decimal(10,2) NOT NULL,
  `Boetetarief` decimal(4,2) NOT NULL,
  `Uitleengrondslag` int(2) NOT NULL DEFAULT '14',
  `ISBN` bigint(13) NOT NULL,
  `Bibliotheek_nr` int(9) NOT NULL,
  `Uitgeverij_nr` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exemplaar`
--

INSERT INTO `exemplaar` (`Boek_nr`, `Aanschafdatum`, `Aanschafprijs`, `Boetetarief`, `Uitleengrondslag`, `ISBN`, `Bibliotheek_nr`, `Uitgeverij_nr`) VALUES
(1, '2019-01-04', '82.24', '8.78', 14, 9789043035804, 2, 3),
(2, '2019-03-07', '28.11', '9.48', 14, 9789043035804, 3, 3),
(3, '2018-03-04', '17.19', '2.58', 14, 9789043035804, 2, 3),
(4, '2018-11-13', '34.81', '2.20', 14, 9789043035804, 1, 3),
(5, '2015-12-13', '93.41', '2.32', 14, 9789043035804, 2, 3),
(6, '2019-05-12', '35.25', '8.13', 14, 9780672226304, 2, 3),
(7, '2019-02-09', '84.53', '5.59', 14, 9780672226304, 2, 3),
(8, '2018-07-07', '29.67', '8.37', 14, 9780672226304, 2, 3),
(9, '2018-12-31', '99.11', '6.89', 14, 9780672226304, 3, 3),
(10, '2015-01-23', '19.76', '5.39', 14, 9780672226304, 2, 3),
(11, '2019-01-04', '47.49', '3.79', 14, 9789462371392, 2, 2),
(12, '2019-03-07', '13.79', '4.77', 14, 9789462371392, 1, 2),
(13, '2018-03-04', '49.22', '6.58', 14, 9789462371392, 1, 2),
(14, '2018-11-13', '5.49', '7.96', 14, 9789462371392, 2, 2),
(15, '2015-12-13', '82.36', '4.27', 14, 9789462371392, 1, 2),
(16, '2019-05-12', '16.89', '5.94', 14, 9789001558536, 2, 2),
(17, '2019-02-09', '19.95', '7.34', 14, 9789001558536, 1, 2),
(18, '2018-07-07', '75.98', '9.63', 14, 9789001558536, 1, 2),
(19, '2018-12-31', '71.78', '6.32', 14, 9789001558536, 1, 2),
(20, '2015-01-23', '18.43', '5.62', 14, 9789001558536, 1, 2),
(21, '2019-01-04', '72.94', '4.29', 14, 9789045204390, 1, 1),
(22, '2019-03-07', '56.38', '3.33', 14, 9789045204390, 3, 1),
(23, '2018-03-04', '67.24', '1.20', 14, 9789045204390, 3, 1),
(24, '2018-11-13', '73.67', '4.89', 14, 9789045204390, 3, 1),
(25, '2015-12-13', '83.50', '4.75', 14, 9789045204390, 2, 1),
(26, '2019-05-12', '28.21', '8.72', 14, 9789048311828, 3, 1),
(27, '2019-02-09', '52.96', '5.38', 14, 9789048311828, 1, 1),
(28, '2018-07-07', '76.82', '2.28', 14, 9789048311828, 2, 1),
(29, '2018-12-31', '60.69', '8.91', 14, 9789048311828, 2, 1),
(30, '2015-01-23', '59.26', '7.47', 14, 9789048311828, 1, 1),
(31, '2019-01-04', '45.33', '6.17', 14, 9789045215617, 1, 1),
(32, '2019-03-07', '24.40', '2.33', 14, 9789045215617, 2, 1),
(33, '2018-03-04', '63.27', '5.64', 14, 9789045215617, 3, 1),
(34, '2018-11-13', '20.83', '2.79', 14, 9789045215617, 2, 1),
(35, '2015-12-13', '94.73', '5.32', 14, 9789045215617, 3, 1),
(36, '2019-05-12', '59.56', '5.81', 14, 9789046819494, 2, 1),
(37, '2019-02-09', '61.27', '5.47', 14, 9789046819494, 1, 1),
(38, '2018-07-07', '36.87', '4.88', 14, 9789046819494, 2, 1),
(39, '2018-12-31', '18.63', '7.93', 14, 9789046819494, 2, 1),
(40, '2015-01-23', '95.25', '6.82', 14, 9789046819494, 2, 1),
(41, '2019-05-12', '29.69', '9.79', 14, 9789045200507, 1, 1),
(42, '2019-02-09', '8.98', '6.10', 14, 9789045200507, 1, 1),
(43, '2018-07-07', '54.34', '5.71', 14, 9789045200507, 3, 1),
(44, '2018-12-31', '11.77', '4.58', 14, 9789045200507, 3, 1),
(45, '2015-01-23', '13.38', '6.64', 14, 9789045200507, 1, 1),
(46, '2019-05-12', '80.20', '6.98', 14, 9789045200507, 2, 1),
(47, '2019-02-09', '42.75', '2.25', 14, 9789059205024, 1, 1),
(48, '2018-07-07', '16.11', '9.89', 14, 9789059205024, 1, 1),
(49, '2018-12-31', '43.73', '4.83', 14, 9789059205024, 3, 1),
(50, '2015-01-23', '64.93', '3.47', 14, 9789059205024, 1, 1),
(51, '2019-05-12', '78.26', '3.76', 14, 9789059205024, 2, 1),
(52, '2019-02-09', '63.42', '6.58', 14, 9789059205024, 3, 1),
(53, '2018-07-07', '10.93', '4.15', 14, 9789044718959, 1, 1),
(54, '2018-12-31', '50.69', '2.27', 14, 9789044718959, 2, 1),
(55, '2015-01-23', '96.54', '4.83', 14, 9789044718959, 1, 1),
(56, '2019-05-12', '68.44', '8.93', 14, 9789044718959, 1, 1),
(57, '2019-02-09', '38.24', '8.28', 14, 9789044718959, 2, 1),
(58, '2018-07-07', '87.53', '6.66', 14, 9789044718959, 2, 1),
(59, '2018-12-31', '23.67', '3.75', 14, 9789461431110, 1, 1),
(60, '2015-01-23', '57.80', '4.89', 14, 9789461431110, 1, 1),
(61, '2019-05-12', '61.29', '6.44', 14, 9789461431110, 3, 1),
(62, '2019-02-09', '96.14', '3.22', 14, 9789461431110, 2, 1),
(63, '2018-07-07', '33.25', '8.60', 14, 9789461431110, 1, 1),
(64, '2018-12-31', '60.66', '4.17', 14, 9789461431110, 2, 1),
(65, '2015-01-23', '46.86', '8.11', 14, 9789021588490, 1, 1),
(66, '2019-05-12', '74.19', '6.38', 14, 9789021588490, 1, 1),
(67, '2019-02-09', '13.73', '1.61', 14, 9789021588490, 1, 1),
(68, '2018-07-07', '50.36', '9.44', 14, 9789021588490, 3, 1),
(69, '2018-12-31', '17.96', '3.57', 14, 9789021588490, 1, 1),
(70, '2015-01-23', '29.43', '6.54', 14, 9789021588490, 1, 1),
(71, '2019-05-12', '2.00', '8.83', 14, 9789021599205, 1, 1),
(72, '2019-02-09', '16.65', '1.12', 14, 9789021599205, 3, 1),
(73, '2018-07-07', '47.25', '4.41', 14, 9789021599205, 1, 1),
(74, '2018-12-31', '68.87', '4.57', 14, 9789021599205, 2, 1),
(75, '2015-01-23', '41.44', '1.29', 14, 9789021599205, 1, 1),
(76, '2019-05-12', '93.82', '3.77', 14, 9789021540689, 3, 1),
(77, '2019-02-09', '94.50', '5.27', 14, 9789021540689, 1, 1),
(78, '2018-07-07', '76.12', '3.27', 14, 9789021540689, 3, 1),
(79, '2018-12-31', '89.77', '1.84', 14, 9789021540689, 2, 1),
(80, '2015-01-23', '49.36', '8.56', 14, 9789021540689, 3, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `exemplaren groter of gelijk aan 17,50`
-- (See below for the actual view)
--
CREATE TABLE `exemplaren groter of gelijk aan 17,50` (
`titel` varchar(255)
,`Aanschafprijs in euro’s` decimal(10,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `gereserveerde boeken`
-- (See below for the actual view)
--
CREATE TABLE `gereserveerde boeken` (
`Voornaam` varchar(255)
,`Achternaam` varchar(255)
,`Titel` varchar(255)
,`Reserveringsdatum` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `jeugdleden`
-- (See below for the actual view)
--
CREATE TABLE `jeugdleden` (
`Voorletter` char(1)
,`Voornaam` varchar(255)
,`voorvoegsel` varchar(255)
,`Achternaam` varchar(255)
,`Lid_nr` int(9)
,`Leeftijd` int(5)
);

-- --------------------------------------------------------

--
-- Table structure for table `lening`
--

CREATE TABLE `lening` (
  `Boek_nr` int(9) NOT NULL,
  `Lid_nr` int(9) NOT NULL,
  `Uitleentijdstip` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Inleverdatum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lening`
--

INSERT INTO `lening` (`Boek_nr`, `Lid_nr`, `Uitleentijdstip`, `Inleverdatum`) VALUES
(2, 5, '2018-11-05 23:00:00', '2018-11-26'),
(3, 3, '2018-09-05 22:00:00', '2018-09-12'),
(4, 8, '2019-03-09 23:00:00', NULL),
(7, 8, '2018-12-05 23:00:00', '2018-12-16'),
(9, 4, '2018-02-08 23:00:00', '2018-02-24'),
(10, 10, '2019-03-14 23:00:00', NULL),
(11, 5, '2018-12-09 23:00:00', '2018-12-25'),
(15, 3, '2018-12-09 23:00:00', NULL),
(18, 1, '2018-11-23 23:00:00', '2018-12-31'),
(19, 2, '2018-03-14 23:00:00', '2018-04-11'),
(20, 8, '2018-10-20 22:00:00', '2018-11-01'),
(21, 8, '2018-09-19 22:00:00', '2018-09-29'),
(22, 5, '2018-01-05 23:00:00', '2018-01-26'),
(23, 3, '2019-02-09 23:00:00', NULL),
(28, 2, '2018-08-19 22:00:00', '2018-08-29'),
(31, 1, '2019-03-10 23:00:00', NULL),
(31, 5, '2018-11-06 23:00:00', '2018-11-19'),
(33, 6, '2018-06-20 22:00:00', '2018-07-01'),
(36, 5, '2018-09-30 22:00:00', '2018-10-11'),
(41, 7, '2018-08-19 22:00:00', '2018-08-30'),
(42, 3, '2018-07-06 22:00:00', '2018-07-09'),
(42, 8, '2018-04-08 22:00:00', '2018-04-10'),
(47, 4, '2018-12-18 23:00:00', '2018-12-31'),
(48, 9, '2018-09-22 22:00:00', '2018-10-03'),
(49, 2, '2018-09-03 22:00:00', '2018-09-29'),
(52, 1, '2018-09-02 22:00:00', '2018-10-03'),
(52, 10, '2018-11-18 23:00:00', '0000-00-00'),
(55, 9, '2018-05-10 22:00:00', '2018-05-22'),
(56, 10, '2018-11-09 23:00:00', '2018-11-18'),
(58, 8, '2018-03-26 22:00:00', '2018-04-17'),
(63, 9, '2018-09-23 22:00:00', '2018-10-04'),
(64, 7, '2018-11-13 23:00:00', '2018-11-14'),
(66, 7, '2018-10-11 22:00:00', '2018-10-24'),
(68, 5, '2018-07-09 22:00:00', '2018-07-15'),
(69, 7, '2018-02-19 23:00:00', '2018-02-21');

-- --------------------------------------------------------

--
-- Table structure for table `lid`
--

CREATE TABLE `lid` (
  `Lid_nr` int(9) NOT NULL,
  `Voorletter` char(1) NOT NULL,
  `Voornaam` varchar(255) NOT NULL,
  `Voorvoegsel` varchar(255) DEFAULT NULL,
  `Achternaam` varchar(255) NOT NULL,
  `Straatnaam` varchar(255) NOT NULL,
  `Huisnummer` int(5) NOT NULL,
  `Huisnummertoevoeging` varchar(3) DEFAULT NULL,
  `Woonplaats` varchar(255) NOT NULL,
  `Postcode` varchar(6) NOT NULL,
  `Telefoonnummer` varchar(10) NOT NULL,
  `Emailadres` varchar(255) NOT NULL,
  `Geboortedatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lid`
--

INSERT INTO `lid` (`Lid_nr`, `Voorletter`, `Voornaam`, `Voorvoegsel`, `Achternaam`, `Straatnaam`, `Huisnummer`, `Huisnummertoevoeging`, `Woonplaats`, `Postcode`, `Telefoonnummer`, `Emailadres`, `Geboortedatum`) VALUES
(1, 'G', 'Guy', 'de', 'Trè', 'Tuplestraat', 96, 'a', 'Graad', '4811XP', '0765139545', 'Intentie@extentie.nl', '1901-12-31'),
(2, 'J', 'Michael', NULL, 'Jackson', 'Intentiestraat', 3, NULL, 'Extentie', '5123FF', '0673461396', 'Tuple@graad.nl', '1970-01-03'),
(3, 'M', 'Marco', NULL, 'Borsato', 'Marcostraat', 1, NULL, 'Borsatodorp', '9563TD', '0611112222', 'Marco@Borsato.nl', '1961-05-01'),
(4, 'R', 'Rutger', NULL, 'Hauer', 'Sterrenlaan', 19, 'Bis', 'Ee', '1853AZ', '0915719203', 'Hauer@dfw.nl', '1954-11-20'),
(5, 'J', 'Jamie', NULL, 'Oliver', 'Biefstuklaan', 6, NULL, 'Breda', '4816TV', '0618238952', 'Jamie@Oliver.com', '1984-12-04'),
(6, 'W', 'Walter', NULL, 'Disney', 'Mickeystraat', 1, NULL, 'Disneyland', '1053DL', '0191230531', 'Walter@disney.com', '1948-09-12'),
(7, 'J', 'Jackie', NULL, 'Chan', 'Karatestraat', 4, NULL, 'Vecht', '4910ZZ', '0612951025', 'Jackiechan@gmail.com', '1949-05-11'),
(8, 'A', 'Armin', 'Van', 'Buuren', 'Trancestraat', 7, 'A', 'Amsterdam', '1953GG', '0612859192', 'AvB@Armadamusic.nl', '1979-12-28'),
(9, 'M', 'Morgan', NULL, 'Freeman', 'Halvestraat', 8, NULL, 'Leef', '1853GG', '0613486414', 'Freeman@valve.com', '1951-06-06'),
(10, 'A', 'Anthony', NULL, 'Mitchell', 'Bestemmingsstraat', 7, NULL, 'Plaats', '1931TT', '0612312313', 'AMitchell@gmail.com', '2010-06-02');

-- --------------------------------------------------------

--
-- Table structure for table `onderwerp`
--

CREATE TABLE `onderwerp` (
  `NUR_Code` int(3) NOT NULL,
  `Naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `onderwerp`
--

INSERT INTO `onderwerp` (`NUR_Code`, `Naam`) VALUES
(120, 'Exacte vakken en Informatice Algemeen'),
(123, 'Exacte vakken en Informatica HOGER ONDERWIJS'),
(301, 'Literaire Roman'),
(422, 'Kamerplanten'),
(440, 'Eten en Drinken Algemeen'),
(441, 'Basis Kookboeken'),
(444, 'Vegetarische Kookboeken'),
(995, 'Databases');

-- --------------------------------------------------------

--
-- Stand-in structure for view `postcodes waarbij het 2de cijfer 8 is`
-- (See below for the actual view)
--
CREATE TABLE `postcodes waarbij het 2de cijfer 8 is` (
`Voornaam` varchar(255)
,`Achternaam` varchar(255)
,`Postcode` varchar(6)
);

-- --------------------------------------------------------

--
-- Table structure for table `reservering`
--

CREATE TABLE `reservering` (
  `Lid_nr` int(9) NOT NULL,
  `ISBN` bigint(13) NOT NULL,
  `Reserveringsdatum` date NOT NULL,
  `Reserveringsstatus` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservering`
--

INSERT INTO `reservering` (`Lid_nr`, `ISBN`, `Reserveringsdatum`, `Reserveringsstatus`) VALUES
(1, 9789021588490, '2019-02-12', 0),
(1, 9789021588490, '2019-02-15', 0),
(1, 9789021599205, '2019-02-20', 0),
(1, 9789045200507, '2019-03-07', 0),
(1, 9789045204390, '2019-01-17', 1),
(1, 9789048311828, '2019-01-25', 1),
(1, 9789461431110, '2019-02-20', 0),
(2, 9789001558536, '2019-01-10', 1),
(2, 9789043035804, '2019-01-10', 1),
(2, 9789043035804, '2019-02-12', 0),
(2, 9789044718959, '2019-02-17', 0),
(2, 9789045200507, '2019-02-25', 0),
(2, 9789045204390, '2019-01-22', 1),
(2, 9789059205024, '2019-01-15', 0),
(2, 9789461431110, '2019-01-10', 0),
(2, 9789461431110, '2019-03-24', 0),
(3, 9780672226304, '2019-02-01', 1),
(3, 9789001558536, '2019-02-06', 1),
(3, 9789021588490, '2019-03-22', 0),
(3, 9789021599205, '2019-02-24', 0),
(3, 9789043035804, '2019-02-21', 1),
(3, 9789044718959, '2019-02-26', 0),
(3, 9789044718959, '2019-03-20', 0),
(3, 9789045204390, '2019-02-12', 1),
(3, 9789045215617, '2019-01-08', 0),
(3, 9789045215617, '2019-01-27', 0),
(3, 9789045215617, '2019-03-08', 0),
(3, 9789046819494, '2019-01-05', 0),
(3, 9789048311828, '2019-03-21', 1),
(3, 9789461431110, '2019-01-10', 0),
(3, 9789461431110, '2019-02-21', 0),
(3, 9789461431110, '2019-03-05', 0),
(4, 9789021540689, '2019-03-10', 0),
(4, 9789021588490, '2019-02-19', 0),
(4, 9789044718959, '2019-02-04', 0),
(4, 9789045204390, '2019-03-18', 1),
(4, 9789046819494, '2019-03-14', 0),
(4, 9789046819494, '2019-03-24', 0),
(4, 9789048311828, '2019-03-25', 1),
(4, 9789059205024, '2019-02-07', 0),
(5, 9780672226304, '2019-03-18', 1),
(5, 9789001558536, '2019-01-30', 1),
(5, 9789021540689, '2019-01-25', 0),
(5, 9789044718959, '2019-01-11', 0),
(5, 9789045200507, '2019-01-10', 0),
(5, 9789462371392, '2019-02-22', 1),
(5, 9789462371392, '2019-03-22', 0),
(6, 9780672226304, '2019-01-09', 1),
(6, 9789021540689, '2019-02-20', 0),
(6, 9789021599205, '2019-03-18', 0),
(6, 9789021599205, '2019-03-26', 0),
(6, 9789043035804, '2019-01-15', 1),
(6, 9789045215617, '2019-03-05', 0),
(6, 9789048311828, '2019-01-23', 1),
(6, 9789462371392, '2019-02-06', 1),
(7, 9780672226304, '2019-03-08', 1),
(7, 9789001558536, '2019-02-21', 1),
(7, 9789021588490, '2019-03-08', 0),
(7, 9789048311828, '2019-01-14', 1),
(8, 9789021588490, '2019-01-13', 0),
(8, 9789021599205, '2019-03-26', 0),
(8, 9789043035804, '2019-01-09', 1),
(8, 9789045200507, '2019-03-10', 0),
(8, 9789045215617, '2019-03-05', 0),
(8, 9789059205024, '2019-01-05', 0),
(9, 9789021540689, '2019-03-10', 0),
(9, 9789021540689, '2019-03-20', 0),
(9, 9789045200507, '2019-03-23', 0),
(9, 9789045204390, '2019-01-18', 1),
(9, 9789059205024, '2019-01-05', 0),
(9, 9789059205024, '2019-01-28', 0),
(9, 9789462371392, '2019-02-27', 1),
(10, 9780672226304, '2019-02-07', 1),
(10, 9789001558536, '2019-01-17', 1),
(10, 9789044718959, '2019-01-21', 0),
(10, 9789045200507, '2019-01-13', 0),
(10, 9789046819494, '2019-01-21', 0),
(10, 9789046819494, '2019-03-17', 0),
(10, 9789059205024, '2019-02-28', 0),
(10, 9789462371392, '2019-03-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `serie`
--

CREATE TABLE `serie` (
  `Serie_nr` int(9) NOT NULL,
  `Titel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `serie`
--

INSERT INTO `serie` (`Serie_nr`, `Titel`) VALUES
(1, 'Koken met Jamie');

-- --------------------------------------------------------

--
-- Stand-in structure for view `titels van uitgeleende boeken`
-- (See below for the actual view)
--
CREATE TABLE `titels van uitgeleende boeken` (
`Titel` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `uitgeverij`
--

CREATE TABLE `uitgeverij` (
  `Uitgeverij_nr` int(9) NOT NULL,
  `Naam` varchar(255) DEFAULT NULL,
  `Postcode` varchar(255) DEFAULT NULL,
  `Straatnaam` varchar(255) DEFAULT NULL,
  `Huisnummer` int(5) DEFAULT NULL,
  `Huisnummertoevoeging` varchar(3) DEFAULT NULL,
  `Plaats` varchar(255) DEFAULT NULL,
  `Telefoonnummer` varchar(10) DEFAULT NULL,
  `Emailadres` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uitgeverij`
--

INSERT INTO `uitgeverij` (`Uitgeverij_nr`, `Naam`, `Postcode`, `Straatnaam`, `Huisnummer`, `Huisnummertoevoeging`, `Plaats`, `Telefoonnummer`, `Emailadres`) VALUES
(1, 'Culinaire Boekerij', '4810SS', 'Uitgeverweg', 1, NULL, 'Breda', '0761235120', 'info@culinaireboekerij.nl'),
(2, 'Leesboekerij', '4811SS', 'Uitgeverweg', 2, NULL, 'Breda', '0761235122', 'info@leesboekerij.nl'),
(3, 'Leerboekerij', '4812SS', 'Uitgeverweg', 3, NULL, 'Breda', '0761235124', 'info@leerboekerij.nl');

-- --------------------------------------------------------

--
-- Structure for view `aantal geleende boeken per lid`
--
DROP TABLE IF EXISTS `aantal geleende boeken per lid`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aantal geleende boeken per lid`  AS  select `lid`.`Voornaam` AS `Voornaam`,`lid`.`Achternaam` AS `achternaam`,count(`lening`.`Lid_nr`) AS `geleende boeken` from (`lid` join `lening` on((`lid`.`Lid_nr` = `lening`.`Lid_nr`))) group by `lid`.`Lid_nr` order by `lid`.`Achternaam` ;

-- --------------------------------------------------------

--
-- Structure for view `auteurs en titels`
--
DROP TABLE IF EXISTS `auteurs en titels`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `auteurs en titels`  AS  select `auteur`.`Voorletter` AS `voorletter`,`auteur`.`Voornaam` AS `voornaam`,`auteur`.`Voorvoegsel` AS `voorvoegsel`,`auteur`.`Achternaam` AS `achternaam`,`boek`.`Titel` AS `Titel` from (`auteur` join `boek` on((`auteur`.`Auteur_nr` = `boek`.`Auteur_nr`))) ;

-- --------------------------------------------------------

--
-- Structure for view `auteurs van boeken met isbn <4000 of >7000`
--
DROP TABLE IF EXISTS `auteurs van boeken met isbn <4000 of >7000`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `auteurs van boeken met isbn <4000 of >7000`  AS  select `auteur`.`Voornaam` AS `voornaam`,`auteur`.`Achternaam` AS `achternaam`,`boek`.`ISBN` AS `ISBN` from (`boek` join `auteur` on((`boek`.`Auteur_nr` = `auteur`.`Auteur_nr`))) where (substr(`boek`.`ISBN`,-(4)) not between 4000 and 7000) order by `boek`.`ISBN` ;

-- --------------------------------------------------------

--
-- Structure for view `eigen statement 1, boeken per bibliotheek & uitgever`
--
DROP TABLE IF EXISTS `eigen statement 1, boeken per bibliotheek & uitgever`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `eigen statement 1, boeken per bibliotheek & uitgever`  AS  select count(`exemplaar`.`Boek_nr`) AS `Aantal Boeken`,round(avg(`exemplaar`.`Aanschafprijs`),2) AS `Gemiddelde Aanschafprijs`,`bibliotheek`.`Naam` AS `Bibliotheek`,`uitgeverij`.`Naam` AS `Uitgeverij` from ((`exemplaar` join `uitgeverij` on((`exemplaar`.`Uitgeverij_nr` = `uitgeverij`.`Uitgeverij_nr`))) join `bibliotheek` on((`exemplaar`.`Bibliotheek_nr` = `bibliotheek`.`Bibliotheek_nr`))) group by `bibliotheek`.`Naam`,`uitgeverij`.`Naam` order by `bibliotheek`.`Naam` ;

-- --------------------------------------------------------

--
-- Structure for view `eigen statement 2, boeken te laat door wie + boetebedrag`
--
DROP TABLE IF EXISTS `eigen statement 2, boeken te laat door wie + boetebedrag`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `eigen statement 2, boeken te laat door wie + boetebedrag`  AS  select `lid`.`Voornaam` AS `Voornaam`,`lid`.`Achternaam` AS `Achternaam`,`boek`.`Titel` AS `titel`,(to_days(ifnull(`lening`.`Inleverdatum`,curdate())) - to_days((`lening`.`Uitleentijdstip` + interval `exemplaar`.`Uitleengrondslag` day))) AS `Dagen te laat`,(`exemplaar`.`Boetetarief` * (to_days(ifnull(`lening`.`Inleverdatum`,curdate())) - to_days((`lening`.`Uitleentijdstip` + interval `exemplaar`.`Uitleengrondslag` day)))) AS `Boetetotaal` from (((`lening` join `exemplaar` on((`lening`.`Boek_nr` = `exemplaar`.`Boek_nr`))) join `boek` on((`exemplaar`.`ISBN` = `boek`.`ISBN`))) join `lid` on((`lening`.`Lid_nr` = `lid`.`Lid_nr`))) where ((to_days(ifnull(`lening`.`Inleverdatum`,curdate())) - to_days((`lening`.`Uitleentijdstip` + interval `exemplaar`.`Uitleengrondslag` day))) > 0) order by (`exemplaar`.`Boetetarief` * (to_days(ifnull(`lening`.`Inleverdatum`,curdate())) - to_days((`lening`.`Uitleentijdstip` + interval `exemplaar`.`Uitleengrondslag` day)))) desc ;

-- --------------------------------------------------------

--
-- Structure for view `exemplaren groter of gelijk aan 17,50`
--
DROP TABLE IF EXISTS `exemplaren groter of gelijk aan 17,50`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `exemplaren groter of gelijk aan 17,50`  AS  select distinct `boek`.`Titel` AS `titel`,`exemplaar`.`Aanschafprijs` AS `Aanschafprijs in euro’s` from (`boek` join `exemplaar` on((`boek`.`ISBN` = `exemplaar`.`ISBN`))) where (`exemplaar`.`Aanschafprijs` >= 17.50) ;

-- --------------------------------------------------------

--
-- Structure for view `gereserveerde boeken`
--
DROP TABLE IF EXISTS `gereserveerde boeken`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gereserveerde boeken`  AS  select `lid`.`Voornaam` AS `Voornaam`,`lid`.`Achternaam` AS `Achternaam`,`boek`.`Titel` AS `Titel`,`reservering`.`Reserveringsdatum` AS `Reserveringsdatum` from ((`reservering` join `lid` on((`reservering`.`Lid_nr` = `lid`.`Lid_nr`))) join `boek` on((`reservering`.`ISBN` = `boek`.`ISBN`))) where (`reservering`.`Reserveringsstatus` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `jeugdleden`
--
DROP TABLE IF EXISTS `jeugdleden`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `jeugdleden`  AS  select `lid`.`Voorletter` AS `Voorletter`,`lid`.`Voornaam` AS `Voornaam`,`lid`.`Voorvoegsel` AS `voorvoegsel`,`lid`.`Achternaam` AS `Achternaam`,`lid`.`Lid_nr` AS `Lid_nr`,(year(curdate()) - year(`lid`.`Geboortedatum`)) AS `Leeftijd` from `lid` where ((year(curdate()) - year(`lid`.`Geboortedatum`)) < 18) ;

-- --------------------------------------------------------

--
-- Structure for view `postcodes waarbij het 2de cijfer 8 is`
--
DROP TABLE IF EXISTS `postcodes waarbij het 2de cijfer 8 is`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `postcodes waarbij het 2de cijfer 8 is`  AS  select `lid`.`Voornaam` AS `Voornaam`,`lid`.`Achternaam` AS `Achternaam`,`lid`.`Postcode` AS `Postcode` from `lid` where (`lid`.`Postcode` regexp '^.8') ;

-- --------------------------------------------------------

--
-- Structure for view `titels van uitgeleende boeken`
--
DROP TABLE IF EXISTS `titels van uitgeleende boeken`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `titels van uitgeleende boeken`  AS  select `boek`.`Titel` AS `Titel` from ((`exemplaar` join `lening` on((`exemplaar`.`Boek_nr` = `lening`.`Boek_nr`))) join `boek` on((`exemplaar`.`ISBN` = `boek`.`ISBN`))) where isnull(`lening`.`Inleverdatum`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auteur`
--
ALTER TABLE `auteur`
  ADD PRIMARY KEY (`Auteur_nr`);

--
-- Indexes for table `bibliotheek`
--
ALTER TABLE `bibliotheek`
  ADD PRIMARY KEY (`Bibliotheek_nr`);

--
-- Indexes for table `boek`
--
ALTER TABLE `boek`
  ADD PRIMARY KEY (`ISBN`),
  ADD KEY `Auteur_nr` (`Auteur_nr`),
  ADD KEY `Serie_nr` (`Serie_nr`);

--
-- Indexes for table `boek_onderwerp`
--
ALTER TABLE `boek_onderwerp`
  ADD PRIMARY KEY (`ISBN`,`NUR_CODE`),
  ADD KEY `NUR_CODE` (`NUR_CODE`);

--
-- Indexes for table `exemplaar`
--
ALTER TABLE `exemplaar`
  ADD PRIMARY KEY (`Boek_nr`),
  ADD KEY `Bibliotheek_nr` (`Bibliotheek_nr`),
  ADD KEY `Uitgeverij_nr` (`Uitgeverij_nr`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indexes for table `lening`
--
ALTER TABLE `lening`
  ADD PRIMARY KEY (`Boek_nr`,`Lid_nr`,`Uitleentijdstip`),
  ADD KEY `Lid_nr` (`Lid_nr`);

--
-- Indexes for table `lid`
--
ALTER TABLE `lid`
  ADD PRIMARY KEY (`Lid_nr`);

--
-- Indexes for table `onderwerp`
--
ALTER TABLE `onderwerp`
  ADD PRIMARY KEY (`NUR_Code`);

--
-- Indexes for table `reservering`
--
ALTER TABLE `reservering`
  ADD PRIMARY KEY (`Lid_nr`,`ISBN`,`Reserveringsdatum`),
  ADD KEY `ISBN` (`ISBN`);

--
-- Indexes for table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`Serie_nr`);

--
-- Indexes for table `uitgeverij`
--
ALTER TABLE `uitgeverij`
  ADD PRIMARY KEY (`Uitgeverij_nr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auteur`
--
ALTER TABLE `auteur`
  MODIFY `Auteur_nr` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bibliotheek`
--
ALTER TABLE `bibliotheek`
  MODIFY `Bibliotheek_nr` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exemplaar`
--
ALTER TABLE `exemplaar`
  MODIFY `Boek_nr` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `lid`
--
ALTER TABLE `lid`
  MODIFY `Lid_nr` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `serie`
--
ALTER TABLE `serie`
  MODIFY `Serie_nr` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uitgeverij`
--
ALTER TABLE `uitgeverij`
  MODIFY `Uitgeverij_nr` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boek`
--
ALTER TABLE `boek`
  ADD CONSTRAINT `boek_ibfk_2` FOREIGN KEY (`Auteur_nr`) REFERENCES `auteur` (`Auteur_nr`),
  ADD CONSTRAINT `boek_ibfk_3` FOREIGN KEY (`Serie_nr`) REFERENCES `serie` (`Serie_nr`);

--
-- Constraints for table `boek_onderwerp`
--
ALTER TABLE `boek_onderwerp`
  ADD CONSTRAINT `boek_onderwerp_ibfk_1` FOREIGN KEY (`NUR_CODE`) REFERENCES `onderwerp` (`NUR_Code`),
  ADD CONSTRAINT `boek_onderwerp_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `boek` (`ISBN`);

--
-- Constraints for table `exemplaar`
--
ALTER TABLE `exemplaar`
  ADD CONSTRAINT `exemplaar_ibfk_1` FOREIGN KEY (`Bibliotheek_nr`) REFERENCES `bibliotheek` (`Bibliotheek_nr`),
  ADD CONSTRAINT `exemplaar_ibfk_2` FOREIGN KEY (`Uitgeverij_nr`) REFERENCES `uitgeverij` (`Uitgeverij_nr`),
  ADD CONSTRAINT `exemplaar_ibfk_3` FOREIGN KEY (`ISBN`) REFERENCES `boek` (`ISBN`);

--
-- Constraints for table `lening`
--
ALTER TABLE `lening`
  ADD CONSTRAINT `lening_ibfk_1` FOREIGN KEY (`Boek_nr`) REFERENCES `exemplaar` (`Boek_nr`) ON DELETE CASCADE,
  ADD CONSTRAINT `lening_ibfk_2` FOREIGN KEY (`Lid_nr`) REFERENCES `lid` (`Lid_nr`) ON DELETE CASCADE;

--
-- Constraints for table `reservering`
--
ALTER TABLE `reservering`
  ADD CONSTRAINT `Reservering_ibfk_1` FOREIGN KEY (`Lid_nr`) REFERENCES `lid` (`Lid_nr`) ON DELETE CASCADE,
  ADD CONSTRAINT `Reservering_ibfk_2` FOREIGN KEY (`ISBN`) REFERENCES `boek` (`ISBN`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
