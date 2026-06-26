-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 10, 2026 at 02:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `WorldCultureShow`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `email`, `bio`, `reset_token`, `token_expiry`, `password`, `created_at`) VALUES
(1, 'Meseret', 'messigachena2@gmail.com', 'UOG STUDENT ', 'e6ca8dbe6aa6b0982a6efff908f5db0f076e3d6fc1ec1f2551bb7263811ee1a8', NULL, '$2y$10$tFpQqp.29/NnK6YR0klp8ubCkfdh9h92mSeTlLc0vRravGah3n4ju', '2025-12-05 00:00:23'),
(2, 'Alex Josh', 'alex@gmail.com', 'Cultural dancer...', NULL, NULL, '$2y$10$k93Y.IyY9jJ0SNdvUG.9ze4ac7B5da9P19bNuJSSTETN3ePyW0laS', '2025-11-26 12:24:10'),
(3, 'Maria', 'maria@gmail.com', 'Writer & editorccsvsvs', NULL, NULL, NULL, '2025-11-26 12:25:36'),
(5, 'Sophie', 'sophie@gmail.com', 'Author of lifestyle articles', NULL, NULL, NULL, '2025-11-26 12:25:36'),
(7, 'Dian', 'dan@gmail.com', 'British Cultural show', NULL, NULL, NULL, '2025-11-26 14:55:14'),
(10, 'Hanna', 'hanna@gmail.com', 'Cooking cultural food', NULL, NULL, 'Hanna123', '2025-12-04 09:47:57'),
(13, 'ayran', 'ayran@gmail.com', 'sas', NULL, NULL, '$2y$10$IewE/CpZclA6vTgKxvYTIOL2GVnGrKiZdBW4lf.hiL5vJ6N7muQNO', '2025-12-05 00:03:00'),
(14, 'Eliyas', 'eliyas@gmail.com', 'Cultural blog', NULL, NULL, 'eliyas123', '2025-12-08 12:40:01'),
(15, 'Yosef Urga', 'yosef@gmail.com', 'student ', NULL, NULL, 'yosef123', '2025-12-09 10:15:14'),
(16, 'sheren', 'sheren@gmail.com', 'none', NULL, NULL, 'sheren123', '2025-12-09 11:19:25'),
(18, 'Test', 'test@aol.com', 'Alfie', NULL, NULL, '12345678', '2025-12-09 18:57:23'),
(19, 'mes ', 'mesi@gre.ac.uk', '', NULL, NULL, '$2y$10$WddpA7jym1vSSG2GPef0g..6Lv4JV6vQOwKywXT7VMi./mANC1ltC', NULL),
(20, 'mes ', 'md@gre.ac.uk', 'student', '1cb6a601bed68cbea09dd25b8d3c6dfdbef481842d988d0b4a4a3562d648a0a8', NULL, '$2y$10$dvtKNaxxiNw9sHvBgV7nLu8ifWDxZnrXQU9jYJZUwyDkPs9me4AUa', NULL),
(21, 'mes ', 'mg@gre.ac.uk', '', NULL, NULL, '$2y$10$aPrfoCZ8nPp6QoMCWfEYOOdGZlzmdFnb7c.qKRWK2KwuWhgW1pMiy', NULL),
(23, 'Mesi', 'ms@gre.ac.uk', 'messi', NULL, NULL, NULL, NULL),
(24, 'John', 'john@gmail.com', 'stndt', NULL, NULL, '$2y$10$Ai8U7YYdtRvt4Dd/z5Ag3ODfnUUnecp910LymkqnKPvOrCF9FcL52', NULL),
(25, 'Dan', 'dan2@gmail.com', 'nothing ', NULL, NULL, '$2y$10$WGHgwcjE8LnBVwADzqmKWur73HxC8akYUuwp.7MS.AzGzG4Ef3mwi', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'General', 'General blog posts category.', '2025-11-12 19:52:56'),
(4, 'Ethiopian Oromo culture ', 'Ethiopian General Culture', '2025-11-26 14:21:05'),
(5, 'Indian Culture ', 'indian ', '2025-11-26 14:21:20'),
(10, 'Jmaican', 'jamaical culture', '2025-12-05 00:04:31'),
(25, 'All Cultures', 'Worldwide cultural content', '2025-12-08 11:46:25'),
(26, 'Ethiopian Oromo Culture (Irreecha)', 'Oromo people traditions and the Irreecha thanksgiving festival', '2025-12-08 11:46:25'),
(27, 'English Culture (UK)', 'Traditions and customs from England and the United Kingdom', '2025-12-08 11:46:25'),
(28, 'Caribbean Carnival', 'Caribbean culture, festivals, dance, food and Carnival celebrations', '2025-12-08 11:46:25'),
(29, 'Chinese New Year', 'Chinese Lunar New Year traditions, festivals, and celebrations', '2025-12-08 11:46:25'),
(30, 'Asian Culture', 'Cultural traditions from East, South, and Southeast Asia', '2025-12-08 11:46:25'),
(31, 'African Culture', 'Traditional and modern cultures from across Africa', '2025-12-08 11:46:25'),
(32, 'European Culture', 'Traditions and heritage from European countries', '2025-12-08 11:46:25'),
(33, 'Latin American Culture', 'Cultures from Central and South America', '2025-12-08 11:46:25'),
(34, 'Middle Eastern Culture', 'Traditions from Arab countries, Persia, and surrounding regions', '2025-12-08 11:46:25'),
(35, 'North American Culture', 'Cultural traditions from the USA and Canada', '2025-12-08 11:46:25'),
(36, 'Australian & Indigenous Culture', 'Culture from Australia including Aboriginal heritage', '2025-12-08 11:46:25'),
(37, 'All Cultural', '', '2025-12-09 10:18:11'),
(39, 'Additional Culture ', 'Worldwide cultural food ', NULL),
(43, 'World Culture ', 'world culture show ', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `author_name` varchar(100) DEFAULT NULL,
  `body` text NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `author_id`, `author_name`, `body`, `created_at`) VALUES
