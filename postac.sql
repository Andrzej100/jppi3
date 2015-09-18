-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas generowania: 18 Wrz 2015, 13:19
-- Wersja serwera: 5.6.25
-- Wersja PHP: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `nowabaza`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `postac`
--

CREATE TABLE IF NOT EXISTS `postac` (
  `id` int(11) NOT NULL,
  `imie` varchar(255) NOT NULL,
  `sila` int(11) NOT NULL,
  `zrecznosc` int(11) NOT NULL,
  `szybkosc` int(11) NOT NULL,
  `zycie` int(11) NOT NULL,
  `zloto` int(11) NOT NULL,
  `dosw` int(11) NOT NULL,
  `wygrane` int(11) NOT NULL,
  `przegrane` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `postac`
--

INSERT INTO `postac` (`id`, `imie`, `sila`, `zrecznosc`, `szybkosc`, `zycie`, `zloto`, `dosw`, `wygrane`, `przegrane`, `id_uzytkownika`) VALUES
(6, 'post 1', 1, 1, 1, 1, 0, 0, 0, 0, 11),
(7, 'post 2', 1, 1, 1, 1, 0, 0, 0, 0, 11),
(8, 'post 3', 1, 1, 1, 1, 0, 0, 0, 0, 11);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `postac`
--
ALTER TABLE `postac`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`),
  ADD KEY `id_uzytkownika_2` (`id_uzytkownika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `postac`
--
ALTER TABLE `postac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
