-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Loomise aeg: Jaan 19, 2024 kell 01:05 PL
-- Serveri versioon: 10.4.27-MariaDB
-- PHP versioon: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Andmebaas: `ekaterinamosljajevaa`
--

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `kasutaja`
--

CREATE TABLE `kasutaja` (
  `id` int(11) NOT NULL,
  `kasutaja` varchar(30) DEFAULT NULL,
  `parool` varchar(100) DEFAULT NULL,
  `onAdmin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `kasutaja`
--

INSERT INTO `kasutaja` (`id`, `kasutaja`, `parool`, `onAdmin`) VALUES
(1, 'admin', 'su6FF4/MgjUAk', 1),
(2, 'opilane', 'suql11CWUmRTs', 0),
(3, 'test', 'suBzFzcU4xnjQ', 0);

-- --------------------------------------------------------

--
-- Tabeli struktuur tabelile `suusahyppajad`
--

CREATE TABLE `suusahyppajad` (
  `id` int(11) NOT NULL,
  `nimi` varchar(30) NOT NULL,
  `alustanud` datetime DEFAULT NULL,
  `kaugus` int(11) DEFAULT NULL,
  `valmis` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Andmete tõmmistamine tabelile `suusahyppajad`
--

INSERT INTO `suusahyppajad` (`id`, `nimi`, `alustanud`, `kaugus`, `valmis`) VALUES
(1, 'Anna', '2024-01-19 11:47:36', NULL, '2024-01-19 14:01:21'),
(2, 'Aleksey', '2024-01-19 11:50:37', NULL, NULL),
(3, 'Artjom', NULL, NULL, NULL),
(4, 'Anton', NULL, NULL, NULL),
(5, 'Marina', NULL, NULL, NULL),
(6, 'Ekaterina', NULL, NULL, NULL);

--
-- Indeksid tõmmistatud tabelitele
--

--
-- Indeksid tabelile `kasutaja`
--
ALTER TABLE `kasutaja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kasutaja` (`kasutaja`);

--
-- Indeksid tabelile `suusahyppajad`
--
ALTER TABLE `suusahyppajad`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT tõmmistatud tabelitele
--

--
-- AUTO_INCREMENT tabelile `kasutaja`
--
ALTER TABLE `kasutaja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT tabelile `suusahyppajad`
--
ALTER TABLE `suusahyppajad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
