-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 01:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id_album` int(10) NOT NULL,
  `nama_album` varchar(255) NOT NULL,
  `artis` varchar(255) NOT NULL,
  `sampul_album` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id_album`, `nama_album`, `artis`, `sampul_album`) VALUES
(28, 'Eternal Sunshine ', 'Ariana Grande', '509de109-c9e2-4496-a6c6-76f442b1a60b.jpg'),
(29, 'Terlintas', 'Bernandya', 'b6172239-b550-4d79-ba59-afa935d166ae.jpg'),
(30, 'Sentimental', 'Juicy Luicy', 'a5807fe7-8f27-49a2-bc35-c0aa395e2099.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id_favorite` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_lagu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id_favorite`, `id_user`, `id_lagu`) VALUES
(10, 10, 31),
(11, 10, 28),
(12, 8, 28);

-- --------------------------------------------------------

--
-- Table structure for table `lagu`
--

CREATE TABLE `lagu` (
  `id_lagu` int(10) NOT NULL,
  `judul_lagu` varchar(255) NOT NULL,
  `tanggal_rilis` date NOT NULL,
  `lirik_lagu` varchar(255) NOT NULL,
  `file_lagu` varchar(255) NOT NULL,
  `id_album` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lagu`
--

INSERT INTO `lagu` (`id_lagu`, `judul_lagu`, `tanggal_rilis`, `lirik_lagu`, `file_lagu`, `id_album`) VALUES
(25, 'Intro (End ofTthe World)', '2023-03-12', 'How can I tell if I\'m in the right relationship? Aren\'t you really supposed to know that shit? Feel it in your bones and own that shit? I don\'t know  Then I had this interaction I\'ve been thinking \'bout for like five weeks Wonder if he\'s thinking \'bout it', 'intro (end of the world).mp3', 28),
(26, 'Eternal Sunshine ', '2024-02-22', 'I don\'t care what people sayWe both know I couldn\'t change youI guess you could say the sameCan\'t rearrange truthI\'ve never seen someone lie like you doSo much, even you start to think it\'s trueOohGet me outta this loop, yeahYeahSo now we play our separat', 'eternal sunshine - live version.mp3', 28),
(27, 'Ordinary Things', '2024-03-12', 'You, thought that I could change But I\'m all the same, girl I\'m all the same You, thought that you could work me out  It\'s just that all these ordinary things, ordinary things Seemed to hunt you, making me wanna dump you Just that all these ordinary thing', 'ordinary things (feat. Nonna).mp3', 28),
(28, 'Satu Bulan', '2024-06-22', 'Belum ada satu bulan Ku yakin masih ada sisa wangiku di bajumu  Namun kau tampak baik saja Bahkan senyummu lebih lepas Sedang aku di sini hampir gila  Kita tak temukan jalan Sepakat akhiri setelah beribu debat panjang  Namun kau tampak baik saja Bahkan se', 'spotifydown.com - Satu Bulan.mp3', 29),
(29, 'Apa Mungkin', '2024-09-09', 'Arungi malam Terjaga kala semua tlah terbenam Berkaca bertanya Apa ku buat salah Kalau pun iya, apa?  Apakah sebesar itu hingga Kau pergi tanpa aba-aba Bahkan tanpa alasan Hingga ku harus menerka-nerka Salahku di mana  Apa mungkin caraku bicara Apa mungki', 'spotifydown.com - Apa Mungkin.mp3', 29),
(30, 'Untungnya, Hidup Harus Tetap Berjalan', '2024-05-05', 'Persis setahun yang lalu Ku dijauhkan dari yang tak ditakdirkan untukku Yang kuingat saat itu Yang kulakukan hanya menggerutu Angkuh  Lebih percaya cara-caraku Pilih ragukan rencana Sang Maha Penentu  Untungnya bumi masih berputar Untungnya ku tak pilih m', 'spotifydown.com - Untungnya, Hidup Harus Tetap Berjalan.mp3', 29),
(31, 'Sialan', '2022-03-12', 'Dari seribu jalan di dunia Mengapa Berpapasan bertemu dia  Inginnya lari pergi tanpa kata Menyapa Sudut mata hafal rupanya  Lupa bahwa lupakannya tak mudah tapi itu senyuman yang ku suka  Sepertinya sama Tatapan khas matanya masih yang lama Kau ajak bicar', 'spotifydown.com - Sialan (1).mp3', 30),
(32, 'Lantas', '2024-09-05', 'Dari seribu jalan di dunia Mengapa Berpapasan bertemu dia  Inginnya lari pergi tanpa kata Menyapa Sudut mata hafal rupanya  Lupa bahwa lupakannya tak mudah tapi itu senyuman yang ku suka  Sepertinya sama Tatapan khas matanya masih yang lama Kau ajak bicar', 'spotifydown.com - Lantas.mp3', 30),
(33, 'Tampar', '2024-06-23', 'Berikut lirik lagu Juicy Luicy:  Entah sudah selasa yang ke berapa Masih saja kau ada, lekat di kepala Hari ini janji esok mesti lupa Tetapi hati tak tepati   Tampar aku di pipi Biar sadar dan kumengerti  Hujan samarkan derasnya, tutup air mata Temani kec', 'spotifydown.com - Tampar.mp3', 30),
(34, 'Lampu Kuning', '2025-05-23', 'Barangkali hujan lebat susah sinyalmu lagi Ku buat sepuluh kemungkinan Tak sampaikah pesan lelah ketiduran Atau memang sengaja kau abaikan   Tapi sepertinya ku melihatmu tadi Dengan kemeja hitam andalan Benar atau bukan Atau hanya dalam pikiran rindu tak ', 'spotifydown.com - Lampu Kuning.mp3', 30);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `name`, `email`, `password`, `foto_user`) VALUES
(8, 'vito', 'vito', 'vito@gmail.com', '$2y$10$VjrzKmtkxHvgOslk4l0hsOME87RL4P4CvhqHJqLVTJWnTOKqpVNeO', 'Instagram_logo_2016.svg.webp'),
(9, 'ade', 'ade', 'ade@gmail.com', '$2y$10$1BjVjDUBplOixiOI6cENs.5Qda4ScC7T6Crm43gS61ijF4lhVIrQG', 'WhatsApp Image 2024-10-28 at 10.05.16 PM (1).jpeg'),
(10, 's', 's', 'ade@gmail.com', '$2y$10$mTgO935BvwlOcZvgHb7nWO4HTEty7CgVxk5ebEFXkLjyPkNObPK2a', '509de109-c9e2-4496-a6c6-76f442b1a60b.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id_album`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id_favorite`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_lagu` (`id_lagu`);

--
-- Indexes for table `lagu`
--
ALTER TABLE `lagu`
  ADD PRIMARY KEY (`id_lagu`),
  ADD KEY `id_album` (`id_album`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id_album` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id_favorite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lagu`
--
ALTER TABLE `lagu`
  MODIFY `id_lagu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`id_lagu`) REFERENCES `lagu` (`id_lagu`);

--
-- Constraints for table `lagu`
--
ALTER TABLE `lagu`
  ADD CONSTRAINT `lagu_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
