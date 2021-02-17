-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 dec 2019 om 23:54
-- Serverversie: 10.1.38-MariaDB
-- PHP-versie: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vbuw`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_code` int(11) NOT NULL,
  `log_message` varchar(255) NOT NULL,
  `log_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `resets`
--

CREATE TABLE `resets` (
  `reset_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(25),
  `user_firstname` varchar(25),
  `user_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `user_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `user_auth` int(100) NOT NULL,
  `user_language` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_type` varchar(25) NOT NULL,
  `document_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `document_updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `s627en`
--

CREATE TABLE `s627en` (
  `s627_id` int(11) NOT NULL,
  `s627_name` varchar(25) NOT NULL,
  `s627_y` FLOAT(5, 2) NOT NULL,
	`s627_x` FLOAT(5, 2) NOT NULL,
	`s627_w` FLOAT(5, 2),
	`s627_h` FLOAT(5, 2),
	`s627_align` CHAR(1),
	`s627_valign` CHAR(1),
	`s627_border` tinyint(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `s627en` (`s627_id`, `s627_name`, `s627_y`, `s627_x`, `s627_w`, `s627_h`, `s627_align`, `s627_valign`, `s627_border`) VALUES
(1, 'ingediendDoor', 40.50, 29.00, 48.00, 5.00, NULL, NULL, NULL),
(2, 'specialiteit', 109.00, 29.00, 38.00, 5.00, NULL, NULL, NULL),
(3, 'aan', 26.00, 34.20, 41.00, 5.00, NULL, NULL, NULL),
(4, 'aanvangDatum', 50.50, 84.70, 21.00, 5.00, NULL, NULL, NULL),
(5, 'aanvangUur', 78.00, 84.70, 20.00, 5.00, NULL, NULL, NULL),
(6, 'vermoedelijkeDuur', 125.50, 84.70, 21.00, 5.00, NULL, NULL, NULL),
(7, 'ingediendDoor', 174.00, 168.40, 40.00, 5.00, NULL, NULL, NULL),
(8, 'post', 79.20, 34.20, 18.00, 5.00, NULL, NULL, NULL),
(9, 'station', 109.00, 34.20, 38.00, 5.00, NULL, NULL, NULL),
(10, 'aanvraag', 19.70, 45.00, 127.00, 39.70, 'L', 'T', 0),
(11, 'rubriek2ARMS', 36.50, 119.00, 127.00, 39.70, 'L', 'T', 0),
(12, 'rubriek2AAndere', 36.50, 142.00, 94.00, 14.00, 'L', 'T', 0),
(14, 'rubriek5VVHW', 155.00, 149.00, 120.00, 17.00, 'L', 'T', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `s627en_input`
--

CREATE TABLE `s627en_input` (
  `s627_input_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `s627_input_name` varchar(25) NOT NULL,
  `s627_input_input` text,
  `s627_input_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
	`s627_input_updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verdelers`
--

CREATE TABLE `verdelers` (
  `verdeler_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `verdeler_ingediendDoor` varchar(25) NOT NULL,
  `verdeler_bnx` varchar(40),
  `verdeler_aanvangsDatum` varchar(25),
  `verdeler_aanvangUur` varchar(25),
  `verdeler_eindDatum` varchar(25),
  `verdeler_eindUur` varchar(25),
  `verdeler_lijn` varchar(25),
  `verdeler_spoor` varchar(255),
  `verdeler_kpVan` varchar(7),
  `verdeler_kpTot` varchar(7),
  `verdeler_tpo` varchar(255),
  `verdeler_gevallen` text,
  `verdeler_uiterstePalen` text,
  `verdeler_geplaatstePalen` text,
  `verdeler_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
	`verdeler_updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `verdelers`
--