(8, 3, 3, 'hanna', 'good post', '2025-12-02 23:39:15'),
(15, 35, 21, 'almi', 'Awesome', '2025-12-18 20:24:11'),
(16, 39, 20, 'mes ', 'dedede', '2026-02-24 02:26:22'),
(17, 39, 20, 'mes ', 'dedede', '2026-02-24 02:28:45'),
(18, 39, 20, 'mes ', 'frferfre', '2026-02-24 02:29:08'),
(21, 38, 20, 'mes ', 'hello there ', '2026-02-24 02:34:23'),
(22, 38, 20, 'mes ', 'edit test', '2026-02-24 02:46:04'),
(23, 38, 20, 'mes ', 'yess', '2026-02-24 02:46:19'),
(24, 39, 20, 'mes ', 'nvhvkh', '2026-02-24 18:58:06'),
(25, 33, 20, 'mes ', 'njj', '2026-02-24 19:43:26'),
(31, 3, 20, 'mes ', 'b', '2026-02-25 00:11:28'),
(32, 23, 20, 'mes ', 'jh', '2026-02-25 00:11:44'),
(33, 50, 20, 'mes ', 'jvhjvhj', '2026-02-27 20:51:57'),
(34, 50, 20, 'mes ', 'jvhjvhj', '2026-02-27 20:56:32'),
(35, 50, 20, 'mes ', 'jvhjvhj', '2026-02-27 20:56:39'),
(36, 53, 20, 'mes ', 'hjhg', '2026-03-02 13:59:08'),
(37, 53, 1, 'Meseret', 'good \r\n', '2026-03-08 15:14:18'),
(38, 46, 1, 'Meseret', 'test comment', '2026-03-08 15:33:49'),
(39, 46, 1, 'Meseret', 'test comment', '2026-03-08 15:41:12'),
(40, 53, 1, 'Meseret', 'nice yes', '2026-03-08 15:41:32'),
(41, 46, 1, 'Meseret', 'Test', '2026-03-08 15:43:29'),
(42, 46, 1, 'Meseret', 'Test', '2026-03-08 15:49:14'),
(43, 46, 1, 'Meseret', 'test', '2026-03-08 15:49:33'),
(44, 53, 20, 'mes ', 'test3', '2026-03-08 16:00:59'),
(45, 53, 20, 'mes ', 'test', '2026-03-08 16:02:05'),
(46, 53, 20, 'mes ', 'test', '2026-03-08 16:02:09'),
(47, 55, 20, 'mes ', 'Hello Meseret', '2026-03-08 16:03:47'),
(48, 55, 20, 'mes ', 'Hello ', '2026-03-08 16:05:17'),
(49, 46, 1, 'Meseret', 'need com', '2026-03-08 16:32:20'),
(50, 55, 1, 'Meseret', 'need com', '2026-03-08 16:39:52'),
(51, 55, 1, 'Meseret', 'new test comment', '2026-03-08 17:11:58'),
(52, 31, 24, 'John', 'super man', '2026-03-08 18:37:46'),
(53, 19, 24, 'John', 'yeah', '2026-03-08 19:51:12'),
(54, 56, 1, 'Meseret', 'Test comment', '2026-03-08 20:51:43'),
(55, 56, 25, 'Dan', 'look good ', '2026-03-09 12:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Meseret Dirisa', 'messigachena2@gmail.com', 'hello', '2025-11-13 11:00:12'),
(2, 'Meseret Dirisa', 'messigachena2@gmail.com', 'hello ', '2025-11-26 12:52:50'),
(3, 'meseret', 'mesigachena1@gmail.com', 'hello', '2025-12-02 14:33:11'),
(4, 'Helen', 'helen@gmail.com', 'Hey there!', '2025-12-04 09:56:09'),
(5, 'yosef', 'yosef@gmail.com', 'hey there', '2025-12-09 11:02:53'),
(6, 'Messi', 'md3744r@gre.ac.uk', 'test', '2025-12-09 12:38:34'),
(7, 'mes', 'md3744r@gre.ac.uk', 'test', '2025-12-09 13:59:39'),
(8, 'mes', 'md3744r@gre.ac.uk', 'test', '2025-12-09 14:01:05'),
(9, 'mes', 'messigachena2@gmail.com', 'test', '2025-12-09 14:30:55'),
(10, 'mes', 'messigachena2@gmail.com', 'test', '2025-12-09 14:31:07'),
(11, 'mes', 'messigachena2@gmail.com', 'test', '2025-12-09 14:40:12'),
(12, 'mes', 'messigachena2@gmail.com', 'test', '2025-12-09 14:40:16'),
(13, 'mes', 'messigachena2@gmail.com', 'test 5', '2025-12-09 14:57:41'),
(14, 'Meseret G Dirisa', 'md3744r@gre.ac.uk', 'test6', '2025-12-09 14:59:24'),
(15, 'Meseret G Dirisa', 'md3744r@gre.ac.uk', 'test6', '2025-12-09 14:59:29'),
(16, 'Meseret G Dirisa', 'md3744r@gre.ac.uk', 'test6', '2025-12-09 14:59:35'),
(17, 'm', 'md3744r@gre.ac.uk', 'test6', '2025-12-09 15:00:27'),
(18, 'm', 'md3744r@gre.ac.uk', 'test6', '2025-12-09 15:03:55'),
(19, 'm', 'md3744r@gre.ac.uk', 'test7', '2025-12-09 16:50:23'),
(20, 'm', 'md3744r@gre.ac.uk', 'test7', '2025-12-09 17:02:40'),
(21, 'messi', 'md3744r@gre.ac.uk', 'test', '2025-12-09 18:11:17'),
(22, 'messi', 'md3744r@gre.ac.uk', 'test', '2025-12-09 18:16:17'),
(23, 'mes', 'md3744r@gre.ac.uk', 'test', '2025-12-09 18:23:04'),
(24, 'mes', 'messigachena2@gmail.com', 'testttt', '2025-12-09 22:13:03'),
(25, 'mes', 'messigachena2@gmail.com', 'testttt', '2025-12-09 22:13:51'),
(26, 'Meseret', 'mesigachena1@gmail.com', 'Test for contact submission', NULL),
(27, 'Meseret', 'messigachena2@gmail.com', 'Test for contact submission', NULL),
(28, 'Meseret', 'messigachena2@gmail.com', 'Test for Contact', NULL),
(29, 'Meseret Dirisa', 'messigachena2@gmail.com', 'hello', '2026-02-24 02:12:36'),
(30, 'Meseret Dirisa', 'messigachena2@gmail.com', 'heloo', '2026-02-25 01:59:12'),
(31, 'mesi', 'mesigachena1@gmail.com', 'new test', '2026-02-25 01:59:46'),
(32, 'Meseret Dirisa', 'mesigachena1@gmail.com', 'Hello Test 22', '2026-03-02 11:48:05'),
(33, 'Meseret Dirisa', 'mesigachena1@gmail.com', 'Hello Test 22', '2026-03-02 11:51:59'),
(34, 'messi', 'worldcultureshow2026@gmail.com', 'Test2026', '2026-03-02 12:31:48'),
(35, 'messi', 'worldcultureshow2026@gmail.com', 'Test2026', '2026-03-02 12:34:34'),
(36, 'Meseret', 'mesigachena1@gmail.com', 'Test2026', '2026-03-02 12:34:53'),
(37, 'Meseret Dirisa', 'messigachena2@gmail.com', 'QUA', '2026-03-08 14:31:05'),
(38, 'Meseret Dirisa', 'messigachena2@gmail.com', 'QUA', '2026-03-08 14:36:05'),
(39, 'Meseret Dirisa', 'messigachena2@gmail.com', 'IQ', '2026-03-08 14:38:10'),
(40, 'Meseret Dirisa', 'messigachena2@gmail.com', 'hello', '2026-03-08 15:15:19'),
(41, 'Meseret Dirisa', 'messigachena2@gmail.com', 'Meeting', '2026-03-08 18:08:29'),
(42, 'Meseret Dirisa', 'messigachena2@gmail.com', 'Meeting', '2026-03-08 18:13:29'),
(43, 'Meseret Dirisa', 'messigachena2@gmail.com', 'Hello', '2026-03-09 12:36:43'),
(44, 'Meseret Dirisa', 'messigachena2@gmail.com', 'Test 3', '2026-03-09 12:51:41'),
(45, 'mes', 'md@gre.ac.uk', 'Test4', '2026-03-09 12:53:39');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `post_date` date DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `body`, `image`, `alt_text`, `post_date`, `author_id`, `category_id`) VALUES
(3, 'Carnival', 'carnival', '6938b12a710cb.jpg', NULL, '2025-11-25', 1, 10),
(9, 'Ent', 'heloooo', '692f81a9413c1.jpeg', NULL, '2025-12-03', 1, 4),
(10, 'Culture', 'cultral show', '692f81dd35331.jpeg', NULL, '2025-12-03', 1, NULL),
(17, 'cscsxc', 'csdsvdsvd', '6931bcbd0f459.jpeg', NULL, '2025-12-04', 1, NULL),
(19, 'Ethiopian Food', 'oromo', '6932351e91669.jpeg', NULL, '2025-12-04', 10, 1),
(22, 'English breakfast Tea', 'English breakfast Tea,', '6936c2e1b7da1.jpg', NULL, '2025-12-08', 1, 27),
(23, 'English breakfast', 'English breakfast', '6936c2e1b8f02.jpg', NULL, '2025-12-08', 1, 27),
(26, 'Christmass', 'London christmass', '6938017ed7f7b.jpg', NULL, '2025-12-09', 15, 37),
(27, 'Asian Culture', 'Vitnmen', '69380684cc586.jpg', NULL, '2025-12-09', 16, 30),
(31, 'UK culture', 'Scottish singer', '6943558770080.jpg', NULL, '2025-12-09', 1, 27),
(32, 'hjdgasfhjsafghs', 'safsafdsgfdsg', '69388fc0ec4d9.jpg', NULL, '2025-12-09', 1, 25),
(33, 'African Cuture', 'african', '6938b03321d9e.jpg', NULL, '2025-12-09', 1, 31),
(34, 'Chines new year', 'Chinese New Year\'s Eve', '694351f33aee2.jpg', NULL, '2025-12-18', 1, 29),
(35, 'Chinese  New Year', 'Chinese New Year festivals', '694351a786603.jpg', 'chines', '2025-12-18', 1, 29),
(36, 'Christmass Eve', 'Christmas eve in London.', '695190541dc28.mp4', NULL, '2025-12-28', 1, 25),
(38, 'London New year Eve', 'New Year\'s Eve 2026 in London.', '69571cfaae288.mp4', NULL, '2026-01-02', 1, 37),
(39, 'Cultural', 'Jkadjhskdjsdsjh', '69aeb78b294c5-Budapest, Matthias church, Hungary image.jpg', '', '2026-01-27', 1, 37),
(46, 'Ethiopian Coffee', 'Ethioafrica', '699e22ff49027-coffee-549630_1280 ethiopia .jpg', '', '2026-02-24', 20, 31),
(50, 'dsggrg', 'gsggeg', '699e5506a7c48-Asianboys-1793421_1280.jpg', '', '2026-02-25', 20, 39),
(53, 'Chines culture ', 'Asian, chines culture ', '69a5898ac72ae-chiness new year tradition.jpg', '', '2026-03-02', 20, 29),
(55, 'New year ', 'New year post ', '69ad9f9095110-istockphoto-626671384-640_adpp_is.mp4', '', '2026-03-08', 1, 27),
(56, 'International ', 'International culture view ', '69adb2b76ad28-nigerian food .jpg', '', '2026-03-08', 24, 37);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_posts` (`post_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_posts_authors` (`author_id`),
  ADD KEY `fk_posts_categories` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_authors` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posts_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
