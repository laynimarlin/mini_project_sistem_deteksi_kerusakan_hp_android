-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 09, 2026 at 07:07 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diagnosa_hp`
--

-- --------------------------------------------------------

--
-- Table structure for table `conditions`
--

DROP TABLE IF EXISTS `conditions`;
CREATE TABLE IF NOT EXISTS `conditions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kondisi` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `conditions`
--

INSERT INTO `conditions` (`id`, `nama_kondisi`) VALUES
(1, 'HP tidak menyala'),
(2, 'Tidak bisa charge'),
(3, 'Layar blank'),
(4, 'HP cepat panas'),
(5, 'Baterai cepat habis'),
(6, 'Sering restart'),
(7, 'Tidak ada sinyal'),
(8, 'Kamera tidak berfungsi'),
(9, 'Layar tidak responsif'),
(10, 'Ada suara tetapi layar mati');

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

DROP TABLE IF EXISTS `rules`;
CREATE TABLE IF NOT EXISTS `rules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kondisi1` int NOT NULL,
  `kondisi2` int NOT NULL,
  `hasil` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `kondisi1` (`kondisi1`),
  KEY `kondisi2` (`kondisi2`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `kondisi1`, `kondisi2`, `hasil`) VALUES
(18, 8, 6, 'Modul Kamera Rusak'),
(17, 7, 2, 'IC Sinyal Rusak'),
(16, 6, 5, 'Sistem Crash'),
(15, 2, 1, 'Port Charger Rusak'),
(14, 4, 5, 'Baterai Drop'),
(13, 3, 10, 'LCD Rusak'),
(12, 1, 5, 'Baterai Rusak'),
(11, 1, 2, 'IC Power Rusak'),
(19, 9, 6, 'Touchscreen Bermasalah'),
(20, 4, 6, 'Overheat'),
(21, 4, 0, 'Overheat'),
(22, 5, 0, 'Baterai Drop'),
(23, 7, 0, 'Gangguan Sinyal'),
(24, 1, 0, 'Kerusakan Power'),
(25, 3, 0, 'Kerusakan Layar');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
