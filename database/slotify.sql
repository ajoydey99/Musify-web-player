-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2019 at 05:16 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slotify`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artworkPath` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES
(1, 'Escape', 3, 2, 'assets/images/artwork/Escape.jpg'),
(2, 'Recovery', 2, 4, 'assets/images/artwork/Recovery.jpg'),
(3, 'All or Nothing', 7, 5, 'assets/images/artwork/allornothing.jpg'),
(4, 'Purpose', 6, 2, 'assets/images/artwork/purpose.jpg'),
(5, 'The Hunting Party', 4, 8, 'assets/images/artwork/thehuntingparty.jpg'),
(7, 'Up All Night', 5, 2, 'assets/images/artwork/upallnight.jpg'),
(8, 'Different World', 8, 7, 'assets/images/artwork/differentworld.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `pics` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `pics`) VALUES
(2, 'Eminem', 'assets/images/artist-pics/eminem.jpg'),
(3, 'Enrique Iglesias', 'assets/images/artist-pics/enrique.jpg'),
(4, 'Linkin Park', 'assets/images/artist-pics/linkinpark.jpg'),
(5, 'One Direction', 'assets/images/artist-pics/onedirection.jpg'),
(6, 'Justin Bieber', 'assets/images/artist-pics/justinbieber.jpg'),
(7, 'Jay Sean', 'assets/images/artist-pics/jaysean.jpg'),
(8, 'Alan Walker', 'assets/images/artist-pics/alanwalker.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Hip-Hop'),
(4, 'Rap'),
(5, 'R & B'),
(6, 'Classical'),
(7, 'Techno'),
(8, 'Hard Rock'),
(9, 'Jazz'),
(10, 'Folk'),
(11, 'Country');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `owner`, `dateCreated`) VALUES
(3, 'total', 'Sammy', '2019-06-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `playlistsongs`
--

CREATE TABLE `playlistsongs` (
  `id` int(11) NOT NULL,
  `songId` int(11) NOT NULL,
  `playlistId` int(11) NOT NULL,
  `playlistOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `playlistsongs`
--

INSERT INTO `playlistsongs` (`id`, `songId`, `playlistId`, `playlistOrder`) VALUES
(6, 16, 3, 4),
(7, 12, 3, 5),
(8, 1, 3, 6),
(9, 4, 3, 7),
(11, 14, 3, 9),
(12, 2, 3, 10),
(14, 17, 3, 11),
(15, 18, 3, 12),
(16, 5, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `albumOrder` int(11) NOT NULL,
  `plays` int(11) NOT NULL,
  `feature` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `albumOrder`, `plays`, `feature`) VALUES
(1, 'So Bad', 2, 2, 4, '5:25', 'assets/music/So-Bad.mp3', 1, 100, NULL),
(2, 'All For Nothing', 4, 5, 8, '3:34', 'assets/music/All-For-Nothing.mp3', 2, 95, 'ft. Page Hamilton'),
(3, 'Escape', 3, 1, 2, '3:28', 'assets/music/Escape.m4a', 3, 162, NULL),
(4, 'I Want', 5, 7, 2, '2:53', 'assets/music/I Want.mp3', 4, 98, NULL),
(5, 'Never Let You Go', 6, 4, 2, '4:24', 'assets/music/Never-Let-You-Go.mp3', 5, 115, NULL),
(7, 'If the World Crashes Down', 3, 1, 2, '4:44', 'assets/music/If-the-World-Crashes-Down.m4a', 6, 59, NULL),
(8, 'All or Nothing', 7, 3, 3, '4:22', 'assets/music/All or Nothing.mp3', 7, 43, NULL),
(9, 'Faded', 8, 8, 7, '3:32', 'assets/music/Faded.mp3', 8, 40, NULL),
(10, 'Hero', 3, 1, 2, '4:24', 'assets/music/Hero.m4a', 9, 57, NULL),
(11, 'I Will Survive', 3, 1, 2, '3:42', 'assets/music/I Will Survive.m4a', 10, 59, NULL),
(12, 'No Pressure', 6, 4, 2, '4:46', 'assets/music/No Pressure.mp3', 11, 21, 'ft. Big Sean'),
(13, 'On My Way', 8, 8, 7, '3:14', 'assets/music/On My Way.mp3', 12, 31, 'ft. Sabrina Carpenter, Farruko'),
(14, 'Everything About You', 5, 7, 2, '3:37', 'assets/music/Everything About You.mp3', 13, 14, NULL),
(15, 'Down', 7, 3, 5, '3:32', 'assets/music/Down.mp3', 14, 33, 'ft. Lil Wayne'),
(16, 'Alone', 8, 8, 7, '2:40', 'assets/music/Alone.mp3', 15, 18, NULL),
(17, 'Lily', 8, 8, 7, '3:15', 'assets/music/Lily.mp3', 16, 7, 'ft. K-391, Emelie Hollow'),
(18, 'Sorry', 6, 4, 2, '3:20', 'assets/music/Sorry.mp3', 17, 1, NULL),
(19, 'Not Afraid', 2, 2, 4, '4:11', 'assets/music/Not Afraid.mp3', 18, 4, NULL),
(20, 'Tell Me A Lie', 5, 7, 2, '3:17', 'assets/music/Tell Me A Lie.mp3', 19, 2, NULL),
(21, 'War', 7, 3, 5, '3:45', 'assets/music/War.mp3', 20, 4, NULL),
(22, 'Up All Night', 5, 7, 2, '3:14', 'assets/music/Up All Night.mp3', 21, 2, NULL),
(23, 'Love The Way You Lie', 2, 2, 4, '4:23', 'assets/music/Love The Way You Lie.mp3', 22, 2, 'ft. Rihana');

-- --------------------------------------------------------

--
-- Table structure for table `userphotos`
--

CREATE TABLE `userphotos` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `imagePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signUpDate` datetime NOT NULL,
  `profilePic` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `signUpDate`, `profilePic`) VALUES
(2, 'Sammy', 'Sam', 'Niar', 'samniar040@gmail.com', '85b24601e1bd61c54a6cf800bbb83cdd', '2019-06-02 00:00:00', 'assets/images/profile-pics/head_emerald.png'),
(4, 'ajoy456', 'Ajoy', 'Dey', 'samniar88@gmail.com', '6267dd03247c77df0d8e37e77b515f14', '2019-06-26 00:00:00', 'assets/images/profile-pics/head_emerald.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistsongs`
--
ALTER TABLE `playlistsongs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userphotos`
--
ALTER TABLE `userphotos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `playlistsongs`
--
ALTER TABLE `playlistsongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `userphotos`
--
ALTER TABLE `userphotos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
