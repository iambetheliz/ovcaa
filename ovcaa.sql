-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2017 at 04:06 AM
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
(20, 'class'),
(17, 'comments'),
(13, 'feeds'),
(12, 'news'),
(19, 'newsfeeds');

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
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `title`, `description`, `filename`, `filesize`, `location`, `url`, `uploaded_by`, `date_created`, `date_updated`, `category_id`) VALUES
(6, 'Sample', 'Sample lang', 'tab-contents--and-links-for-website.docx', 18, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/tab-contents--and-links-for-website.docx', 'beth punzalan', '2017-03-15 07:25:49', '2017-03-15 07:25:49', 1),
(7, 'Testing', 'Testing lang', 'dtr.xls', 147, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/dtr.xls', 'admin', '2017-03-16 05:57:59', '2017-03-16 05:57:59', 2),
(8, 'Trial', 'Trial and Error', 'tab-contents--and-links-for-website.docx', 18, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/tab-contents--and-links-for-website.docx', 'admin', '2017-03-16 05:59:08', '2017-03-16 05:59:08', 2),
(9, 'Hey', 'Hey', 'rfq-printer-ovcfa.pdf', 394, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/rfq-printer-ovcfa.pdf', 'admin', '2017-03-16 06:24:56', '2017-03-16 06:24:56', 1),
(10, 'Yow', 'You', 'rfq-printers-our.pdf', 1008, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/rfq-printers-our.pdf', 'admin', '2017-03-16 06:31:50', '2017-03-16 06:31:50', 1),
(11, 'Love', 'Love story', 'tab-contents--and-links-for-website.docx', 18, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/tab-contents--and-links-for-website.docx', 'admin', '2017-03-16 06:36:18', '2017-03-16 06:36:18', 2),
(12, 'Oi', 'Oi', 'rfq_handheld-computer_spmo.pdf', 705, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/rfq_handheld-computer_spmo.pdf', 'admin', '2017-03-16 06:37:52', '2017-03-16 06:37:52', 1),
(13, 'Title', 'Title', 'tab-contents--and-links-for-website.docx', 18, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/tab-contents--and-links-for-website.docx', 'admin', '2017-03-16 06:40:16', '2017-03-16 06:40:16', 1),
(14, 'Success', 'Successful', 'tab-contents--and-links-for-website.docx', 18, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/tab-contents--and-links-for-website.docx', 'admin', '2017-03-16 06:41:33', '2017-03-16 06:41:33', 2),
(15, 'Error', 'Error', 'rfq-printer-ovcfa.pdf', 394, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/rfq-printer-ovcfa.pdf', 'admin', '2017-03-16 06:42:58', '2017-03-16 06:42:58', 1),
(16, 'Sample 2', 'SAmple', 'rfq-printer-ovcfa.pdf', 394, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/rfq-printer-ovcfa.pdf', 'admin', '2017-03-16 07:56:05', '2017-03-16 07:56:05', 1),
(17, 'Sample text', 'Sample', 'sample.txt', 0, '/ovcaa/administrator/uploads/', 'http://localhost/ovcaa/administrator/uploads/sample.txt', 'admin', '2017-03-17 02:22:32', '2017-03-17 02:22:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `userId` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `userName` varchar(30) NOT NULL,
  `userEmail` varchar(60) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `regDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`userId`, `first_name`, `last_name`, `userName`, `userEmail`, `userPass`, `regDate`) VALUES
(1, 'beth', 'punzalan', 'admin', 'admin@gmail.com', '41e5653fc7aeb894026d6bb7b2db7f65902b454945fa8fd65a6327047b5277fb', '2017-02-23 00:21:28');

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
(1, 'google', '110318400346904643557', 'beth', 'punzalan', 'bethelizganda22@gmail.com', 'female', 'en', 'https://lh3.googleusercontent.com/-m0iT_sgESO0/AAAAAAAAAAI/AAAAAAAAQn4/JEHOrHYLU54/photo.jpg', 'https://plus.google.com/110318400346904643557', '2017-03-07 04:11:28', '2017-03-15 10:53:57'),
(2, 'google', '104521187602522629467', 'Betzy', 'Punzalan', 'iambethpunzalan@gmail.com', 'female', 'en', 'https://lh5.googleusercontent.com/-QyA3yldJkiQ/AAAAAAAAAAI/AAAAAAAAAFc/58jGwxgET7c/photo.jpg', 'https://plus.google.com/104521187602522629467', '2017-03-07 04:59:58', '2017-03-07 05:45:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `cat_name` (`cat_name`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
