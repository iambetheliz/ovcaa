-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2017 at 11:14 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ovcaa`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL DEFAULT 'Uncategorized'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `cat_name`) VALUES
(1, 'article'),
(2, 'category'),
(3, 'news'),
(5, 'feeds'),
(6, 'comments'),
(7, 'newsfeeds'),
(8, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `title` varchar(355) NOT NULL,
  `description` varchar(355) NOT NULL,
  `filename` varchar(355) NOT NULL,
  `filesize` int(11) NOT NULL,
  `location` varchar(355) NOT NULL,
  `url` varchar(355) NOT NULL,
  `uploaded_by` varchar(355) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `title`, `description`, `filename`, `filesize`, `location`, `url`, `uploaded_by`, `date_created`, `date_updated`, `category_id`) VALUES
(1, 'Sample', 'Testing', 'ovcaa.sql', 5, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/ovcaa.sql', 'beth punzalan', '2017-02-23 00:00:00', '2017-02-22 19:06:11', 3),
(2, 'Read Me', 'read', 'pdfurl-guide.pdf', 99, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/pdfurl-guide.pdf', 'beth punzalan', '2017-02-23 00:00:00', '2017-02-23 00:26:12', 1),
(3, 'Sample ulit', 'testing', '793245.jpg', 2477, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/793245.jpg', 'beth punzalan', '2017-02-23 00:00:00', '2017-02-23 01:30:36', 1),
(4, 'Testing', 'Testing lang', 'best-nature-desktop-hd-wallpaper.jpg', 418, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/best-nature-desktop-hd-wallpaper.jpg', 'beth punzalan', '2017-02-23 02:55:36', '2017-02-23 01:55:36', 3),
(5, 'Hey', 'hey', 'picture-nature-18.jpg', 185, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/picture-nature-18.jpg', 'beth punzalan', '2017-02-23 02:56:05', '2017-02-23 01:56:05', 1),
(6, 'kjxkjK', 'KJKLJ', 'rfq_handheld-computer_spmo.pdf', 706, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/rfq_handheld-computer_spmo.pdf', 'beth punzalan', '2017-02-23 02:56:44', '2017-02-23 01:56:44', 2),
(7, 'JOke', 'joke lang', 'sample.txt', 2, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/sample.txt', 'beth punzalan', '2017-02-23 02:57:10', '2017-02-23 01:57:10', 2),
(11, 'New', 'new', 'pdfurl-guide.pdf', 99, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/pdfurl-guide.pdf', 'beth punzalan', '2017-02-23 02:58:52', '2017-02-23 01:58:52', 2),
(12, 'Change', 'change', 'material.php', 2, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/material.php', 'beth punzalan', '2017-02-23 03:01:06', '2017-02-22 19:01:54', 2),
(13, 'try ulit', 'try', 'authoringsoftware.pdf', 106, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/authoringsoftware.pdf', 'beth punzalan', '2017-02-23 03:18:46', '2017-02-22 19:18:46', 1),
(14, 'Notepad++', 'Hello World', 'npp.7.2.1.installer.exe', 2820, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/npp.7.2.1.installer.exe', 'beth punzalan', '2017-02-23 03:31:02', '2017-02-22 21:09:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_uid`, `first_name`, `last_name`, `email`, `gender`, `locale`, `picture`, `link`, `created`, `modified`) VALUES
(1, 'google', '110318400346904643557', 'beth', 'punzalan', 'bethelizganda22@gmail.com', 'female', 'en', 'https://lh3.googleusercontent.com/-m0iT_sgESO0/AAAAAAAAAAI/AAAAAAAAQn4/JEHOrHYLU54/photo.jpg', 'https://plus.google.com/110318400346904643557', '2017-02-09 07:55:13', '2017-02-23 11:05:05'),
(2, 'google', '104521187602522629467', 'Betzy', 'Punzalan', 'iambethpunzalan@gmail.com', 'female', 'en', 'https://lh5.googleusercontent.com/-QyA3yldJkiQ/AAAAAAAAAAI/AAAAAAAAAFc/58jGwxgET7c/photo.jpg', 'https://plus.google.com/104521187602522629467', '2017-02-14 07:56:53', '2017-02-23 07:40:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