CREATE TABLE `s460en_input` (
  `s460_input_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `s460_input_melding` varchar(255) NOT NULL,
  `s460_input_verzender` tinyint NOT NULL DEFAULT 0,
  `s460_input_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
	`s460_input_updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `s627en`
--

CREATE TABLE `s460en` (
  `s460_id` int(11) NOT NULL,
  `s460_name` varchar(25) NOT NULL,
  `s460_y` FLOAT(5, 2) NOT NULL,
	`s460_x` FLOAT(5, 2) NOT NULL,
	`s460_w` FLOAT(5, 2),
	`s460_h` FLOAT(5, 2),
	`s460_align` CHAR(1),
	`s460_valign` CHAR(1),
	`s460_border` tinyint(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `s460en` (`s460_id`, `s460_name`, `s460_y`, `s460_x`, `s460_w`, `s460_h`, `s460_align`, `s460_valign`, `s460_border`) VALUES
(1, '1', '40.5', '32.3', null, null, null, null, null),
(2, '2', '109', '32.3', null, null, null, null, null),
(3, '3', '26', '37.5', null, null, null, null, null),
(4, '4', '50.5', '88', null, null, null, null, null),
(5, '5', '78', '88', null, null, null, null, null),
(6, '6', '125.5', '88', null, null, null, null, null),
(7, '7', '174', '171.7', null, null, null, null, null),
(8, '8', '79.2', '37.5', null, null, null, null, null),
(9, '9', '109', '37.5', null, null, null, null, null),
(10, '10', '19.7', '45', '127', '39.7', 'L', 'T', '0'),
(11, '11', '36.5', '119', '127', '39.7', 'L', 'T', '0'),
(12, '12', '36.5', '142', '94', '14', 'L', 'T', '0');

--
-- Tabelstructuur voor tabel `s505en`
--

CREATE TABLE `s505en` (
  `s505_id` int(11) NOT NULL,
  `s505_name` varchar(25) NOT NULL,
  `s505_y` FLOAT(5, 2) NOT NULL,
	`s505_x` FLOAT(5, 2) NOT NULL,
	`s505_w` FLOAT(5, 2),
	`s505_h` FLOAT(5, 2),
	`s505_align` CHAR(1),
	`s505_valign` CHAR(1),
	`s505_border` tinyint(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `s505en` (`s505_id`, `s505_name`, `s505_y`, `s505_x`, `s505_w`, `s505_h`, `s505_align`, `s505_valign`, `s505_border`) VALUES
(1, 'houderS627', 173.00, 42.00, 40.00, 5.00, NULL, NULL, NULL),
(2, 'verantwoordelijkeBss', 227.00, 42.00, 40.00, 5.00, NULL, NULL, NULL),
(3, 'gevallen', 24.50, 50.00, 135.00, 14.00, 'L', 'T', NULL),
(4, 'lijn1', 36.00, 86.00, 20.00, 5.00, NULL, NULL, NULL),
(5, 'spoor1', 66.50, 86.00, 20.00, 5.00, NULL, NULL, NULL),
(6, 'ap1', 97.00, 86.00, 20.00, 5.00, NULL, NULL, NULL),
(7, 'ap2', 130.00, 86.00, 20.00, 5.00, NULL, NULL, NULL),
(8, 'lijn2', 36.00, 90.70, 20.00, 5.00, NULL, NULL, NULL),
(9, 'spoor2', 66.50, 90.70, 20.00, 5.00, NULL, NULL, NULL),
(10, 'ap3', 97.00, 90.70, 20.00, 5.00, NULL, NULL, NULL),
(11, 'ap4', 130.00, 90.70, 20.00, 5.00, NULL, NULL, NULL),
(12, 'tpoBnx', 24.50, 102.00, 135.00, 5.00, NULL, NULL, NULL),
(13, 'eindDatum', 101.00, 134.10, 40.00, 5.00, NULL, NULL, NULL),
(14, 'eindUur', 139.00, 134.10, 40.00, 5.00, NULL, NULL, NULL),
(16, 'gevallen', 24.50, 118.50, 135.00, 10.00, 'L', 'T', NULL),
(17, 'tpoBnx', 24.50, 118.50, 135.00, 5.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `s505en_input`
--

CREATE TABLE `s505en_input` (
  `s505_input_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `s505_input_name` varchar(25) NOT NULL,
  `s505_input_input` text,
  `s505_input_created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
	`s505_input_updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`,`user_id`);

--
-- Indexen voor tabel `resets`
--
ALTER TABLE `resets`
  ADD PRIMARY KEY (`reset_id`,`user_email`),
  ADD UNIQUE KEY `users_email` (`user_email`),
  ADD UNIQUE KEY `token` (`reset_token`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`,`user_email`),
  ADD UNIQUE KEY `email` (`user_email`);

--
-- Indexen voor tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`,`user_id`);

--
-- Indexen voor tabel `s627en`
--
ALTER TABLE `s627en`
  ADD PRIMARY KEY (`s627_id`);

--
-- Indexen voor tabel `s627en_input`
--
ALTER TABLE `s627en_input`
  ADD PRIMARY KEY (`s627_input_id`,`document_id`);

--
-- Indexen voor tabel `verdelers`
--
ALTER TABLE `verdelers`
  ADD PRIMARY KEY (`verdeler_id`,`document_id`);

--
-- Indexen voor tabel `s460`
--
ALTER TABLE `s460en_input`
  ADD PRIMARY KEY (`s460_input_id`,`document_id`);

--
-- Indexen voor tabel `s627en_input`
--
ALTER TABLE `s460en`
  ADD PRIMARY KEY (`s460_id`);

--
-- Indexen voor tabel `s505en`
--
ALTER TABLE `s505en`
  ADD PRIMARY KEY (`s505_id`);

--
-- Indexen voor tabel `s505en_input`
--
ALTER TABLE `s505en_input`
  ADD PRIMARY KEY (`s505_input_id`,`document_id`);
--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `resets`
--
ALTER TABLE `resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `s627en`
--
ALTER TABLE `s627en`
  MODIFY `s627_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `s627en`
--
ALTER TABLE `s627en_input`
  MODIFY `s627_input_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `verdelers`
--
ALTER TABLE `verdelers`
  MODIFY `verdeler_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `s460`
--
ALTER TABLE `s460en_input`
  MODIFY `s460_input_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `s460`
--
ALTER TABLE `s460en`
  MODIFY `s460_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `s505en`
--
ALTER TABLE `s505en`
  MODIFY `s505_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `s505en`
--
ALTER TABLE `s505en_input`
  MODIFY `s505_input_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `resets`
--
ALTER TABLE `resets`
  ADD CONSTRAINT `resets_fk0` FOREIGN KEY (`user_email`) REFERENCES `users` (`user_email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
