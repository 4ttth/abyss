-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 29, 2025 at 04:40 PM
-- Server version: 10.11.11-MariaDB-0+deb12u1
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mlofficial_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_adminaccount`
--

CREATE TABLE `tbl_adminaccount` (
  `Admin_ID` int(11) NOT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_adminaccount`
--

INSERT INTO `tbl_adminaccount` (`Admin_ID`, `Email_Address`, `Password`) VALUES
(1, 'selwyn', 'Kim0yerim');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_notes`
--

CREATE TABLE `tbl_admin_notes` (
  `Note_ID` int(11) NOT NULL,
  `Admin_ID` int(11) DEFAULT NULL,
  `Subject` varchar(255) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_notes`
--

INSERT INTO `tbl_admin_notes` (`Note_ID`, `Admin_ID`, `Subject`, `Message`, `Created_At`) VALUES
(1, 18, 'Moderator Management', 'Test', '2025-04-07 19:05:52'),
(2, 18, 'Test', 'Test', '2025-04-07 19:07:20'),
(3, 18, 'Test', 'Test', '2025-04-08 06:10:44'),
(4, 18, 'Test', 'Test', '2025-04-08 06:38:55'),
(5, 18, 'Test', 'Test', '2025-04-08 08:53:50'),
(6, 18, 'Test', 'Test', '2025-04-09 05:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_auditlogs`
--

CREATE TABLE `tbl_auditlogs` (
  `Audit_ID` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Action` varchar(100) DEFAULT NULL,
  `Moderator_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_carousels`
--

CREATE TABLE `tbl_carousels` (
  `Carousel_ID` int(11) NOT NULL,
  `Image1` varchar(255) DEFAULT NULL,
  `Image2` varchar(255) DEFAULT NULL,
  `Image3` varchar(255) DEFAULT NULL,
  `Show_Status` varchar(10) DEFAULT 'Hidden',
  `Created_At` timestamp NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_carousels`
--

INSERT INTO `tbl_carousels` (`Carousel_ID`, `Image1`, `Image2`, `Image3`, `Show_Status`, `Created_At`, `Updated_At`) VALUES
(1, NULL, NULL, NULL, 'Hidden', '2025-04-28 14:56:40', '2025-04-28 15:27:20'),
(2, '../uploads/carousels/Elina (22).png', '../uploads/carousels/IMG_7496.png', '../uploads/carousels/IMG_6602.png', 'Hidden', '2025-04-28 15:02:03', '2025-04-28 16:25:20'),
(3, '../uploads/carousels/1.jpg', '../uploads/carousels/2.jpg', '../uploads/carousels/3.jpg', 'Shown', '2025-04-28 15:33:35', '2025-04-28 16:25:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contentmanagement`
--

CREATE TABLE `tbl_contentmanagement` (
  `Content_ID` int(11) NOT NULL,
  `Event_Name` varchar(255) DEFAULT NULL,
  `Event_Duration` text DEFAULT NULL,
  `Event_Details` text DEFAULT NULL,
  `Promotional_Content` varchar(255) DEFAULT NULL COMMENT 'Path IMG Displayed',
  `Youtube_Link` varchar(255) DEFAULT NULL,
  `Youtube_Banner` varchar(255) DEFAULT NULL COMMENT 'Path IMG Displayed',
  `Advertisement_Link` varchar(255) DEFAULT NULL,
  `Advertisement_Banner` varchar(255) DEFAULT NULL COMMENT 'Path IMG Displayed',
  `Is_Displayed` tinyint(1) DEFAULT NULL COMMENT 'Boolean (Yes/No)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contentmanagement`
--

INSERT INTO `tbl_contentmanagement` (`Content_ID`, `Event_Name`, `Event_Duration`, `Event_Details`, `Promotional_Content`, `Youtube_Link`, `Youtube_Banner`, `Advertisement_Link`, `Advertisement_Banner`, `Is_Displayed`) VALUES
(1, 'KISHIN DENSETU', 'draw event will be available on 02/03/2025', 'Obtain event-exclusive items such as Chat Bubble and more!', '../uploads/content/Untitled design.png.PNG', 'https://www.youtube.com/watch?v=aYlB6u7YOWQ', '../uploads/content/youtubeLink.zip - 2.JPG', 'https://play.google.com/store/apps/details?id=com.hhgame.mlbbvn&hl=en-US&pli=1', 'IMG/essentials/advertisement.png', 1),
(2, 'SQUAD BATTLE ROYALE', 'event available from 01/06/2025 to 01/07/2025', 'Team-based strategy battle with rewards for top performers.', 'Join your squad and fight for the championship title with exclusive in-game items.', 'https://www.youtube.com/watch?v=zFgB6gT-KYQ', '../IMG/essentials/youtubeLink3.png', 'https://www.example.com', '../IMG/essentials/advertisement2.png', 0),
(3, 'NEW SEASON LAUNCH', 'starting on 10/05/2025', 'Welcome the new season with updates, skins, and exciting challenges.', 'Seasonal content with exclusive rewards for new season champions.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '../IMG/essentials/youtubeLink4.png', 'https://www.storelink.com', '../IMG/essentials/advertisement3.png', 0),
(4, 'EXCLUSIVE OFFERS', 'special offers until 15/05/2025', 'Enjoy discounts and bonus items in this special limited-time event.', 'Get premium content at discounted rates for a limited time!', 'https://www.youtube.com/watch?v=nNfiVmDDYc0', '../IMG/essentials/youtubeLink5.png', 'https://www.deals.com', '../IMG/essentials/advertisement4.png', 0),
(10, 'Test', 'Test', 'Test', '../uploads/content/Untitled design.png.PNG', 'file:///C:/Users/pauli/Downloads/Development-of-a-Dynamic-Web-Based-Scrimmage-Management-Platform-for-Mobile-Legends-Communities-to-Foster-Competitive-Gaming-and-Squad-Networking-1-1-2%20(1).pdf', '../uploads/content/youtubeLink.zip - 2.JPG', 'file:///C:/Users/pauli/Downloads/Development-of-a-Dynamic-Web-Based-Scrimmage-Management-Platform-for-Mobile-Legends-Communities-to-Foster-Competitive-Gaming-and-Squad-Networking-1-1-2%20(1).pdf', '../uploads/content/youtubeLink.zip - 2.JPG', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_conversations`
--

CREATE TABLE `tbl_conversations` (
  `Conversation_ID` int(11) NOT NULL,
  `Squad1_ID` int(255) DEFAULT NULL,
  `Squad2_ID` int(255) DEFAULT NULL,
  `Last_Message_ID` int(11) DEFAULT NULL,
  `Last_Message_Time` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Updated_At` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Squad1_Unread` int(11) DEFAULT 0,
  `Squad2_Unread` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_conversations`
--

INSERT INTO `tbl_conversations` (`Conversation_ID`, `Squad1_ID`, `Squad2_ID`, `Last_Message_ID`, `Last_Message_Time`, `Updated_At`, `Squad1_Unread`, `Squad2_Unread`) VALUES
(1, 72997, 28670, 16, '2025-04-10 06:23:19', '2025-04-10 06:23:19', 5, 0),
(2, 96990, 28670, 17, '2025-04-10 06:23:29', '2025-04-10 06:23:29', 3, 0),
(3, 55548, 28670, 19, '2025-04-10 06:38:22', '2025-04-10 06:38:22', 0, 1),
(4, 53932, 55548, 21, '2025-04-10 13:10:23', '2025-04-10 13:10:23', 0, 0),
(5, 55548, 53932, NULL, NULL, '2025-04-10 07:03:41', 0, 0),
(6, 43844, 28670, 24, '2025-04-10 09:36:53', '2025-04-10 09:36:53', 0, 1),
(7, 53932, 55548, 25, '2025-04-10 17:39:13', '2025-04-10 17:39:13', 1, 1),
(8, 55548, 28670, 26, '2025-04-10 18:51:27', '2025-04-10 18:51:27', 1, 1),
(9, 28670, 55548, 27, '2025-04-10 19:15:44', '2025-04-10 19:15:44', 1, 1),
(10, 28670, 55548, 28, '2025-04-10 19:20:19', '2025-04-10 19:20:19', 1, 1),
(11, 28670, 55548, 29, '2025-04-10 19:20:22', '2025-04-10 19:20:22', 1, 1),
(12, 28670, 55548, 30, '2025-04-10 19:20:25', '2025-04-10 19:20:25', 1, 1),
(13, 43844, 55548, 31, '2025-04-10 19:36:44', '2025-04-10 19:36:44', 1, 1),
(14, 28670, 55548, 32, '2025-04-10 19:43:17', '2025-04-10 19:43:17', 1, 1),
(15, 55548, 28670, 33, '2025-04-23 10:20:00', '2025-04-23 10:20:00', 1, 1),
(16, 55548, 28670, 34, '2025-04-23 10:20:08', '2025-04-23 10:20:08', 1, 1),
(17, 99569, 28670, 35, '2025-04-23 10:21:57', '2025-04-23 10:21:57', 1, 1),
(18, 99569, 28670, 36, '2025-04-23 10:21:59', '2025-04-23 10:21:59', 1, 1),
(19, 28670, 99569, 37, '2025-04-23 11:07:06', '2025-04-23 11:07:06', 1, 1),
(20, 28670, 99569, 38, '2025-04-28 16:52:09', '2025-04-28 16:52:09', 0, 1),
(21, 28670, 99569, 39, '2025-04-23 11:22:07', '2025-04-23 11:22:07', 1, 1),
(22, 28670, 99569, 40, '2025-04-23 11:22:12', '2025-04-23 11:22:12', 1, 1),
(23, 28670, 99569, 41, '2025-04-28 16:52:08', '2025-04-28 16:52:08', 0, 1),
(24, 99569, 28670, 42, '2025-04-28 16:52:07', '2025-04-28 16:52:07', 1, 0),
(25, 99569, 28670, 43, '2025-04-23 11:37:47', '2025-04-23 11:37:47', 1, 1),
(26, 99569, 28670, 44, '2025-04-28 16:24:14', '2025-04-28 16:24:14', 1, 0),
(27, 28670, 99569, 45, '2025-04-28 16:24:14', '2025-04-28 16:24:14', 0, 1),
(28, 28670, 99569, 46, '2025-04-28 16:24:07', '2025-04-28 16:24:07', 0, 1),
(29, 54124, 58871, 47, '2025-04-23 17:29:48', '2025-04-23 17:29:48', 1, 1),
(30, 54124, 58871, 48, '2025-04-23 17:29:50', '2025-04-23 17:29:50', 1, 1),
(31, 54124, 58871, 49, '2025-04-23 17:29:52', '2025-04-23 17:29:52', 1, 1),
(32, 58871, 54124, 50, '2025-04-23 17:56:36', '2025-04-23 17:56:36', 1, 1),
(33, 58871, 54124, 51, '2025-04-23 17:56:38', '2025-04-23 17:56:38', 1, 1),
(34, 58871, 54124, 52, '2025-04-23 17:56:40', '2025-04-23 17:56:40', 1, 1),
(35, 58871, 54124, 53, '2025-04-23 18:18:48', '2025-04-23 18:18:48', 1, 1),
(36, 58871, 54124, 54, '2025-04-23 18:55:57', '2025-04-23 18:55:57', 1, 1),
(37, 58871, 54124, 55, '2025-04-23 19:06:31', '2025-04-23 19:06:31', 1, 1),
(38, 54124, 58871, 56, '2025-04-23 19:13:02', '2025-04-23 19:13:02', 1, 1),
(39, 54124, 58871, 57, '2025-04-23 19:16:18', '2025-04-23 19:16:18', 1, 1),
(40, 54124, 58871, 58, '2025-04-23 19:23:35', '2025-04-23 19:23:35', 1, 1),
(41, 54124, 58871, 59, '2025-04-23 19:37:42', '2025-04-23 19:37:42', 1, 1),
(42, 54124, 58871, 60, '2025-04-23 19:37:43', '2025-04-23 19:37:43', 1, 1),
(43, 58871, 54124, 61, '2025-04-23 20:05:30', '2025-04-23 20:05:30', 1, 1),
(44, 58871, 54124, 62, '2025-04-23 21:08:56', '2025-04-23 21:08:56', 1, 1),
(45, 58871, 54124, 63, '2025-04-23 21:18:46', '2025-04-23 21:18:46', 1, 1),
(46, 58871, 54124, 64, '2025-04-23 21:19:34', '2025-04-23 21:19:34', 1, 1),
(47, 54124, 58871, 65, '2025-04-23 21:22:11', '2025-04-23 21:22:11', 1, 1),
(48, 54124, 58871, 66, '2025-04-23 21:22:42', '2025-04-23 21:22:42', 1, 1),
(49, 54124, 58871, 67, '2025-04-23 21:22:47', '2025-04-23 21:22:47', 1, 1),
(50, 58871, 54124, 68, '2025-04-23 21:23:36', '2025-04-23 21:23:36', 1, 1),
(51, 54124, 58871, 69, '2025-04-23 21:25:28', '2025-04-23 21:25:28', 1, 1),
(52, 58871, 54124, 70, '2025-04-24 05:09:59', '2025-04-24 05:09:59', 1, 1),
(53, 58871, 54124, 71, '2025-04-24 05:18:06', '2025-04-24 05:18:06', 1, 1),
(54, 28670, 51675, 73, '2025-04-28 16:24:07', '2025-04-28 16:24:07', 0, 0),
(55, 28670, 51675, 74, '2025-04-28 16:18:09', '2025-04-28 16:18:09', 0, 1),
(56, 28670, 51675, 75, '2025-04-28 16:18:09', '2025-04-28 16:18:09', 0, 1),
(57, 28670, 51675, 76, '2025-04-28 16:18:08', '2025-04-28 16:18:08', 0, 1),
(58, 58871, 54124, 77, '2025-04-25 18:34:15', '2025-04-25 18:34:15', 1, 1),
(59, 58871, 54124, 78, '2025-04-25 18:34:21', '2025-04-25 18:34:21', 1, 1),
(60, 58871, 58871, 79, '2025-04-25 18:39:48', '2025-04-25 18:39:48', 1, 1),
(61, 54124, 58871, 80, '2025-04-25 18:56:02', '2025-04-25 18:56:02', 1, 1),
(62, 58871, 54124, 81, '2025-04-27 13:28:28', '2025-04-27 13:28:28', 1, 1),
(63, 58871, 54124, 82, '2025-04-27 13:43:05', '2025-04-27 13:43:05', 1, 1),
(64, 54124, 58871, 83, '2025-04-27 13:45:48', '2025-04-27 13:45:48', 1, 1),
(65, 58871, 54124, 84, '2025-04-27 13:48:00', '2025-04-27 13:48:00', 1, 1),
(66, 54124, 58871, 85, '2025-04-27 13:50:18', '2025-04-27 13:50:18', 1, 1),
(67, 58871, 54124, 86, '2025-04-27 13:54:52', '2025-04-27 13:54:52', 1, 1),
(68, 58871, 54124, 87, '2025-04-27 14:04:58', '2025-04-27 14:04:58', 1, 1),
(69, 54124, 58871, 88, '2025-04-27 14:10:41', '2025-04-27 14:10:41', 1, 1),
(70, 58871, 54124, 89, '2025-04-27 21:06:11', '2025-04-27 21:06:11', 1, 1),
(71, 58871, 54124, 90, '2025-04-27 21:06:15', '2025-04-27 21:06:15', 1, 1),
(72, 58871, 54124, 91, '2025-04-27 21:06:16', '2025-04-27 21:06:16', 1, 1),
(73, 49784, 54124, 95, '2025-04-28 08:04:51', '2025-04-28 08:04:51', 0, 0),
(74, 49784, 54124, 107, '2025-04-29 16:04:08', '2025-04-29 16:04:08', 0, 0),
(75, 58871, 54124, 97, '2025-04-28 08:35:34', '2025-04-28 08:35:34', 1, 1),
(76, 49784, 97086, 106, '2025-04-28 12:52:24', '2025-04-28 12:52:24', 0, 0),
(77, 49784, 28670, 108, '2025-04-28 16:36:53', '2025-04-28 16:36:53', 0, 0),
(78, 49784, 28670, 111, '2025-04-28 16:40:22', '2025-04-28 16:40:22', 0, 1),
(79, 99569, 28670, 110, '2025-04-28 16:18:10', '2025-04-28 16:18:10', 1, 0),
(80, 53827, 58871, 112, '2025-04-28 20:20:48', '2025-04-28 20:20:48', 1, 1),
(81, 96697, 54124, 113, '2025-04-29 16:04:05', '2025-04-29 16:04:05', 1, 0),
(82, 96697, 54124, 122, '2025-04-29 16:04:41', '2025-04-29 16:04:41', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedbacks`
--

CREATE TABLE `tbl_feedbacks` (
  `Feedback_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Receiver_ID` int(11) DEFAULT NULL,
  `Feedback_Category` varchar(255) DEFAULT NULL,
  `Feedback_Details` text DEFAULT NULL,
  `Date_Submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_feedbacks`
--

INSERT INTO `tbl_feedbacks` (`Feedback_ID`, `User_ID`, `Receiver_ID`, `Feedback_Category`, `Feedback_Details`, `Date_Submitted`) VALUES
(1234, 1234, 0, 'Good Sports', 'Good', '2025-04-01 06:21:16'),
(1235, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:09:56'),
(1236, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:10:39'),
(1237, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:13:11'),
(1238, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:13:30'),
(1239, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:13:31'),
(1240, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:13:55'),
(1241, 17, 28670, 'Positive Feedback', 'Good', '2025-04-08 20:14:23'),
(1242, 10, 38224, 'Bug Report', 'Good', '2025-04-09 05:33:50'),
(1243, 10, 60976, 'Constructive Criticism', 'Good', '2025-04-09 06:35:32'),
(1244, 19, 28670, 'Positive Feedback', 'Good', '2025-04-10 13:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_heroimages`
--

CREATE TABLE `tbl_heroimages` (
  `Hero_ID` int(11) NOT NULL,
  `Hero_Name` varchar(100) DEFAULT NULL,
  `Hero_Role` varchar(255) DEFAULT NULL,
  `Path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_heroimages`
--

INSERT INTO `tbl_heroimages` (`Hero_ID`, `Hero_Name`, `Hero_Role`, `Path`) VALUES
(1, 'Tigreal', 'Tank', 'IMG/hero/Tank/tnk-1.png'),
(2, 'Akai', 'Tank', 'IMG/hero/Tank/tnk-2.png'),
(3, 'Franco', 'Tank', 'IMG/hero/Tank/tnk-3.png'),
(5, 'Hylos', 'Tank', 'IMG/hero/Tank/tnk-4.png'),
(6, 'Uranus', 'Tank', 'IMG/hero/Tank/tnk-5.png'),
(7, 'Belerick', 'Tank', 'IMG/hero/Tank/tnk-6.png'),
(8, 'Khufra', 'Tank', 'IMG/hero/Tank/tnk-7.png'),
(9, 'Baxia', 'Tank', 'IMG/hero/Tank/tnk-8.png'),
(10, 'Atlas', 'Tank', 'IMG/hero/Tank/tnk-9.png'),
(11, 'Gloo', 'Tank', 'IMG/hero/Tank/tnk-10.png'),
(12, 'Ghatotkacha', 'Tank', 'IMG/hero/Tank/tnk-11.png'),
(13, 'Grock', 'Tank', 'IMG/hero/Tank/tnk-12.png'),
(14, 'Minotaur', 'Tank', 'IMG/hero/Tank/tnk-13.png'),
(15, 'Johnson', 'Tank', 'IMG/hero/Tank/tnk-14.png'),
(16, 'Esmeralda', 'Tank', 'IMG/hero/Tank/tnk-15.png'),
(17, 'Barats', 'Tank', 'IMG/hero/Tank/tnk-16.png'),
(18, 'Edith', 'Tank', 'IMG/hero/Tank/tnk-17.png'),
(19, 'Balmond', 'Fighter', 'IMG/hero/Fighter/ft-1.png'),
(20, 'Freya', 'Fighter', 'IMG/hero/Fighter/ft-2.png'),
(21, 'Chou', 'Fighter', 'IMG/hero/Fighter/ft-3.png'),
(22, 'Sun', 'Fighter', 'IMG/hero/Fighter/ft-4.png'),
(23, 'Alpha', 'Fighter', 'IMG/hero/Fighter/ft-5.png'),
(24, 'Ruby', 'Fighter', 'IMG/hero/Fighter/ft-6.png'),
(25, 'Lapu-Lapu', 'Fighter', 'IMG/hero/Fighter/ft-7.png'),
(26, 'Argus', 'Fighter', 'IMG/hero/Fighter/ft-8.png'),
(27, 'Jawhead', 'Fighter', 'IMG/hero/Fighter/ft-9.png'),
(28, 'Martis', 'Fighter', 'IMG/hero/Fighter/ft-10.png'),
(29, 'Aldous', 'Fighter', 'IMG/hero/Fighter/ft-11.png'),
(30, 'Leomord', 'Fighter', 'IMG/hero/Fighter/ft-12.png'),
(31, 'Thamuz', 'Fighter', 'IMG/hero/Fighter/ft-13.png'),
(32, 'Minsitthar', 'Fighter', 'IMG/hero/Fighter/ft-14.png'),
(33, 'Badang', 'Fighter', 'IMG/hero/Fighter/ft-15.png'),
(34, 'Guinevere', 'Fighter', 'IMG/hero/Fighter/ft-16.png'),
(35, 'X.Borg', 'Fighter', 'IMG/hero/Fighter/ft-17.png'),
(36, 'Dyrroth', 'Fighter', 'IMG/hero/Fighter/ft-18.png'),
(37, 'Masha', 'Fighter', 'IMG/hero/Fighter/ft-19.png'),
(38, 'Silvanna', 'Fighter', 'IMG/hero/Fighter/ft-20.png'),
(39, 'Yu Zhong', 'Fighter', 'IMG/hero/Fighter/ft-21.png'),
(40, 'Saber', 'Assassin', 'IMG/hero/Assassin/ass-1.png'),
(41, 'Karina', 'Assassin', 'IMG/hero/Assassin/ass-2.png'),
(42, 'Fanny', 'Assassin', 'IMG/hero/Assassin/ass-3.png'),
(43, 'Hayabusa', 'Assassin', 'IMG/hero/Assassin/ass-4.png'),
(44, 'Natalia', 'Assassin', 'IMG/hero/Assassin/ass-5.png'),
(45, 'Lancelot', 'Assassin', 'IMG/hero/Assassin/ass-6.png'),
(46, 'Helcurt', 'Assassin', 'IMG/hero/Assassin/ass-7.png'),
(47, 'Gusion', 'Assassin', 'IMG/hero/Assassin/ass-8.png'),
(48, 'Hanzo', 'Assassin', 'IMG/hero/Assassin/ass-9.png'),
(49, 'Ling', 'Assassin', 'IMG/hero/Assassin/ass-10.png'),
(50, 'Aamon', 'Assassin', 'IMG/hero/Assassin/ass-11.png'),
(51, 'Joy', 'Assassin', 'IMG/hero/Assassin/ass-12.png'),
(52, 'Nolan', 'Assassin', 'IMG/hero/Assassin/ass-13.png'),
(53, 'Yi Sun-shin', 'Assassin', 'IMG/hero/Assassin/ass-14.png'),
(54, 'Harley', 'Assassin', 'IMG/hero/Assassin/ass-15.png'),
(55, 'Selena', 'Assassin', 'IMG/hero/Assassin/ass-16.png'),
(56, 'Benedetta', 'Assassin', 'IMG/hero/Assassin/ass-17.png'),
(57, 'Suyou', 'Assassin', 'IMG/hero/Assassin/ass-18.png'),
(58, 'Nana', 'Mage', 'IMG/hero/Mage/mg-1.png'),
(59, 'Eudora', 'Mage', 'IMG/hero/Mage/mg-2.png'),
(60, 'Gord', 'Mage', 'IMG/hero/Mage/mg-3.png'),
(61, 'Kagura', 'Mage', 'IMG/hero/Mage/mg-4.png'),
(63, 'Aurora', 'Mage', 'IMG/hero/Mage/mg-6.png'),
(64, 'Vexana', 'Mage', 'IMG/hero/Mage/mg-7.png'),
(65, 'Odette', 'Mage', 'IMG/hero/Mage/mg-8.png'),
(66, 'Zhask', 'Mage', 'IMG/hero/Mage/mg-9.png'),
(67, 'Pharsa', 'Mage', 'IMG/hero/Mage/mg-10.png'),
(68, 'Valir', 'Mage', 'IMG/hero/Mage/mg-11.png'),
(69, 'Chang\'e', 'Mage', 'IMG/hero/Mage/mg-12.png'),
(70, 'Vale', 'Mage', 'IMG/hero/Mage/mg-13.png'),
(71, 'Lunox', 'Mage', 'IMG/hero/Mage/mg-14.png'),
(72, 'Harith', 'Mage', 'IMG/hero/Mage/mg-15.png'),
(73, 'Lylia', 'Mage', 'IMG/hero/Mage/mg-16.png'),
(74, 'Cecilion', 'Mage', 'IMG/hero/Mage/mg-17.png'),
(75, 'Luo Yi', 'Mage', 'IMG/hero/Mage/mg-18.png'),
(76, 'Yve', 'Mage', 'IMG/hero/Mage/mg-19.png'),
(77, 'Valentina', 'Mage', 'IMG/hero/Mage/mg-20.png'),
(78, 'Xavier', 'Mage', 'IMG/hero/Mage/mg-21.png'),
(79, 'Miya', 'Marksman', 'IMG/hero/Marksman/mm-1.png'),
(80, 'Bruno', 'Marksman', 'IMG/hero/Marksman/mm-2.png'),
(81, 'Clint', 'Marksman', 'IMG/hero/Marksman/mm-3.png'),
(82, 'Layla', 'Marksman', 'IMG/hero/Marksman/mm-4.png'),
(83, 'Moskov', 'Marksman', 'IMG/hero/Marksman/mm-5.png'),
(84, 'Karrie', 'Marksman', 'IMG/hero/Marksman/mm-6.png'),
(85, 'Irithel', 'Marksman', 'IMG/hero/Marksman/mm-7.png'),
(86, 'Hanabi', 'Marksman', 'IMG/hero/Marksman/mm-8.png'),
(87, 'Claude', 'Marksman', 'IMG/hero/Marksman/mm-9.png'),
(88, 'Granger', 'Marksman', 'IMG/hero/Marksman/mm-10.png'),
(89, 'Wanwan', 'Marksman', 'IMG/hero/Marksman/mm-11.png'),
(90, 'Popol and Kupa', 'Marksman', 'IMG/hero/Marksman/mm-12.png'),
(113, 'Cyclops', 'Mage', 'IMG/hero/Mage/mg-5.png'),
(143, 'Brody', 'Marksman', 'IMG/hero/Marksman/mm-13.png'),
(144, 'Beatrix', 'Marksman', 'IMG/hero/Marksman/mm-14.png'),
(145, 'Natan', 'Marksman', 'IMG/hero/Marksman/mm-15.png'),
(146, 'Melissa', 'Marksman', 'IMG/hero/Marksman/mm-16.png'),
(147, 'Ixia', 'Marksman', 'IMG/hero/Marksman/mm-17.png'),
(148, 'Lesley', 'Marksman', 'IMG/hero/Marksman/mm-18.png'),
(149, 'Kimmy', 'Marksman', 'IMG/hero/Marksman/mm-19.png'),
(150, 'Rafaela', 'Support', 'IMG/hero/Support/sp-1.png'),
(151, 'Estes', 'Support', 'IMG/hero/Support/sp-2.png'),
(152, 'Diggie', 'Support', 'IMG/hero/Support/sp-3.png'),
(153, 'Angela', 'Support', 'IMG/hero/Support/sp-4.png'),
(154, 'Floryn', 'Support', 'IMG/hero/Support/sp-5.png'),
(155, 'Lolita', 'Support', 'IMG/hero/Support/sp-6.png'),
(156, 'Kaja', 'Support', 'IMG/hero/Support/sp-7.png'),
(157, 'Faramis', 'Support', 'IMG/hero/Support/sp-8.png'),
(158, 'Carmilla', 'Support', 'IMG/hero/Support/sp-9.png'),
(159, 'Mathilda', 'Support', 'IMG/hero/Support/sp-10.png'),
(160, 'Chip', 'Support', 'IMG/hero/Support/sp-11.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instructions`
--

CREATE TABLE `tbl_instructions` (
  `Instruction_ID` int(11) NOT NULL,
  `Step1_Title` varchar(255) DEFAULT NULL,
  `Step1_Content` text DEFAULT NULL,
  `Step2_Title` varchar(255) DEFAULT NULL,
  `Step2_Content` text DEFAULT NULL,
  `Step3_Title` varchar(255) DEFAULT NULL,
  `Step3_Content` text DEFAULT NULL,
  `Step4_Title` varchar(255) DEFAULT NULL,
  `Step4_Content` text DEFAULT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Show_Status` varchar(10) DEFAULT 'Hidden'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_instructions`
--

INSERT INTO `tbl_instructions` (`Instruction_ID`, `Step1_Title`, `Step1_Content`, `Step2_Title`, `Step2_Content`, `Step3_Title`, `Step3_Content`, `Step4_Title`, `Step4_Content`, `Created_At`, `Updated_At`, `Show_Status`) VALUES
(1, NULL, '', NULL, '', NULL, '', NULL, '', '2025-04-27 16:28:12', '2025-04-27 17:12:48', 'Hidden'),
(2, NULL, 'Step1', NULL, 'Step2', NULL, 'Step3', NULL, 'Step4', '2025-04-27 17:06:57', '2025-04-28 08:17:39', 'Hidden'),
(3, 'Submit Results & Feedback', 'Register an account on the platform and set up your squad by adding team details, including in-game names (IGNs), ranks, and roles. Ensure your squad has 6-7 members, including a coach, to be officially recognized.', NULL, 'Use the matchmaking system to search for squads that match your rank and skill level. Send scrim requests, negotiate match details, and finalize an agreement with the opposing team.', NULL, 'Once both squads confirm the challenge, schedule the match by selecting the date and time. Receive notifications and reminders before the game, then compete in your scheduled scrim.', NULL, 'After the match, upload a screenshot of the final score, review the match experience, and report any issues if necessary. Your squad’s performance will be updated in the system, helping you track progress and improve your gameplay.\r\n                    </div>', '2025-04-27 17:40:05', '2025-04-28 08:17:39', 'Shown');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inviteslog`
--

CREATE TABLE `tbl_inviteslog` (
  `Schedule_ID` int(255) NOT NULL,
  `Challenger_Squad_ID` int(11) DEFAULT NULL,
  `Squad_ID` int(255) DEFAULT NULL,
  `Scrim_Date` date DEFAULT NULL,
  `Scrim_Time` time DEFAULT NULL,
  `No_Of_Games` int(255) DEFAULT NULL,
  `Status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Response` enum('Pending','Accepted','Declined') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inviteslog`
--

INSERT INTO `tbl_inviteslog` (`Schedule_ID`, `Challenger_Squad_ID`, `Squad_ID`, `Scrim_Date`, `Scrim_Time`, `No_Of_Games`, `Status`, `Created_At`, `Response`) VALUES
(1, 98078, 28670, '2025-04-08', '15:58:00', 0, 'Pending', '2025-04-07 06:49:18', 'Accepted'),
(2, 28670, 98078, '2025-04-05', '12:51:00', 0, 'Pending', '2025-04-07 10:48:48', 'Pending'),
(3, 98078, 28670, '2025-04-23', '08:49:00', 0, 'Pending', '2025-04-07 06:49:18', 'Declined'),
(4, 28670, 38224, '2025-04-13', '16:08:00', 0, 'Pending', '2025-04-07 11:05:27', 'Pending'),
(5, 38224, 28670, '2025-04-13', '16:08:00', 0, 'Pending', '2025-04-07 11:05:27', 'Accepted'),
(6, 98078, 28670, '2025-04-11', '13:49:00', 5, 'Pending', '2025-04-08 08:46:18', 'Accepted'),
(7, 28670, 28670, '2025-04-16', '02:41:00', 3, 'Pending', '2025-04-08 20:38:40', 'Declined'),
(8, 28670, 38224, '2025-04-06', '01:03:00', 3, 'Pending', '2025-04-08 21:01:08', 'Pending'),
(9, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(10, 28670, 72997, '2025-04-21', '11:10:00', 3, 'Pending', '2025-04-08 21:06:09', 'Accepted'),
(11, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(12, 28670, 72997, '2025-04-21', '11:10:00', 3, 'Pending', '2025-04-08 21:06:09', 'Accepted'),
(13, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Declined'),
(14, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Declined'),
(15, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(16, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(17, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(18, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(19, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(20, 72997, 28670, '2025-04-09', '05:00:00', 7, 'Pending', '2025-04-08 21:03:08', 'Accepted'),
(21, 10457, 28670, '2025-04-21', '15:17:00', 3, 'Pending', '2025-04-09 22:16:03', 'Pending'),
(22, 96990, 28670, '2025-04-21', '15:17:00', 3, 'Pending', '2025-04-09 22:16:03', 'Pending'),
(23, 55548, 28670, '2025-04-11', '14:33:00', 5, 'Pending', '2025-04-10 00:33:44', 'Accepted'),
(24, 28670, 55548, '2025-04-09', '14:35:00', 3, 'Pending', '2025-04-10 00:35:16', 'Accepted'),
(25, 55548, 28670, '2025-04-11', '14:36:00', 5, 'Pending', '2025-04-10 00:37:01', 'Accepted'),
(26, 53932, 55548, '2025-04-11', '14:52:00', 3, 'Pending', '2025-04-10 00:52:24', 'Accepted'),
(27, 53932, 55548, '2025-04-11', '15:03:00', 5, 'Pending', '2025-04-10 01:01:34', 'Accepted'),
(28, 55548, 53932, '2025-04-09', '15:03:00', 5, 'Pending', '2025-04-10 01:02:37', 'Accepted'),
(29, 43844, 28670, '2025-04-11', '17:35:00', 5, 'Pending', '2025-04-10 03:35:04', 'Accepted'),
(30, 55548, 28670, '2025-04-10', '14:14:00', 5, 'Pending', '2025-04-10 12:14:40', 'Accepted'),
(31, 28670, 55548, '2025-04-07', '15:10:00', 3, 'Pending', '2025-04-10 13:10:21', 'Accepted'),
(32, 28670, 55548, '2025-04-08', '15:19:00', 3, 'Pending', '2025-04-10 13:19:42', 'Accepted'),
(33, 28670, 55548, '2025-04-03', '03:19:00', 5, 'Pending', '2025-04-10 13:19:52', 'Accepted'),
(34, 28670, 55548, '2025-04-09', '15:23:00', 3, 'Pending', '2025-04-10 13:20:02', 'Accepted'),
(35, 43844, 55548, '2025-04-08', '15:36:00', 3, 'Pending', '2025-04-10 13:36:23', 'Accepted'),
(36, 99569, 28670, '2025-04-14', '06:21:00', 3, 'Pending', '2025-04-23 04:21:22', 'Accepted'),
(37, 99569, 28670, '2025-04-14', '06:24:00', 3, 'Pending', '2025-04-23 04:21:31', 'Accepted'),
(38, 99569, 28670, '2025-04-04', '10:24:00', 3, 'Pending', '2025-04-23 04:21:38', 'Accepted'),
(39, 28670, 99569, '2025-04-16', '06:29:00', 3, 'Pending', '2025-04-23 04:29:23', 'Accepted'),
(40, 28670, 99569, '2025-04-06', '06:33:00', 3, 'Pending', '2025-04-23 04:29:30', 'Accepted'),
(41, 28670, 99569, '2025-04-01', '06:33:00', 3, 'Pending', '2025-04-23 04:29:36', 'Accepted'),
(42, 28670, 99569, '2025-02-03', '06:33:00', 3, 'Pending', '2025-04-23 04:29:43', 'Accepted'),
(43, 28670, 99569, '2025-02-21', '06:33:00', 3, 'Pending', '2025-04-23 04:29:48', 'Accepted'),
(44, 99569, 28670, '2025-04-15', '19:40:00', 3, 'Pending', '2025-04-23 05:36:41', 'Accepted'),
(45, 99569, 28670, '2025-04-10', '19:40:00', 3, 'Pending', '2025-04-23 05:36:52', 'Accepted'),
(46, 99569, 28670, '2025-04-04', '19:40:00', 3, 'Pending', '2025-04-23 05:37:12', 'Accepted'),
(47, 28670, 99569, '2025-04-17', '20:17:00', 3, 'Pending', '2025-04-23 06:15:37', 'Pending'),
(48, 28670, 99569, '2025-04-10', '20:17:00', 3, 'Pending', '2025-04-23 06:15:46', 'Accepted'),
(49, 28670, 99569, '2025-04-02', '20:17:00', 3, 'Pending', '2025-04-23 06:15:53', 'Accepted'),
(50, 54124, 58871, '2025-04-23', '13:29:00', 3, 'Pending', '2025-04-23 11:29:17', 'Accepted'),
(51, 54124, 58871, '2025-04-22', '13:29:00', 3, 'Pending', '2025-04-23 11:29:23', 'Accepted'),
(52, 54124, 58871, '2025-04-21', '13:29:00', 3, 'Pending', '2025-04-23 11:29:30', 'Accepted'),
(53, 58871, 54124, '2025-04-19', '01:56:00', 3, 'Pending', '2025-04-23 11:55:50', 'Accepted'),
(54, 58871, 54124, '2025-04-18', '01:56:00', 3, 'Pending', '2025-04-23 11:55:55', 'Accepted'),
(55, 58871, 54124, '2025-04-17', '01:56:00', 3, 'Pending', '2025-04-23 11:56:00', 'Accepted'),
(56, 58871, 54124, '2025-04-18', '14:18:00', 3, 'Pending', '2025-04-23 12:18:25', 'Accepted'),
(57, 58871, 54124, '2025-04-04', '14:55:00', 5, 'Pending', '2025-04-23 12:55:27', 'Accepted'),
(58, 58871, 54124, '2025-04-07', '15:05:00', 5, 'Pending', '2025-04-23 13:05:49', 'Accepted'),
(59, 54124, 58871, '2025-04-02', '15:12:00', 5, 'Pending', '2025-04-23 13:12:39', 'Accepted'),
(60, 54124, 58871, '2025-04-03', '15:15:00', 3, 'Pending', '2025-04-23 13:15:06', 'Accepted'),
(61, 54124, 58871, '2025-04-10', '15:22:00', 3, 'Pending', '2025-04-23 13:23:03', 'Accepted'),
(62, 54124, 58871, '2025-04-18', '15:31:00', 5, 'Pending', '2025-04-23 13:31:52', 'Accepted'),
(63, 54124, 58871, '2025-04-11', '15:31:00', 3, 'Pending', '2025-04-23 13:32:10', 'Accepted'),
(64, 58871, 54124, '2025-04-16', '16:03:00', 3, 'Pending', '2025-04-23 14:03:54', 'Declined'),
(65, 58871, 54124, '2025-04-16', '16:03:00', 3, 'Pending', '2025-04-23 14:03:58', 'Accepted'),
(66, 58871, 54124, '2025-04-18', '17:07:00', 3, 'Pending', '2025-04-23 15:07:34', 'Accepted'),
(67, 58871, 54124, '2025-04-14', '17:08:00', 3, 'Pending', '2025-04-23 15:08:09', 'Accepted'),
(68, 54124, 58871, '2025-04-18', '17:21:00', 3, 'Pending', '2025-04-23 15:21:40', 'Accepted'),
(69, 54124, 58871, '2025-04-16', '17:21:00', 3, 'Pending', '2025-04-23 15:21:50', 'Accepted'),
(70, 58871, 54124, '2025-04-06', '05:28:00', 0, 'Pending', '2025-04-23 15:23:12', 'Accepted'),
(71, 54124, 58871, '2025-03-31', '17:24:00', 3, 'Pending', '2025-04-23 15:24:38', 'Accepted'),
(72, 58871, 54124, '2025-04-18', '01:08:00', 3, 'Pending', '2025-04-23 23:09:03', 'Accepted'),
(73, 58871, 54124, '2025-04-09', '01:08:00', 3, 'Pending', '2025-04-23 23:09:15', 'Accepted'),
(74, 58871, 54124, '2025-04-12', '01:14:00', 5, 'Pending', '2025-04-23 23:14:34', 'Pending'),
(75, 58871, 54124, '2025-04-12', '01:14:00', 5, 'Pending', '2025-04-23 23:15:46', 'Pending'),
(76, 58871, 54124, '2025-04-12', '01:14:00', 5, 'Pending', '2025-04-23 23:15:46', 'Accepted'),
(77, 58871, 54124, '2025-04-12', '01:14:00', 5, 'Pending', '2025-04-23 23:15:53', 'Accepted'),
(78, 58871, 54124, '2025-04-12', '01:14:00', 5, 'Pending', '2025-04-23 23:15:59', 'Accepted'),
(79, 58871, 54124, '2025-04-12', '01:14:00', 5, 'Pending', '2025-04-23 23:16:03', 'Accepted'),
(80, 28670, 51675, '2025-04-25', '16:54:00', 3, 'Pending', '2025-04-24 00:54:43', 'Accepted'),
(81, 28670, 51675, '2025-04-22', '16:54:00', 5, 'Pending', '2025-04-24 00:55:26', 'Accepted'),
(82, 28670, 51675, '2025-04-10', '03:08:00', 3, 'Pending', '2025-04-24 01:08:52', 'Accepted'),
(83, 28670, 51675, '2025-04-18', '03:12:00', 3, 'Pending', '2025-04-24 01:12:52', 'Accepted'),
(84, 28670, 51675, '2025-04-04', '03:12:00', 5, 'Pending', '2025-04-24 01:13:35', 'Pending'),
(85, 58871, 54124, '2025-04-24', '14:32:00', 3, 'Pending', '2025-04-25 12:32:33', 'Accepted'),
(86, 58871, 54124, '2025-04-22', '14:32:00', 3, 'Pending', '2025-04-25 12:33:32', 'Accepted'),
(87, 58871, 58871, '2025-04-11', '14:39:00', 5, 'Pending', '2025-04-25 12:39:21', 'Accepted'),
(88, 54124, 58871, '2025-04-25', '14:55:00', 5, 'Pending', '2025-04-25 12:55:42', 'Accepted'),
(89, 58871, 54124, '2025-04-26', '09:27:00', 5, 'Pending', '2025-04-27 07:28:01', 'Accepted'),
(90, 54124, 58871, '2025-04-25', '09:43:00', 3, 'Pending', '2025-04-27 07:43:54', 'Accepted'),
(91, 58871, 54124, '2025-04-24', '09:47:00', 3, 'Pending', '2025-04-27 07:47:36', 'Accepted'),
(92, 54124, 58871, '2025-04-23', '09:49:00', 5, 'Pending', '2025-04-27 07:49:33', 'Accepted'),
(93, 58871, 54124, '2025-04-22', '09:54:00', 3, 'Pending', '2025-04-27 07:54:22', 'Accepted'),
(94, 54124, 58871, '2025-04-12', '10:10:00', 3, 'Pending', '2025-04-27 08:10:17', 'Accepted'),
(95, 49784, 54124, '2025-04-26', '16:35:00', 5, 'Pending', '2025-04-27 20:35:26', 'Declined'),
(96, 54124, 58871, '2025-09-05', '17:25:00', 5, 'Pending', '2025-04-27 20:48:47', 'Pending'),
(97, 54124, 58871, '2025-09-05', '17:25:00', 5, 'Pending', '2025-04-27 20:48:50', 'Pending'),
(98, 49784, 54124, '2025-04-25', '16:48:00', 3, 'Pending', '2025-04-27 20:48:52', 'Declined'),
(99, 49784, 54124, '2025-04-07', '17:26:00', 3, 'Pending', '2025-04-27 21:26:11', 'Accepted'),
(100, 49784, 54124, '2025-04-01', '03:50:00', 3, 'Pending', '2025-04-28 07:50:06', 'Accepted'),
(101, 49784, 97086, '2025-04-30', '08:19:00', 3, 'Pending', '2025-04-28 12:19:53', 'Accepted'),
(102, 97086, 53932, '2025-04-30', '02:32:00', 1, 'Pending', '2025-04-28 12:32:55', 'Pending'),
(103, 49784, 28670, '2025-04-29', '22:00:00', 5, 'Pending', '2025-04-28 12:54:54', 'Accepted'),
(104, 49784, 28670, '2025-04-29', '22:00:00', 5, 'Pending', '2025-04-28 12:54:57', 'Declined'),
(105, 49784, 28670, '2025-04-29', '22:00:00', 5, 'Pending', '2025-04-28 12:54:59', 'Declined'),
(106, 49784, 28670, '2025-04-29', '22:00:00', 5, 'Pending', '2025-04-28 12:55:02', 'Accepted'),
(107, 53827, 58871, '2025-04-30', '16:19:00', 3, 'Pending', '2025-04-28 20:19:52', 'Accepted'),
(108, 96697, 54124, '2025-05-02', '12:00:00', 3, 'Pending', '2025-04-29 16:00:16', 'Accepted'),
(109, 96697, 54124, '2025-05-01', '17:00:00', 3, 'Pending', '2025-04-29 16:00:31', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matchverifications`
--

CREATE TABLE `tbl_matchverifications` (
  `Verification_ID` int(11) NOT NULL,
  `Match_ID` int(11) DEFAULT NULL,
  `Squad_ID` int(11) DEFAULT NULL,
  `Your_Score` int(11) DEFAULT NULL,
  `Opponent_Score` int(11) DEFAULT NULL,
  `Proof_File` varchar(255) DEFAULT NULL,
  `Submission_Time` datetime DEFAULT current_timestamp(),
  `Game_Result` enum('Victory','Defeat','Pending') DEFAULT 'Pending',
  `Status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_matchverifications`
--

INSERT INTO `tbl_matchverifications` (`Verification_ID`, `Match_ID`, `Squad_ID`, `Your_Score`, `Opponent_Score`, `Proof_File`, `Submission_Time`, `Game_Result`, `Status`) VALUES
(8, 5, 28670, 1, 4, 'uploads/match_proofs/proof_67f561d22e33e3.06313392.png', '2025-04-09 01:50:10', 'Pending', 'Pending'),
(9, 8, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e3cfc42c54.23957019.png', '2025-04-09 11:04:47', 'Pending', 'Pending'),
(10, 10, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e6bae58377.87841680.png', '2025-04-09 11:17:14', 'Pending', 'Pending'),
(11, 10, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e72595b137.60874286.png', '2025-04-09 11:19:01', 'Pending', 'Pending'),
(12, 10, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e7456ef7d8.74718559.png', '2025-04-09 11:19:33', 'Pending', 'Pending'),
(13, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e7fa277e47.97780781.png', '2025-04-09 11:22:34', 'Pending', 'Pending'),
(14, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e8a28e55d5.41724631.png', '2025-04-09 11:25:22', 'Pending', 'Pending'),
(15, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e8b20cd836.47995292.png', '2025-04-09 11:25:38', 'Pending', 'Pending'),
(16, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e922e39040.24300472.png', '2025-04-09 11:27:30', 'Pending', 'Pending'),
(17, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e95951e578.29786360.png', '2025-04-09 11:28:25', 'Pending', 'Pending'),
(18, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e990beb501.36823618.png', '2025-04-09 11:29:20', 'Pending', 'Pending'),
(19, 11, 28670, 1, 4, 'uploads/match_proofs/proof_67f5e9ab4d41f8.69665375.png', '2025-04-09 11:29:47', 'Pending', 'Pending'),
(20, 12, 28670, 2, 4, 'uploads/match_proofs/proof_67f5fc51820999.95956774.png', '2025-04-09 12:49:21', 'Pending', 'Pending'),
(21, 14, 28670, 1, 4, 'uploads/match_proofs/proof_67f600a2a30ea0.84849852.png', '2025-04-09 13:07:46', 'Pending', 'Pending'),
(22, 17, 28670, 2, 4, 'uploads/match_proofs/proof_67f60575541b60.18530895.png', '2025-04-09 13:28:21', 'Pending', 'Pending'),
(23, 17, 28670, 2, 4, 'uploads/match_proofs/proof_67f6059cce5891.45702731.png', '2025-04-09 13:29:00', 'Pending', 'Pending'),
(24, 17, 28670, 3, 4, 'uploads/match_proofs/proof_67f605a5777ee0.44523576.png', '2025-04-09 13:29:09', 'Pending', 'Pending'),
(25, 13, 28670, 3, 4, 'uploads/match_proofs/proof_67f605b892c9b9.91305296.png', '2025-04-09 13:29:28', 'Pending', 'Pending'),
(26, 13, 28670, 3, 4, 'uploads/match_proofs/proof_67f605f92ef2a3.84110498.png', '2025-04-09 13:30:33', 'Pending', 'Pending'),
(27, 16, 28670, 1, 4, 'uploads/match_proofs/proof_67f6157c305106.76782441.png', '2025-04-09 14:36:44', 'Pending', 'Pending'),
(28, 25, 53932, 3, 2, 'uploads/match_proofs/proof_67f76d9e9fb588.63791701.php', '2025-04-10 15:05:02', 'Pending', 'Pending'),
(29, 22, 28670, 2, 1, '', '2025-04-11 01:13:42', 'Pending', 'Pending'),
(30, 18, 28670, 4, 3, '', '2025-04-11 01:20:36', 'Pending', 'Pending'),
(31, 25, 55548, 3, 2, '', '2025-04-11 01:31:39', 'Pending', 'Pending'),
(32, 22, 55548, 2, 1, '', '2025-04-11 01:39:36', 'Pending', 'Pending'),
(33, 19, 28670, 4, 3, '', '2025-04-11 02:20:10', 'Pending', 'Pending'),
(34, 15, 28670, 4, 3, '', '2025-04-11 02:49:55', 'Pending', 'Pending'),
(35, 28, 28670, 3, 2, '', '2025-04-11 02:51:54', 'Pending', 'Pending'),
(36, 29, 28670, 2, 1, '', '2025-04-11 03:19:04', 'Pending', 'Pending'),
(37, 30, 55548, 2, 1, '', '2025-04-11 03:20:45', 'Pending', 'Pending'),
(38, 32, 55548, 2, 1, '', '2025-04-11 03:37:31', 'Pending', 'Pending'),
(39, 31, 28670, 3, 2, '', '2025-04-11 03:38:59', 'Pending', 'Pending'),
(40, 31, 55548, 2, 3, '', '2025-04-11 04:31:22', 'Pending', 'Pending'),
(41, 21, 55548, 3, 2, '', '2025-04-11 13:15:53', 'Pending', 'Pending'),
(46, 9, 28670, 2, 1, '', '2025-04-23 17:02:59', 'Pending', 'Pending'),
(47, 9, 28670, 2, 1, '', '2025-04-23 17:05:01', 'Pending', 'Pending'),
(48, 20, 28670, 2, 1, '', '2025-04-23 17:10:13', 'Pending', 'Pending'),
(49, 21, 28670, 3, 2, '', '2025-04-23 17:11:48', 'Pending', 'Pending'),
(50, 32, 28670, 2, 1, '', '2025-04-23 17:23:36', 'Pending', 'Pending'),
(51, 34, 28670, 2, 1, '', '2025-04-23 17:31:12', 'Pending', 'Pending'),
(52, 30, 28670, 2, 1, '', '2025-04-23 17:45:11', 'Pending', 'Pending'),
(53, 33, 43844, 2, 1, '', '2025-04-23 17:50:12', 'Pending', 'Pending'),
(54, 26, 43844, 3, 2, '', '2025-04-23 17:58:25', 'Pending', 'Pending'),
(55, 23, 28670, 3, 2, '', '2025-04-23 18:06:40', 'Pending', 'Pending'),
(56, 38, 28670, 2, 1, '', '2025-04-23 18:22:21', 'Pending', 'Pending'),
(57, 37, 28670, 2, 1, '', '2025-04-23 18:25:40', 'Pending', 'Pending'),
(58, 37, 28670, 2, 1, '', '2025-04-23 18:26:26', 'Pending', 'Pending'),
(59, 37, 28670, 2, 1, '', '2025-04-23 18:26:27', 'Pending', 'Pending'),
(61, 38, 99569, 2, 1, '', '2025-04-23 18:50:17', 'Pending', 'Pending'),
(62, 37, 99569, 2, 1, '', '2025-04-23 18:55:54', 'Pending', 'Pending'),
(63, 39, 99569, 2, 1, '', '2025-04-23 19:07:36', 'Pending', 'Pending'),
(64, 40, 99569, 2, 1, '', '2025-04-23 19:13:02', 'Pending', 'Pending'),
(65, 42, 99569, 2, 1, '', '2025-04-23 19:22:43', 'Pending', 'Pending'),
(66, 43, 99569, 2, 1, '', '2025-04-23 19:28:08', 'Pending', 'Pending'),
(67, 41, 99569, 2, 1, '', '2025-04-23 19:28:47', 'Pending', 'Pending'),
(68, 46, 28670, 2, 1, '', '2025-04-23 19:38:21', 'Pending', 'Pending'),
(69, 43, 28670, 1, 2, '', '2025-04-23 19:57:53', 'Pending', 'Pending'),
(70, 39, 28670, 2, 1, '', '2025-04-23 20:07:59', 'Pending', 'Pending'),
(71, 42, 28670, 1, 2, '', '2025-04-23 20:09:12', 'Pending', 'Pending'),
(72, 48, 99569, 2, 1, '', '2025-04-23 20:16:51', 'Pending', 'Pending'),
(73, 45, 99569, 1, 2, '', '2025-04-23 20:25:44', 'Pending', 'Pending'),
(74, 46, 99569, 2, 1, '', '2025-04-23 22:02:18', 'Pending', 'Pending'),
(75, 46, 99569, 2, 1, '', '2025-04-23 22:07:14', 'Pending', 'Pending'),
(76, 46, 99569, 2, 1, '', '2025-04-23 22:09:21', 'Pending', 'Pending'),
(77, 46, 99569, 1, 2, '', '2025-04-23 22:10:05', 'Pending', 'Pending'),
(78, 46, 99569, 1, 2, '', '2025-04-23 22:10:24', 'Defeat', ''),
(79, 47, 99569, 1, 2, '', '2025-04-24 00:44:49', 'Defeat', ''),
(80, 49, 58871, 1, 2, '', '2025-04-24 01:35:25', 'Defeat', ''),
(81, 49, 54124, 2, 1, '', '2025-04-24 01:36:46', 'Pending', 'Pending'),
(82, 49, 54124, 2, 1, '', '2025-04-24 01:37:16', 'Pending', 'Pending'),
(83, 49, 54124, 2, 1, '', '2025-04-24 01:41:36', 'Pending', 'Pending'),
(84, 50, 58871, 2, 1, '', '2025-04-24 01:44:52', 'Victory', ''),
(85, 50, 54124, 1, 2, '', '2025-04-24 01:45:28', 'Defeat', ''),
(86, 51, 54124, 2, 1, '', '2025-04-24 01:53:03', 'Victory', ''),
(87, 51, 58871, 1, 2, '', '2025-04-24 01:53:44', 'Defeat', ''),
(88, 52, 54124, 1, 2, '', '2025-04-24 01:57:15', 'Defeat', ''),
(89, 52, 58871, 2, 1, '', '2025-04-24 01:57:56', 'Victory', ''),
(90, 53, 58871, 1, 2, '', '2025-04-24 02:13:50', 'Defeat', ''),
(91, 53, 54124, 2, 1, '', '2025-04-24 02:15:09', 'Victory', ''),
(92, 54, 54124, 1, 2, '', '2025-04-24 02:16:20', 'Defeat', ''),
(93, 54, 58871, 2, 1, '', '2025-04-24 02:16:57', 'Victory', ''),
(94, 55, 54124, 2, 1, '', '2025-04-24 02:19:21', 'Victory', ''),
(95, 55, 58871, 1, 2, '', '2025-04-24 02:20:01', 'Defeat', ''),
(96, 56, 54124, 3, 2, '', '2025-04-24 02:56:28', 'Victory', ''),
(97, 56, 58871, 2, 3, '', '2025-04-24 02:58:17', 'Defeat', ''),
(98, 57, 54124, 3, 2, '', '2025-04-24 03:07:09', 'Victory', ''),
(99, 57, 58871, 2, 3, '', '2025-04-24 03:08:14', 'Defeat', ''),
(100, 58, 58871, 2, 3, '', '2025-04-24 03:13:22', 'Defeat', 'Approved'),
(101, 58, 54124, 3, 2, '', '2025-04-24 03:14:20', 'Victory', 'Approved'),
(102, 59, 58871, 1, 2, '', '2025-04-24 03:16:49', 'Defeat', 'Approved'),
(103, 59, 54124, 2, 1, '', '2025-04-24 03:17:34', 'Victory', 'Approved'),
(104, 60, 58871, 2, 1, '', '2025-04-24 03:24:54', 'Victory', 'Approved'),
(105, 60, 54124, 1, 2, '', '2025-04-24 03:27:29', 'Defeat', 'Approved'),
(106, 62, 58871, 2, 3, '', '2025-04-24 03:38:08', 'Defeat', 'Approved'),
(107, 62, 54124, 3, 2, '', '2025-04-24 03:39:15', 'Victory', 'Approved'),
(108, 61, 54124, 1, 2, '', '2025-04-24 03:40:46', 'Defeat', 'Approved'),
(109, 61, 58871, 2, 1, '', '2025-04-24 03:41:28', 'Victory', 'Approved'),
(110, 63, 54124, 2, 1, '', '2025-04-24 04:06:06', 'Victory', 'Approved'),
(111, 63, 58871, 1, 2, '', '2025-04-24 04:06:48', 'Defeat', 'Approved'),
(112, 72, 54124, 2, 1, '', '2025-04-24 13:12:25', 'Victory', 'Approved'),
(113, 72, 58871, 1, 2, '', '2025-04-24 13:13:39', 'Defeat', 'Approved'),
(114, 75, 51675, 3, 2, '', '2025-04-24 15:03:26', 'Pending', 'Pending'),
(115, 75, 51675, 3, 2, '', '2025-04-24 15:04:06', 'Pending', 'Pending'),
(116, 75, 28670, 2, 3, '', '2025-04-24 15:06:43', 'Pending', 'Pending'),
(117, 76, 51675, 2, 1, '', '2025-04-24 15:09:59', 'Victory', 'Approved'),
(118, 76, 28670, 1, 2, '', '2025-04-24 15:12:12', 'Defeat', 'Approved'),
(119, 77, 51675, 2, 1, '', '2025-04-24 15:35:36', 'Victory', 'Approved'),
(120, 77, 51675, 2, 1, '', '2025-04-24 15:35:41', 'Victory', 'Approved'),
(121, 78, 54124, 2, 1, '', '2025-04-26 02:35:23', 'Victory', 'Approved'),
(122, 78, 58871, 1, 2, '', '2025-04-26 02:38:37', 'Defeat', 'Approved'),
(123, 80, 58871, 3, 1, '', '2025-04-26 02:40:40', 'Pending', 'Pending'),
(124, 80, 58871, 3, 2, '', '2025-04-26 02:53:36', 'Victory', 'Approved'),
(125, 81, 58871, 2, 3, '', '2025-04-26 02:56:29', 'Defeat', 'Approved'),
(126, 81, 54124, 3, 2, '', '2025-04-26 02:57:33', 'Victory', 'Approved'),
(127, 89, 58871, 1, 2, '', '2025-04-27 22:12:18', 'Defeat', 'Approved'),
(128, 89, 54124, 2, 1, '', '2025-04-27 22:13:39', 'Victory', 'Approved'),
(129, 86, 54124, 3, 2, '', '2025-04-27 22:14:29', 'Victory', 'Approved'),
(130, 86, 58871, 2, 3, '', '2025-04-27 22:16:03', 'Defeat', 'Approved'),
(131, 93, 49784, 1, 2, NULL, '2025-04-27 21:40:44', 'Pending', 'Pending'),
(132, 84, 54124, 2, 1, NULL, '2025-04-28 03:14:33', 'Pending', 'Pending'),
(133, 68, 54124, 2, 1, NULL, '2025-04-28 03:18:02', 'Pending', 'Pending'),
(134, 66, 54124, 2, 1, NULL, '2025-04-28 03:51:28', 'Pending', 'Pending'),
(135, 66, 54124, 2, 1, NULL, '2025-04-28 03:57:28', 'Pending', 'Pending'),
(136, 67, 54124, 2, 1, NULL, '2025-04-28 07:47:13', 'Pending', 'Pending'),
(137, 94, 54124, 1, 2, NULL, '2025-04-28 07:51:28', 'Pending', 'Pending'),
(138, 94, 49784, 2, 1, NULL, '2025-04-28 08:04:50', 'Pending', 'Pending'),
(139, 84, 54124, 2, 1, NULL, '2025-04-28 08:32:48', 'Pending', 'Pending'),
(140, 83, 54124, 3, 2, NULL, '2025-04-28 08:43:19', 'Victory', 'Approved'),
(141, 101, 96697, 2, 1, NULL, '2025-04-29 16:07:07', 'Pending', 'Pending'),
(142, 101, 96697, 2, 1, NULL, '2025-04-29 16:07:55', 'Pending', 'Pending'),
(143, 101, 96697, 2, 1, NULL, '2025-04-29 16:11:09', 'Pending', 'Pending'),
(144, 101, 96697, 2, 1, NULL, '2025-04-29 16:12:39', 'Victory', 'Approved'),
(145, 102, 96697, 2, 1, NULL, '2025-04-29 16:14:51', 'Pending', 'Pending'),
(146, 102, 96697, 2, 1, NULL, '2025-04-29 16:15:50', 'Victory', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messages`
--

CREATE TABLE `tbl_messages` (
  `Message_ID` int(11) NOT NULL,
  `Conversation_ID` int(11) DEFAULT NULL,
  `Sender_Squad_ID` int(11) DEFAULT NULL,
  `Recipient_Squad_ID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `Is_Read` tinyint(1) DEFAULT 0,
  `Created_At` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_messages`
--

INSERT INTO `tbl_messages` (`Message_ID`, `Conversation_ID`, `Sender_Squad_ID`, `Recipient_Squad_ID`, `Content`, `Is_Read`, `Created_At`) VALUES
(1, 1, 28670, 72997, 'hello', 1, '2025-04-10 06:55:11'),
(2, 1, 28670, 72997, 'Test Message', 1, '2025-04-10 06:56:59'),
(3, 1, 28670, 72997, 'Test Message', 1, '2025-04-10 06:57:03'),
(4, 1, 72997, 28670, 'Test Message', 1, '2025-04-10 11:46:46'),
(6, 2, 28670, 96990, 'Good', 0, '2025-04-10 13:20:57'),
(7, 1, 28670, 72997, 'Test Message', 1, '2025-04-10 13:21:06'),
(8, 1, 28670, 72997, 'Test Message', 1, '2025-04-10 13:21:24'),
(9, 1, 28670, 72997, 'Test Message', 1, '2025-04-10 13:22:42'),
(10, 1, 28670, 72997, 'Test Message', 1, '2025-04-10 13:32:18'),
(11, 1, 72997, 28670, 'TF', 1, '2025-04-10 13:43:50'),
(12, 1, 28670, 72997, 'Test Message', 0, '2025-04-10 13:44:54'),
(13, 1, 28670, 72997, 'artdfv', 0, '2025-04-10 13:49:27'),
(14, 1, 28670, 72997, 'ghdh', 0, '2025-04-10 14:03:05'),
(15, 1, 28670, 72997, 'Test Message', 0, '2025-04-10 14:04:24'),
(16, 1, 28670, 72997, 'Test Message', 0, '2025-04-10 14:23:19'),
(17, 2, 28670, 96990, 'neow', 0, '2025-04-10 14:23:29'),
(18, 3, 28670, 55548, 'OVER NAMAN', 1, '2025-04-10 14:37:52'),
(19, 3, 55548, 28670, 'LAUGHHH', 0, '2025-04-10 14:38:22'),
(20, 4, 55548, 53932, 'Test Message', 1, '2025-04-10 15:03:21'),
(21, 4, 53932, 55548, 'slay', 1, '2025-04-10 15:06:29'),
(22, 6, 1, 43844, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-11 at 17:35:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 1, '2025-04-10 17:35:31'),
(23, 6, 28670, 43844, 'hi baks', 1, '2025-04-10 17:36:18'),
(24, 6, 43844, 28670, 'over?!?!', 0, '2025-04-10 17:36:53'),
(25, 7, 1, 53932, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-11 at 14:52:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 01:39:13'),
(26, 8, 1, 55548, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-10 at 14:14:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 02:51:27'),
(27, 9, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-07 at 15:10:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 03:15:44'),
(28, 10, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-09 at 15:23:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 03:20:19'),
(29, 11, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-03 at 03:19:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 03:20:22'),
(30, 12, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-08 at 15:19:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 03:20:25'),
(31, 13, 1, 43844, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-08 at 15:36:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 03:36:44'),
(32, 14, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 55548\nScheduled on: 2025-04-09 at 14:35:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-11 03:43:17'),
(33, 15, 1, 55548, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-11 at 14:36:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 18:20:00'),
(34, 16, 1, 55548, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-11 at 14:33:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 18:20:08'),
(35, 17, 1, 99569, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-04 at 10:24:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 18:21:57'),
(36, 18, 1, 99569, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-14 at 06:24:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 18:21:59'),
(37, 19, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-02-21 at 06:33:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 19:07:06'),
(38, 20, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-02-03 at 06:33:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-23 19:07:11'),
(39, 21, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-04-01 at 06:33:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 19:22:07'),
(40, 22, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-04-06 at 06:33:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 19:22:12'),
(41, 23, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-04-16 at 06:29:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-23 19:22:16'),
(42, 24, 1, 99569, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-04 at 19:40:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 19:37:44'),
(43, 25, 1, 99569, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-10 at 19:40:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 19:37:47'),
(44, 26, 1, 99569, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 28670\nScheduled on: 2025-04-15 at 19:40:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-23 19:37:51'),
(45, 27, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-04-02 at 20:17:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-23 20:16:18'),
(46, 28, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 99569\nScheduled on: 2025-04-10 at 20:17:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-23 20:16:21'),
(47, 29, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-21 at 13:29:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 01:29:48'),
(48, 30, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-22 at 13:29:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 01:29:50'),
(49, 31, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-23 at 13:29:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 01:29:52'),
(50, 32, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-17 at 01:56:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 01:56:36'),
(51, 33, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-18 at 01:56:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 01:56:38'),
(52, 34, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-19 at 01:56:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 01:56:40'),
(53, 35, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-18 at 14:18:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 02:18:48'),
(54, 36, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-04 at 14:55:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 02:55:56'),
(55, 37, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-07 at 15:05:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 03:06:31'),
(56, 38, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-02 at 15:12:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 03:13:02'),
(57, 39, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-03 at 15:15:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 03:16:18'),
(58, 40, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-10 at 15:22:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 03:23:35'),
(59, 41, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-11 at 15:31:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 03:37:42'),
(60, 42, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-18 at 15:31:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 03:37:43'),
(61, 43, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-16 at 16:03:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 04:05:30'),
(62, 44, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-18 at 17:07:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:08:56'),
(63, 45, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-14 at 17:08:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:18:46'),
(64, 46, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-14 at 17:08:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:19:34'),
(65, 47, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-18 at 17:21:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:22:11'),
(66, 48, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-18 at 17:21:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:22:42'),
(67, 49, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-16 at 17:21:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:22:47'),
(68, 50, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-06 at 05:28:00\nNumber of Games: 0\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:23:36'),
(69, 51, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-03-31 at 17:24:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 05:25:28'),
(70, 52, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-09 at 01:08:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 13:09:59'),
(71, 53, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-12 at 01:14:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-24 13:18:06'),
(72, 54, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 51675\nScheduled on: 2025-04-25 at 16:54:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-24 14:57:44'),
(73, 54, 51675, 28670, 'Hello', 1, '2025-04-24 14:59:55'),
(74, 55, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 51675\nScheduled on: 2025-04-22 at 16:54:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 1, '2025-04-24 15:01:13'),
(75, 56, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 51675\nScheduled on: 2025-04-10 at 03:08:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-24 15:09:19'),
(76, 57, 1, 28670, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 51675\nScheduled on: 2025-04-18 at 03:12:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-24 15:32:23'),
(77, 58, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-22 at 14:32:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-26 02:34:15'),
(78, 59, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-24 at 14:32:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-26 02:34:21'),
(79, 60, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-11 at 14:39:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-26 02:39:48'),
(80, 61, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-25 at 14:55:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-26 02:56:02'),
(81, 62, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-26 at 09:27:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:28:28'),
(82, 63, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-26 at 09:27:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:43:05'),
(83, 64, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-25 at 09:43:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:45:48'),
(84, 65, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-24 at 09:47:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:48:00'),
(85, 66, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 58871\nScheduled on: 2025-04-23 at 09:49:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:50:18'),
(86, 67, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-22 at 09:54:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:54:52'),
(87, 68, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: \nOpponent Squad ID: 54124\nScheduled on: 2025-04-22 at 09:54:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 22:04:58'),
(88, 69, 1, 54124, 'Match accepted!\n\nChallenger Squad ID: 54124\nOpponent Squad ID: 58871\nScheduled on: 2025-04-12 at 10:10:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 22:10:41'),
(89, 70, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: 58871\nOpponent Squad ID: 54124\nScheduled on: 2025-04-12 at 01:14:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:06:11'),
(90, 71, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: 58871\nOpponent Squad ID: 54124\nScheduled on: 2025-04-12 at 01:14:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:06:15'),
(91, 72, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: 58871\nOpponent Squad ID: 54124\nScheduled on: 2025-04-12 at 01:14:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 0, '2025-04-27 21:06:16'),
(92, 73, 1, 49784, 'Match accepted!\n\nChallenger Squad ID: 49784\nOpponent Squad ID: 54124\nScheduled on: 2025-04-07 at 17:26:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-27 21:26:23'),
(93, 73, 49784, 54124, 'Hi', 1, '2025-04-27 21:26:42'),
(94, 73, 54124, 49784, 'hello', 1, '2025-04-27 21:26:49'),
(95, 73, 49784, 54124, 'purr!!!', 1, '2025-04-27 21:27:00'),
(96, 74, 1, 49784, 'Match accepted!\n\nChallenger Squad ID: 49784\nOpponent Squad ID: 54124\nScheduled on: 2025-04-01 at 03:50:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-28 07:50:38'),
(97, 75, 1, 58871, 'Match accepted!\n\nChallenger Squad ID: 58871\nOpponent Squad ID: 54124\nScheduled on: 2025-04-18 at 01:08:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-28 08:35:34'),
(98, 76, 1, 49784, 'Match accepted!\n\nChallenger Squad ID: 49784\nOpponent Squad ID: 97086\nScheduled on: 2025-04-30 at 08:19:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-28 12:20:07'),
(99, 76, 97086, 49784, 'Hello', 1, '2025-04-28 12:20:29'),
(100, 76, 97086, 49784, 'Hello', 1, '2025-04-28 12:20:35'),
(101, 76, 49784, 97086, 'sejuuunn', 1, '2025-04-28 12:20:43'),
(102, 76, 97086, 49784, 'bakit', 1, '2025-04-28 12:34:16'),
(103, 76, 97086, 49784, 'anong gingawa mo bossing', 1, '2025-04-28 12:34:25'),
(104, 76, 97086, 49784, 'AHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHA', 1, '2025-04-28 12:34:28'),
(105, 76, 97086, 49784, 'AHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHA', 1, '2025-04-28 12:34:32'),
(106, 76, 97086, 49784, 'AHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHAAHAHAHAHA', 1, '2025-04-28 12:34:36'),
(107, 74, 49784, 54124, 'Hello', 1, '2025-04-28 12:52:53'),
(108, 77, 1, 49784, 'Match accepted!\n\nChallenger Squad ID: 49784\nOpponent Squad ID: 28670\nScheduled on: 2025-04-29 at 22:00:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 1, '2025-04-28 12:56:30'),
(109, 78, 1, 49784, 'Match accepted!\n\nChallenger Squad ID: 49784\nOpponent Squad ID: 28670\nScheduled on: 2025-04-29 at 22:00:00\nNumber of Games: 5\n\nYou can now chat and prepare with each other here!', 1, '2025-04-28 12:56:35'),
(110, 79, 1, 99569, 'Match accepted!\n\nChallenger Squad ID: 99569\nOpponent Squad ID: 28670\nScheduled on: 2025-04-14 at 06:21:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-28 13:37:49'),
(111, 78, 49784, 28670, 'pwede po us mag play?', 0, '2025-04-28 16:40:22'),
(112, 80, 1, 53827, 'Match accepted!\n\nChallenger Squad ID: 53827\nOpponent Squad ID: 58871\nScheduled on: 2025-04-30 at 16:19:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-28 20:20:48'),
(113, 81, 1, 96697, 'Match accepted!\n\nChallenger Squad ID: 96697\nOpponent Squad ID: 54124\nScheduled on: 2025-05-01 at 17:00:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 0, '2025-04-29 16:02:50'),
(114, 82, 1, 96697, 'Match accepted!\n\nChallenger Squad ID: 96697\nOpponent Squad ID: 54124\nScheduled on: 2025-05-02 at 12:00:00\nNumber of Games: 3\n\nYou can now chat and prepare with each other here!', 1, '2025-04-29 16:02:52'),
(115, 82, 54124, 96697, 'Hello', 1, '2025-04-29 16:03:17'),
(116, 82, 96697, 54124, 'hii', 1, '2025-04-29 16:03:36'),
(117, 82, 54124, 96697, 'Helloooo', 1, '2025-04-29 16:03:42'),
(118, 82, 96697, 54124, 'testing', 1, '2025-04-29 16:03:47'),
(119, 82, 54124, 96697, 'hi ate!', 0, '2025-04-29 16:03:54'),
(120, 82, 54124, 96697, 'Hi!', 0, '2025-04-29 16:04:16'),
(121, 82, 54124, 96697, 'THi is a test message', 0, '2025-04-29 16:04:30'),
(122, 82, 54124, 96697, 'HElloooooo', 0, '2025-04-29 16:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_messagesyhsryhsryhrs`
--

CREATE TABLE `tbl_messagesyhsryhsryhrs` (
  `Message_ID` int(11) NOT NULL,
  `Sender_Squad_ID` int(255) DEFAULT NULL,
  `Recipient_Squad_ID` int(255) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `Is_Read` tinyint(1) DEFAULT 0,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modaccount`
--

CREATE TABLE `tbl_modaccount` (
  `Moderator_ID` int(11) NOT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_modaccount`
--

INSERT INTO `tbl_modaccount` (`Moderator_ID`, `Email_Address`, `Password`) VALUES
(1, 'kamora@gmail.com', '$2y$10$D8/ZeShOJMbf42VwuVM8auPoa5DJFZ9tx9n8auEbtP6vN4E8EDWnO'),
(2, 'selwyntolero@yahoo.com.ph', '$2y$10$yoD9GQiPrUKER7dDJEIQcOSTJJVlGPaXeq5o0YICowL2mqCxYXM22'),
(3, 'selwyntolero@yahoo.com.phh', '$2y$10$3MF4fuSGLvZnk3n./oVB8.z8D30V/4y16PPwUAoDPTru9zehkQbLS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penalties`
--

CREATE TABLE `tbl_penalties` (
  `Penalty_ID` int(11) NOT NULL,
  `Squad_ID` varchar(255) DEFAULT NULL,
  `Penalty_Type` enum('timeout','ban','warning') DEFAULT NULL,
  `Duration_Days` int(11) DEFAULT NULL,
  `Start_Date` datetime DEFAULT NULL,
  `End_Date` datetime DEFAULT NULL,
  `Reason` text DEFAULT NULL,
  `Status` enum('Active','Expired','Penalized') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_penalties`
--

INSERT INTO `tbl_penalties` (`Penalty_ID`, `Squad_ID`, `Penalty_Type`, `Duration_Days`, `Start_Date`, `End_Date`, `Reason`, `Status`) VALUES
(29, '', 'timeout', 3, '2025-04-09 19:56:39', '2025-04-12 19:56:39', 'ahahah', 'Expired'),
(30, '28670', 'timeout', 3, '2025-04-29 16:18:43', '2025-05-02 16:18:43', 'Toxicity', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pendingverif`
--

CREATE TABLE `tbl_pendingverif` (
  `Verification_ID` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Squad_ID` int(11) DEFAULT NULL,
  `Action` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_playerprofile`
--

CREATE TABLE `tbl_playerprofile` (
  `Player_ID` int(11) NOT NULL,
  `Squad_ID` int(11) DEFAULT NULL,
  `IGN` varchar(100) DEFAULT NULL,
  `First_Name` varchar(100) DEFAULT NULL,
  `Last_Name` varchar(255) DEFAULT NULL,
  `Game_ID` varchar(100) DEFAULT NULL,
  `Current_Rank` varchar(45) DEFAULT NULL,
  `Current_Star` int(11) DEFAULT NULL,
  `Highest_Rank` varchar(45) DEFAULT NULL,
  `Highest_Star` int(11) DEFAULT NULL,
  `Role` varchar(45) DEFAULT NULL,
  `Hero_1` varchar(100) DEFAULT NULL,
  `Hero_2` varchar(100) DEFAULT NULL,
  `Hero_3` varchar(100) DEFAULT NULL,
  `Highest_Score` int(11) NOT NULL DEFAULT 0,
  `View_ID` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_playerprofile`
--

INSERT INTO `tbl_playerprofile` (`Player_ID`, `Squad_ID`, `IGN`, `First_Name`, `Last_Name`, `Game_ID`, `Current_Rank`, `Current_Star`, `Highest_Rank`, `Highest_Star`, `Role`, `Hero_1`, `Hero_2`, `Hero_3`, `Highest_Score`, `View_ID`) VALUES
(1, 60976, 'brtgb', 'fb', NULL, 'bfgb', 'Grandmaster', 23, 'Warrior', 235235, 'Assassin', 'X.Borg', 'Minsitthar', 'Barats', 0, NULL),
(2, 38224, 'Belserion', 'Cj Torress', NULL, '81234567', 'Mythical Honor', 30, 'Mythical Immortal', 100, 'Mage', 'Selena', 'Kagura', 'Xavier', 0, NULL),
(3, 38224, 'Synx', 'Joed Guitierez', NULL, '987345612', 'Mythical Honor', 40, 'Mythical Immortal', 123, 'Assassin', 'Fanny', 'Suyou', 'Joy', 0, NULL),
(4, 38224, 'kenra', 'Ken Jabagat', NULL, '912384756', 'Mythical Honor', 25, 'Mythical Glory', 63, 'Marksman', 'Granger', 'Popol and Kupa', 'Harith', 0, NULL),
(5, 38224, 'gilgamesh', 'Justin Zamora', NULL, '823746591', 'Mythical Honor', 28, 'Mythical Immortal', 102, 'Tank', 'Tigreal', 'Ghatotkacha', 'Edith', 0, NULL),
(6, 38224, 'neuvillette', 'Kevin Gelig', NULL, '938475610', 'Mythical Glory', 76, 'Mythical Immortal', 109, 'Fighter', 'Balmond', 'Martis', 'Dyrroth', 0, NULL),
(7, 86771, 'DarkNova', 'Jordan Rivera', NULL, '948273561', 'Mythic', 13, 'Mythical Glory', 54, 'Fighter', 'Freya', 'Alpha', 'Sun', 0, NULL),
(8, 86771, 'Zanerift', 'Miguel Santos', NULL, '895627481', 'Epic I', 4, 'Mythic', 13, 'Mage', 'Gord', 'Valir', 'Vexana', 0, NULL),
(9, 86771, 'frostbyte', 'Enzo Delgado', NULL, '934758261', 'Legend I', 2, 'Mythical Honor', 27, 'Fighter', 'Ghatotkacha', 'Dyrroth', 'Yu Zhong', 0, NULL),
(10, 86771, 'nightcrawler', 'Kevin Uy', NULL, '879345672', 'Mythic', 7, 'Mythic', 24, 'Marksman', 'Ixia', 'Popol and Kupa', 'Natan', 0, NULL),
(11, 86771, 'SkyeFlare', 'Rafael Cruz', NULL, '918273645', 'Epic II', 3, 'Legend III', 3, 'Support', 'Rafaela', 'Mathilda', 'Chip', 0, NULL),
(12, 81346, 'VOIDSNAP', 'James Leo', NULL, '976384512', 'Mythic', 5, 'Mythical Glory', 67, 'Assassin', 'Hayabusa', 'Benedetta', 'Lancelot', 0, NULL),
(13, 81346, 'CrysTitan', 'Angelo Torres', NULL, '903847162', 'Legend II', 4, 'Mythical Honor', 26, 'Fighter', 'Aldous', 'Masha', 'X.Borg', 0, NULL),
(14, 81346, 'novarea', 'Mark Mendoza', NULL, '884736291', 'Epic III', 3, 'Legend IV', 3, 'Mage', 'Cecilion', 'Pharsa', 'Luo Yi', 0, NULL),
(15, 81346, 'BlitzCrank', 'Adrian Co', NULL, '965827430', 'Mythic', 11, 'Mythical Honor', 30, 'Marksman', 'Ixia', 'Miya', 'Karrie', 0, NULL),
(16, 81346, 'lightning', 'Dale Enriquez', NULL, '901283746', 'Legend I', 5, 'Mythical Honor', 44, 'Tank', 'Khufra', 'Atlas', 'Baxia', 0, NULL),
(17, 28670, 'Kenzo', 'Kenzo Aguilar', NULL, '937462851', 'Mythical Glory', 56, 'Mythical Immortal', 157, 'Fighter', 'Ruby', 'Benedetta', 'Lapu-Lapu', 0, NULL),
(18, 28670, 'Yuriii', 'Yuri Santos', NULL, '923748652', 'Mythical Glory', 78, 'Mythical Immortal', 207, 'Assassin', 'Fanny', 'Ling', 'Hayabusa', 0, NULL),
(19, 28670, 'whos drei?', 'Andrei Santos', NULL, '902837461', 'Mythical Glory', 55, 'Mythical Immortal', 149, 'Marksman', 'Granger', 'Claude', 'Irithel', 0, NULL),
(20, 28670, 'Luxx.', 'Trisha Santos', NULL, '978364219', 'Mythical Honor', 34, 'Mythical Immortal', 189, 'Mage', 'Kagura', 'Luo Yi', 'Lunox', 0, NULL),
(21, 28670, 'sai.', 'Isaih Dela Cruz', NULL, '995837461', 'Mythical Glory', 56, 'Mythical Immortal', 163, 'Tank', 'Tigreal', 'Chou', 'Jawhead', 0, NULL),
(22, 96990, 'neo?', 'Neo Vince Veracruz', NULL, '942837561', 'Mythical Immortal', 108, 'Mythical Immortal', 789, 'Assassin', 'Hayabusa', 'Joy', 'Fanny', 0, NULL),
(23, 96990, 'ashlynx', 'Ashley Martinez', NULL, '934756102', 'Mythical Glory', 78, 'Mythical Immortal', 770, 'Mage', 'Valentina', 'Yve', 'Luo Yi', 0, NULL),
(24, 96990, 'renzyTzy', 'Lorenzo Garcia', NULL, '988273645', 'Mythical Immortal', 115, 'Mythical Immortal', 1031, 'Marksman', 'Moskov', 'Brody', 'Beatrix', 0, NULL),
(25, 96990, 'darkin clay', 'Clayton Navarro', NULL, '975384621', 'Mythical Immortal', 101, 'Mythical Immortal', 670, 'Fighter', 'Edith', 'Ghatotkacha', 'Lapu-Lapu', 0, NULL),
(26, 96990, 'iceice', 'Unice Montemayor', NULL, '973846210', 'Mythical Glory', 98, 'Mythical Immortal', 708, 'Support', 'Mathilda', 'Carmilla', 'Estes', 0, NULL),
(27, 54892, 'theooo', 'Theodore Lim', NULL, '973846210', 'Mythical Honor', 30, 'Mythical Glory', 89, 'Assassin', 'Alpha', 'Hayabusa', 'Joy', 0, NULL),
(28, 54892, 'juno', 'Juno Sebastion', NULL, '964782310', 'Mythical Honor', 32, 'Mythical Immortal', 121, 'Mage', 'Cecilion', 'Pharsa', 'Vexana', 0, NULL),
(29, 54892, 'eli..?', 'Elijah Mendoza', NULL, '919283745', 'Mythic', 7, 'Mythical Honor', 27, 'Support', 'Diggie', 'Angela', 'Floryn', 0, NULL),
(30, 54892, 'Blaise', 'Blaise Ramos', NULL, '947382614', 'Mythic', 23, 'Mythical Glory', 92, 'Fighter', 'Badang', 'Freya', 'Thamuz', 0, NULL),
(31, 54892, 'NASH.', 'Ignacio Herrerea', NULL, '939274851', 'Mythical Glory', 51, 'Mythical Immortal', 104, 'Marksman', 'Hanabi', 'Karrie', 'Lesley', 0, NULL),
(32, 78910, 'romeTzy', 'Jerome Tan', NULL, '902834761', 'Mythical Honor', 34, 'Mythical Glory', 89, 'Assassin', 'X.Borg', 'Hayabusa', 'Hanzo', 0, NULL),
(33, 78910, 'yasuo', 'Louie Fernandez', NULL, '998273645', 'Mythical Honor', 43, 'Mythical Glory', 78, 'Marksman', 'Hanabi', 'Beatrix', 'Harith', 0, NULL),
(34, 78910, 'vince', 'Vince Dizon', NULL, '933748296', 'Mythic', 23, 'Mythical Glory', 65, 'Mage', 'Eudora', 'Chang\'e', 'Zhask', 0, NULL),
(35, 78910, 'jaijai', 'Jhaiden Perez', NULL, '910284736', 'Mythic', 9, 'Mythical Honor', 43, 'Fighter', 'Yu Zhong', 'Minsitthar', 'Badang', 0, NULL),
(36, 78910, 'lionin', 'Leonidas Evangelista', NULL, '945827361', 'Mythic', 14, 'Mythical Honor', 44, 'Support', 'Estes', 'Hylos', 'Belerick', 0, NULL),
(37, 26601, 'Kianna?', 'Kianna Ong', NULL, '973264819', 'Mythical Honor', 30, 'Mythical Glory', 67, 'Mage', 'Kagura', 'Valir', 'Yve', 0, NULL),
(38, 26601, 'DreiTzy', 'Andrei Lao', NULL, '987364215', 'Legend IV', 3, 'Mythical Honor', 29, 'Assassin', 'Saber', 'Karina', 'Gusion', 0, NULL),
(39, 26601, 'zezz', 'Zevin Morales', NULL, '924738615', 'Mythical Honor', 25, 'Mythical Glory', 52, 'Marksman', 'Ixia', 'Natan', 'Irithel', 0, NULL),
(40, 26601, 'aurelion', 'Kael Salazar', NULL, '932874165', 'Mythical Honor', 25, 'Mythical Glory', 54, 'Tank', 'Akai', 'Uranus', 'Khufra', 0, NULL),
(41, 26601, 'riku', 'Rico Martinez', NULL, '975648213', 'Legend IV', 2, 'Mythical Honor', 43, 'Fighter', 'Thamuz', 'Leomord', 'Badang', 0, NULL),
(42, 72997, 'Kale', 'Caleb Torres', NULL, '991837264', 'Mythical Immortal', 190, 'Mythical Immortal', 1320, 'Assassin', 'Fanny', 'Lancelot', 'Ling', 0, NULL),
(43, 72997, 'gabbie', 'Gabriel Yao', NULL, '907182346', 'Mythical Immortal', 122, 'Mythical Immortal', 1289, 'Fighter', 'Chou', 'Lapu-Lapu', 'Benedetta', 0, NULL),
(44, 72997, 'whoszack', 'Zachary Pineda', NULL, '948263174', 'Mythical Glory', 98, 'Mythical Immortal', 1231, 'Marksman', 'Wanwan', 'Melissa', 'Beatrix', 0, NULL),
(45, 72997, 'rosie', 'Ren Dela Pena', NULL, '948263174', 'Mythical Immortal', 124, 'Mythical Immortal', 1452, 'Mage', 'Cecilion', 'Vexana', 'Kagura', 0, NULL),
(46, 72997, 'yuroichi', 'Yuijiro Tanaka', NULL, '948263174', 'Mythical Immortal', 121, 'Mythical Immortal', 1090, 'Tank', 'Khufra', 'Chou', 'Jawhead', 0, NULL),
(47, 98078, 'acethebeast', 'Ace Mariano', NULL, '976384512', 'Mythic', 23, 'Mythical Immortal', 122, 'Assassin', 'Benedetta', 'Hanzo', 'Gusion', 0, NULL),
(48, 98078, 'kiel TheGreat', 'Mikhail Santos', NULL, '918374625', 'Mythical Honor', 42, 'Mythical Glory', 98, 'Fighter', 'Suyou', 'Sun', 'Alpha', 0, NULL),
(49, 98078, 'jjomjjom', 'Jomar Delos Reyes', NULL, '927364815', 'Mythical Honor', 29, 'Mythical Glory', 78, 'Marksman', 'Clint', 'Layla', 'Moskov', 0, NULL),
(50, 98078, 'daxx.', 'Dax Guiterrez', NULL, '934762851', 'Mythic', 6, 'Mythical Glory', 65, 'Tank', 'Gloo', 'Uranus', 'Baxia', 0, NULL),
(51, 98078, 'reii', 'Reign Santos', NULL, '988263740', 'Mythical Honor', 41, 'Mythical Immortal', 132, 'Mage', 'Pharsa', 'Lunox', 'Kagura', 0, NULL),
(52, 64652, 'xuchii', 'Pauline Toledo', NULL, '4928231', 'Elite II', 2, 'Legend III', 5, 'Mage', 'Gord', 'Chang\'e', 'Nana', 0, NULL),
(53, 64652, 'Tartarus', 'Selwyn tolero', NULL, '4928232', 'Mythic', 24, 'Mythical Glory', 75, 'Marksman', 'Miya', 'Layla', 'Karrie', 0, NULL),
(54, 64652, 'Esper', 'Julianne Pena', NULL, '4928233', 'Legend IV', 5, 'Mythical Glory', 98, 'Tank', 'Akai', 'Grock', 'Johnson', 0, NULL),
(55, 64652, 'Rava', 'Angelo Langgomez', NULL, '4928234', 'Legend V', 5, 'Mythical Immortal', 128, 'Support', 'Estes', 'Angela', 'Floryn', 0, NULL),
(56, 64652, 'Daza', 'Isabelle Esquivel', NULL, '4928235', 'Legend IV', 5, 'Mythic', 24, 'Fighter', 'Balmond', 'Leomord', 'Yu Zhong', 0, NULL),
(57, 59427, 'xuchii', 'Pauline Toledo', NULL, '4928231', 'Grandmaster V', 4, 'Mythic', 23, 'Support', 'Estes', 'Angela', 'Floryn', 0, NULL),
(58, 55548, 'regina', 'Regina George', NULL, '4928236', 'Grandmaster II', 4, 'Mythic', 23, 'Tank', 'Atlas', 'Grock', 'Johnson', 0, NULL),
(59, 55548, 'Esper', 'Julianne Pena', NULL, '4928238', 'Mythic', 23, 'Mythic', 23, 'Mage', 'Nana', 'Valir', 'Vale', 0, NULL),
(60, 55548, 'Tartarus', 'Selwyn tolero', NULL, '4928239', 'Legend I', 4, 'Mythical Honor', 45, 'Assassin', 'Karina', 'Aamon', 'Nolan', 0, NULL),
(61, 55548, 'Rava', 'Angel Langgomez', NULL, '4928272', 'Legend II', 4, 'Mythical Honor', 48, 'Support', 'Estes', 'Floryn', 'Mathilda', 0, NULL),
(62, 55548, 'Izabelle', 'Isabelle Esquivel', NULL, '4928294', 'Legend V', 4, 'Mythical Honor', 48, 'Tank', 'Atlas', 'Johnson', 'Belerick', 0, NULL),
(63, 10766, 'rava', 'Angelo Langgomez', NULL, '4928235', 'Legend IV', 4, 'Mythical Honor', 45, 'Tank', 'Tigreal', 'Franco', 'Grock', 0, NULL),
(64, 10766, 'xuchii', 'Pauline Toledo', NULL, '4928232', 'Legend V', 4, 'Mythic', 24, 'Assassin', 'Saber', 'Aamon', 'Nolan', 0, NULL),
(65, 53932, 'xuchii', 'Pauline Toledo', NULL, '4928231', 'Epic I', 3, 'Mythic', 24, 'Fighter', NULL, NULL, NULL, 624, NULL),
(66, 53932, 'Tartarus', 'Selwyn tolero', NULL, '4928239', 'Epic II', 5, 'Mythical Honor', 48, 'Mage', NULL, NULL, NULL, 900, NULL),
(67, 42704, 'bimby', 'bimb aquino', NULL, '4928231', 'Epic I', 2, 'Mythical Glory', 59, 'Fighter', NULL, NULL, NULL, 659, NULL),
(68, 42704, 'Tartarus', 'Selwyn tolero', NULL, '4928239', 'Legend V', 5, 'Mythical Immortal', 120, 'Mage', NULL, NULL, NULL, 720, NULL),
(70, 60828, 'Esper', 'Julianne Pena', NULL, '4928231', 'Epic II', 5, 'Mythical Glory', 95, 'Mage', NULL, NULL, NULL, 695, NULL),
(71, 60828, 'Tartarus', 'Selwyn tolero', NULL, '4928239', 'Epic II', 4, 'Mythical Honor', 45, 'Assassin', NULL, NULL, NULL, 645, NULL),
(72, 88242, 'Esper', 'Julianne Pena', NULL, '4928239', 'Mythic', 24, 'Mythical Honor', 49, 'Mage', NULL, NULL, NULL, 649, NULL),
(73, 88242, 'xuchii', 'Pauline Toledo', NULL, '4928231', 'Legend V', 5, 'Mythical Glory', 78, 'Fighter', NULL, NULL, NULL, 678, NULL),
(74, 71837, 'xuchii', 'Pauline Toledo', NULL, '4928239', 'Epic II', 5, 'Mythical Glory', 87, 'Fighter', NULL, NULL, NULL, 687, NULL),
(75, 71837, 'Esper', 'Julianne Pena', NULL, '1341234', 'Epic III', 5, 'Mythical Honor', 44, 'Fighter', NULL, NULL, NULL, 644, NULL),
(77, 99569, 'xuchii', 'Pauline Toledo', NULL, '4928239', 'Epic II', 5, 'Mythic', 24, 'Assassin', NULL, NULL, NULL, 624, NULL),
(82, 43844, 'Tartarus', 'Selwyn tolero', NULL, '4928239', 'Mythic', 24, 'Mythical Honor', 37, 'Mage', 'Eudora', 'Valir', 'Valentina', 637, NULL),
(83, 43844, 'Esper', 'Julianne Pena', NULL, '4928231', 'Legend IV', 5, 'Mythical Honor', 44, 'Fighter', 'Freya', 'Minsitthar', 'Dyrroth', 644, NULL),
(84, 58871, 'xuchi', 'Pauline Toledo', NULL, '4928239', 'Legend I', 4, 'Mythic', 23, 'Tank', 'Akai', 'Gloo', 'Grock', 623, NULL),
(85, 58871, 'Tartarus', 'Selwyn Tolero', NULL, '4928236', 'Mythic', 24, 'Mythical Glory', 94, 'Fighter', 'Freya', 'Martis', 'Masha', 694, NULL),
(86, 58871, 'Esper', 'Julianne Pena', NULL, '4928245', 'Legend V', 5, 'Mythical Glory', 99, 'Assassin', 'Karina', 'Aamon', 'Nolan', 699, NULL),
(87, 58871, 'rav', 'Angelo John Langgomez', NULL, '4928298', 'Legend IV', 5, 'Mythical Honor', 49, 'Mage', 'Nana', 'Valir', 'Xavier', 649, NULL),
(88, 58871, 'Sadeem Rakesh', 'Francisco Olpindo IV', NULL, '4928289', 'Legend IV', 5, 'Mythical Glory', 97, 'Marksman', 'Bruno', 'Moskov', 'Irithel', 697, NULL),
(89, 54124, 'Emers', 'Emerley Quiambao', NULL, '4928227', 'Legend IV', 5, 'Mythical Glory', 78, 'Tank', 'Franco', 'Grock', 'Johnson', 678, NULL),
(90, 54124, 'Hihers', 'Hilary Duff', NULL, '4928278', 'Mythic', 24, 'Mythical Glory', 99, 'Fighter', 'Chou', 'Masha', 'Aldous', 699, NULL),
(91, 54124, 'Mimasaur', 'Mimaroo Zubaru', NULL, '1341234', 'Epic II', 5, 'Mythical Honor', 49, 'Assassin', 'Saber', 'Aamon', 'Yi Sun-shin', 649, NULL),
(92, 54124, 'Jijajurs', 'JunJun Marquez', NULL, '4928231', 'Mythic', 24, 'Mythical Glory', 99, 'Mage', 'Eudora', 'Chang\'e', 'Lunox', 699, NULL),
(93, 54124, 'Jemma', 'Jemma Marbles', NULL, '4928236', 'Legend V', 5, 'Mythical Honor', 49, 'Marksman', 'Bruno', 'Granger', 'Brody', 649, NULL),
(94, 52504, 'Tartarus', 'Selwyn Tolero', NULL, '43526717', 'Master II', 4, 'Epic II', 5, 'Marksman', 'Layla', 'Popol and Kupa', 'Brody', 405, NULL),
(95, 94903, 'Tartraus', 'Selwyn Tolero', NULL, 'Selwyn', 'Elite II', 1, 'Elite III', 3, 'Marksman', 'Fanny', 'Chou', 'Masha', 103, NULL),
(97, 65925, 'Shizowa', 'Selwyn Retome', NULL, '1234567', 'Warrior I', 2, 'Legend I', 4, 'Mage', 'Guinevere', 'Dyrroth', 'Masha', 504, NULL),
(98, 65925, 'Yuwa', 'C Borealis', NULL, '123567482', 'Elite III', 1, 'Master II', 2, 'Support', 'Chou', 'Dyrroth', 'Masha', 202, NULL),
(99, 65925, 'raava', 'Angelo Veracruz', NULL, '2023010550', 'Mythical Immortal', 200, 'Mythical Immortal', 500, 'Assassin', 'Fanny', 'Joy', 'Suyou', 1100, NULL),
(100, 65925, 'Waw', 'Justic Lopez', NULL, '26326374', 'Warrior III', 2, 'Elite II', 3, 'Support', 'Dyrroth', 'Ruby', 'Aldous', 103, NULL),
(101, 65925, 'ducati', 'Ducati Cole', NULL, '2023010223', 'Mythical Immortal', 100, 'Mythical Immortal', 150, 'Support', 'Tigreal', 'Angela', 'Floryn', 750, NULL),
(102, 65925, 'Cuthrus', 'Stacy Lugares', NULL, '2648273873', 'Master I', 3, 'Epic V', 4, 'Support', 'Karina', 'Leomord', 'Ruby', 404, NULL),
(103, 26091, 'impact', 'christian roldan', NULL, '20000', 'Grandmaster V', 4, 'Legend I', 3, 'Marksman', 'Balmond', 'Chou', 'Edith', 503, NULL),
(104, 26091, 'Yenyen', 'Yestin Guarin', NULL, '2023010253', 'Warrior I', 1, 'Warrior II', 1, 'Support', 'Balmond', 'Karina', 'Karina', 1, NULL),
(105, 26091, 'kikikaka', 'Kiki Kaka', NULL, '2023010229', 'Mythic', 5, 'Mythical Glory', 56, 'Support', 'Estes', 'Chip', 'Diggie', 656, NULL),
(106, 26091, 'Guarin', 'Guarinney', NULL, '2020302928', 'Master I', 1, 'Master I', 1, 'Coach', 'Jawhead', 'Argus', 'Balmond', 201, NULL),
(107, 26091, 'Guareenz', 'Isabella Marimar', NULL, '202371802', 'Legend I', 4, 'Mythical Glory', 67, 'Marksman', 'Sun', 'Moskov', 'Granger', 667, NULL),
(108, 51675, 'TARE', 'Selwyn Tolero', NULL, '0905270', 'Epic III', 1, 'Epic II', 4, 'Coach', 'Karina', 'Aldous', 'Hayabusa', 404, NULL),
(109, 51675, 'xuchibers', 'Maria Mercedes', NULL, '45267384', 'Master III', 4, 'Grandmaster I', 5, 'Tank', 'Tigreal', 'Franco', 'Grock', 305, NULL),
(110, 51675, 'Kangkuri', 'Kang Saebok', NULL, '202819471', 'Legend V', 3, 'Mythical Glory', 67, 'Marksman', 'Moskov', 'Karrie', 'Popol and Kupa', 667, NULL),
(111, 51675, 'Hello', 'Test', NULL, '0905270', 'Grandmaster III', 2, 'Grandmaster IV', 3, 'Support', 'Jawhead', 'Sun', 'Masha', 303, NULL),
(112, 51675, 'MAKSIBELS', 'Isabell Esquivel', NULL, '56374829', 'Grandmaster I', 5, 'Grandmaster V', 5, 'Mage', 'Nana', 'Valir', 'Chang\'e', 305, NULL),
(113, 49784, 'Fourth', 'francisco', NULL, '72829', NULL, NULL, NULL, NULL, 'Coach', 'Hayabusa', 'Natalia', 'Jawhead', 203, NULL),
(114, 49784, 'xuchibels', 'Pauline Toledo', NULL, '43526172', NULL, NULL, NULL, NULL, 'Mage', 'Nana', 'Luo Yi', 'Chang\'e', 305, NULL),
(115, 49784, 'rava', 'Angelo Langgomez', NULL, '67483821', NULL, NULL, NULL, NULL, 'Marksman', 'Bruno', 'Popol and Kupa', 'Miya', 405, NULL),
(116, 49784, 'JezasKrays', 'Hesus Villena', NULL, '991736', NULL, NULL, NULL, NULL, 'Marksman', 'Fanny', 'Cyclops', 'Hayabusa', 204, NULL),
(117, 49784, 'Esper', 'Julianne Pena', NULL, '67838291', NULL, NULL, NULL, NULL, 'Tank', 'Tigreal', 'Atlas', 'Ghatotkacha', 505, NULL),
(118, 97086, 'Sejunahred', 'Sejun', NULL, '12345', NULL, NULL, NULL, NULL, 'Marksman', 'Miya', 'Lesley', 'Karrie', 1599, NULL),
(132, 20489, 'Test', 'Test', 'Test', 'Test', 'Warrior II', 0, 'Elite II', 3, 'Support', 'X.Borg', 'Fanny', 'Natalia', 103, NULL),
(133, 20489, 'ueud', 'hdhd', 'hshs', '737363', 'Elite II', 2, 'Elite III', 3, 'Support', 'Fanny', 'Hayabusa', 'Natalia', 103, NULL),
(134, 20489, 'Test', 'Test', 'hshshs', 'hdydhd', 'Elite II', 2, 'Elite I', 3, 'Marksman', 'Dyrroth', 'Masha', 'Masha', 103, NULL),
(135, 20489, 'mamamia', 'Paulina', 'Luners', '45637284', 'Master I', 4, 'Epic III', 5, 'Marksman', 'Bruno', 'Moskov', 'Clint', 405, NULL),
(136, 20489, 'Test', 'Test', 'Test', 'Test', 'Warrior II', 2, 'Elite III', 3, 'Support', 'X.Borg', 'Masha', 'Silvanna', 103, NULL),
(152, 96697, 'xuchi', 'Pauline', 'Toledo', '526471838', 'Elite IV', 3, 'Mythic', 24, 'Tank', 'Tigreal', 'Franco', 'Grock', 624, NULL),
(153, 96697, 'taropus', 'Brent', 'Sanchez', '556231456', 'Warrior I', 2, 'Mythical Immortal', 123, 'Marksman', 'Ling', 'Leomord', 'Masha', 723, NULL),
(154, 96697, 'Esper', 'Julianne', 'Esper', '627374819', 'Master II', 4, 'Legend III', 5, 'Assassin', 'Karina', 'Fanny', 'Joy', 505, NULL),
(155, 96697, 'yori', 'Andrew', 'Dimagiba', '563245167', 'Elite II', 2, 'Mythical Immortal', 120, 'Support', 'Aldous', 'Alpha', 'Masha', 720, NULL),
(156, 96697, 'Rava', 'Angelo', 'Langgomez', '1637488294', 'Master II', 4, 'Legend V', 5, 'Mage', 'Eudora', 'Valir', 'Vale', 505, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prooffiles`
--

CREATE TABLE `tbl_prooffiles` (
  `Proof_ID` int(11) NOT NULL,
  `Verification_ID` int(11) DEFAULT NULL,
  `File_Path` varchar(255) DEFAULT NULL,
  `Battle_ID` varchar(255) DEFAULT 'Not Found',
  `Result_Status` enum('Victory','Defeat','Not Found') DEFAULT 'Not Found'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prooffiles`
--

INSERT INTO `tbl_prooffiles` (`Proof_ID`, `Verification_ID`, `File_Path`, `Battle_ID`, `Result_Status`) VALUES
(1, 33, '../uploads/match_proofs/proof_67f80bda230bc7.68626100.PNG', NULL, NULL),
(2, 33, '../uploads/match_proofs/proof_67f80bda249c30.81149445.PNG', NULL, NULL),
(3, 34, '../uploads/match_proofs/proof_67f812d3962215.60305508.PNG', NULL, NULL),
(4, 34, '../uploads/match_proofs/proof_67f812d3efc662.28612229.PNG', NULL, NULL),
(5, 35, '../uploads/match_proofs/proof_67f8134a302b64.29829202.PNG', NULL, NULL),
(6, 35, '../uploads/match_proofs/proof_67f8134a7c2710.68342404.PNG', NULL, NULL),
(7, 36, '../uploads/match_proofs/proof_67f819a8922d56.01919936.PNG', NULL, NULL),
(8, 36, '../uploads/match_proofs/proof_67f819a893fd15.19015568.PNG', NULL, NULL),
(9, 37, '../uploads/match_proofs/proof_67f81a0db7e275.79384270.PNG', NULL, NULL),
(10, 37, '../uploads/match_proofs/proof_67f81a0db98794.51791520.PNG', NULL, NULL),
(11, 38, '../uploads/match_proofs/proof_67f81dfb6e6e59.29432811.PNG', 'Not Found', 'Not Found'),
(12, 38, '../uploads/match_proofs/proof_67f81dfbc5de42.79445483.PNG', 'Not Found', 'Not Found'),
(13, 39, '../uploads/match_proofs/proof_67f81e53f3ee81.78211754.PNG', 'Not Found', 'Not Found'),
(14, 39, '../uploads/match_proofs/proof_67f81e54397407.02748440.jpeg', 'Not Found', 'Not Found'),
(15, 39, '../uploads/match_proofs/proof_67f81e5465dda2.19298209.jpeg', 'Not Found', 'Not Found'),
(16, 40, '../uploads/match_proofs/proof_67f82a9a380ca8.15555114.jpeg', 'Not Found', 'Not Found'),
(17, 40, '../uploads/match_proofs/proof_67f82a9a94efb7.16553636.jpeg', 'Not Found', 'Not Found'),
(18, 41, '../uploads/match_proofs/proof_67f8a5896e29c0.08189608.PNG', 'Not Found', 'Not Found'),
(19, 41, '../uploads/match_proofs/proof_67f8a589c08973.77276533.PNG', 'Not Found', 'Not Found'),
(20, 41, '../uploads/match_proofs/proof_67f8a58a009052.30023106.jpeg', 'Not Found', 'Not Found'),
(21, 46, '../uploads/match_proofs/proof_6808acc33654d0.82928991.PNG', 'Not Found', 'Not Found'),
(22, 47, '../uploads/match_proofs/proof_6808ad3d6ccea8.69041454.PNG', 'Not Found', 'Not Found'),
(23, 47, '../uploads/match_proofs/proof_6808ad3d99c271.97447494.PNG', 'Not Found', 'Not Found'),
(24, 47, '../uploads/match_proofs/proof_6808ad3dc01081.34347440.PNG', 'Not Found', 'Not Found'),
(25, 48, '../uploads/match_proofs/proof_6808ae753e4b41.35908090.PNG', 'Not Found', 'Not Found'),
(26, 48, '../uploads/match_proofs/proof_6808ae75696479.60495580.PNG', 'Not Found', 'Not Found'),
(27, 48, '../uploads/match_proofs/proof_6808ae758e53e6.52315235.PNG', 'Not Found', 'Not Found'),
(28, 49, '../uploads/match_proofs/proof_6808aed4a6d941.66843422.PNG', 'Not Found', 'Not Found'),
(29, 49, '../uploads/match_proofs/proof_6808aed4d208f8.67019624.PNG', 'Not Found', 'Not Found'),
(30, 49, '../uploads/match_proofs/proof_6808aed5031143.13582050.PNG', 'Not Found', 'Not Found'),
(31, 49, '../uploads/match_proofs/proof_6808aed52bd044.95476948.jpeg', 'Not Found', 'Not Found'),
(32, 49, '../uploads/match_proofs/proof_6808aed563bd75.53238496.jpeg', 'Not Found', 'Not Found'),
(33, 50, '../uploads/match_proofs/proof_6808b198187299.96922475.PNG', 'Not Found', 'Not Found'),
(34, 50, '../uploads/match_proofs/proof_6808b19852b357.74278923.PNG', 'Not Found', 'Not Found'),
(35, 50, '../uploads/match_proofs/proof_6808b1987b93a2.75421087.PNG', 'Not Found', 'Not Found'),
(36, 51, '../uploads/match_proofs/proof_6808b3604fd787.81082668.PNG', 'Not Found', 'Not Found'),
(37, 51, '../uploads/match_proofs/proof_6808b3607ae5c8.21489221.PNG', 'Not Found', 'Not Found'),
(38, 51, '../uploads/match_proofs/proof_6808b360a3c808.74380808.PNG', 'Not Found', 'Not Found'),
(39, 52, '../uploads/match_proofs/proof_6808b6a759e9f2.41964409.PNG', 'Not Found', 'Not Found'),
(40, 52, '../uploads/match_proofs/proof_6808b6a793c195.42538631.jpeg', 'Not Found', 'Not Found'),
(41, 52, '../uploads/match_proofs/proof_6808b6a7bbd6e3.05864305.jpeg', 'Not Found', 'Not Found'),
(42, 53, '../uploads/match_proofs/proof_6808b7d4eacc63.04246312.PNG', 'Not Found', 'Not Found'),
(43, 53, '../uploads/match_proofs/proof_6808b7d52b1469.11464463.jpeg', 'Not Found', 'Not Found'),
(44, 53, '../uploads/match_proofs/proof_6808b7d553cda5.59838255.jpeg', 'Not Found', 'Not Found'),
(45, 54, '../uploads/match_proofs/proof_6808b9c17d9097.69724590.PNG', 'Not found', 'Not Found'),
(46, 54, '../uploads/match_proofs/proof_6808b9c1ced004.20273546.PNG', 'Not found', 'Not Found'),
(47, 54, '../uploads/match_proofs/proof_6808b9c209ede7.52688806.PNG', 'Not found', 'Not Found'),
(48, 54, '../uploads/match_proofs/proof_6808b9c2421ec8.38840445.jpeg', 'Not found', 'Not Found'),
(49, 54, '../uploads/match_proofs/proof_6808b9c2727630.79809659.jpeg', 'Not found', 'Not Found'),
(50, 55, '../uploads/match_proofs/proof_6808bbb0c0b536.29278740.PNG', 'Not found', 'Not Found'),
(51, 55, '../uploads/match_proofs/proof_6808bbb106dc09.44010441.PNG', 'Not found', 'Not Found'),
(52, 55, '../uploads/match_proofs/proof_6808bbb132b880.54824847.PNG', 'Not found', 'Not Found'),
(53, 55, '../uploads/match_proofs/proof_6808bbb1605aa4.03664877.jpeg', 'Not found', 'Not Found'),
(54, 55, '../uploads/match_proofs/proof_6808bbb1906660.82238697.jpeg', 'Not found', 'Not Found'),
(55, 56, '../uploads/match_proofs/proof_6808bf5dabb995.19524301.PNG', 'Not found', 'Not Found'),
(56, 56, '../uploads/match_proofs/proof_6808bf5de2aaa1.83403839.jpeg', 'Not found', 'Not Found'),
(57, 56, '../uploads/match_proofs/proof_6808bf5e17b3f2.90660149.jpeg', 'Not found', 'Not Found'),
(58, 57, '../uploads/match_proofs/proof_6808c0240283b7.44105646.PNG', 'Not found', 'Not Found'),
(59, 57, '../uploads/match_proofs/proof_6808c02432ea69.76360439.jpeg', 'Not found', 'Not Found'),
(60, 57, '../uploads/match_proofs/proof_6808c0245bf6f3.56626351.jpeg', 'Not found', 'Not Found'),
(61, 58, '../uploads/match_proofs/proof_6808c052d61a24.82731051.PNG', 'Not found', 'Not Found'),
(62, 58, '../uploads/match_proofs/proof_6808c0530d9404.34983885.jpeg', 'Not found', 'Not Found'),
(63, 58, '../uploads/match_proofs/proof_6808c053392a31.86096202.jpeg', 'Not found', 'Not Found'),
(64, 59, '../uploads/match_proofs/proof_6808c0536b3471.21375039.PNG', 'Not found', 'Not Found'),
(65, 59, '../uploads/match_proofs/proof_6808c05393ed99.09966709.jpeg', 'Not found', 'Not Found'),
(66, 59, '../uploads/match_proofs/proof_6808c053c0bd88.34795998.jpeg', 'Not found', 'Not Found'),
(69, 61, '../uploads/match_proofs/proof_6808c5e97883b8.91548230.PNG', 'Not found', 'Not Found'),
(70, 61, '../uploads/match_proofs/proof_6808c5e9b6b976.82614611.jpeg', 'Not found', 'Not Found'),
(71, 61, '../uploads/match_proofs/proof_6808c5e9df1695.61490510.jpeg', 'Not found', 'Not Found'),
(72, 62, '../uploads/match_proofs/proof_6808c73a471d53.70658099.PNG', 'Not found', 'Not Found'),
(73, 62, '../uploads/match_proofs/proof_6808c73a76f067.74433650.jpeg', 'Not found', 'Not Found'),
(74, 62, '../uploads/match_proofs/proof_6808c73a9fcf96.60867472.jpeg', 'Not found', 'Not Found'),
(75, 63, '../uploads/match_proofs/proof_6808c9f86a05a9.85815841.jpeg', 'Not found', 'Not Found'),
(76, 63, '../uploads/match_proofs/proof_6808c9f895e3b0.47287473.PNG', 'Not found', 'Not Found'),
(77, 63, '../uploads/match_proofs/proof_6808c9f8bef887.26417997.jpeg', 'Not found', 'Not Found'),
(78, 64, '../uploads/match_proofs/proof_6808cb3e7e5b99.28067697.jpeg', 'Not found', 'Not Found'),
(79, 64, '../uploads/match_proofs/proof_6808cb3eab7706.25941134.PNG', 'Not found', 'Not Found'),
(80, 64, '../uploads/match_proofs/proof_6808cb3ed3d821.21206250.jpeg', 'Not found', 'Not Found'),
(81, 65, '../uploads/match_proofs/proof_6808cd830ec7d1.29623209.PNG', 'Not found', 'Not Found'),
(82, 65, '../uploads/match_proofs/proof_6808cd833e58a1.23353454.jpeg', 'Not found', 'Not Found'),
(83, 65, '../uploads/match_proofs/proof_6808cd83675a07.18886747.jpeg', 'Not found', 'Not Found'),
(84, 66, '../uploads/match_proofs/proof_6808cec8ccc353.83219443.PNG', 'Not found', 'Not Found'),
(85, 66, '../uploads/match_proofs/proof_6808cec90886a9.09336617.jpeg', 'Not found', 'Not Found'),
(86, 66, '../uploads/match_proofs/proof_6808cec931ae59.43760304.jpeg', 'Not found', 'Not Found'),
(87, 67, '../uploads/match_proofs/proof_6808ceef016129.93315636.PNG', 'Not found', 'Not Found'),
(88, 67, '../uploads/match_proofs/proof_6808ceef348bf7.03094324.jpeg', 'Not found', 'Not Found'),
(89, 67, '../uploads/match_proofs/proof_6808ceef5cf782.16579323.jpeg', 'Not found', 'Not Found'),
(90, 68, '../uploads/match_proofs/proof_6808d12db1f6f8.30428645.PNG', 'Not found', 'Not Found'),
(91, 68, '../uploads/match_proofs/proof_6808d12de16094.88713980.jpeg', 'Not found', 'Not Found'),
(92, 68, '../uploads/match_proofs/proof_6808d12e160d09.40597200.jpeg', 'Not found', 'Not Found'),
(93, 69, '../uploads/match_proofs/proof_6808d5c197e0f6.87318348.PNG', 'Not found', 'Not Found'),
(94, 69, '../uploads/match_proofs/proof_6808d5c1cec073.43476661.PNG', 'Not found', 'Not Found'),
(95, 69, '../uploads/match_proofs/proof_6808d5c2041be9.93225053.jpeg', 'Not found', 'Not Found'),
(96, 70, '../uploads/match_proofs/proof_6808d81f62a4e1.31377836.PNG', 'Not found', 'Not Found'),
(97, 70, '../uploads/match_proofs/proof_6808d81f8edcf1.75385061.jpeg', 'Not found', 'Not Found'),
(98, 70, '../uploads/match_proofs/proof_6808d81fb77007.33548541.jpeg', 'Not found', 'Not Found'),
(99, 71, '../uploads/match_proofs/proof_6808d8683daa92.45486907.PNG', 'Not found', 'Not Found'),
(100, 71, '../uploads/match_proofs/proof_6808d86866a927.38752459.PNG', 'Not found', 'Not Found'),
(101, 71, '../uploads/match_proofs/proof_6808d8688fd1a5.00121514.jpeg', 'Not found', 'Not Found'),
(102, 72, '../uploads/match_proofs/proof_6808da33564997.13951755.PNG', '739619517876286394', 'Defeat'),
(103, 72, '../uploads/match_proofs/proof_6808da36e9af19.65527068.PNG', '739720818974930542', 'Defeat'),
(104, 72, '../uploads/match_proofs/proof_6808da37b69d07.17595013.jpeg', '739619517876286394', 'Not Found'),
(105, 73, '../uploads/match_proofs/proof_6808dc482d6d84.74918126.PNG', '739619517876286394', 'Defeat'),
(106, 73, '../uploads/match_proofs/proof_6808dc492ae879.06518924.PNG', '739720818974930542', 'Defeat'),
(107, 73, '../uploads/match_proofs/proof_6808dc49d16218.70444049.jpeg', '739720818874930542', 'Victory'),
(108, 74, '../uploads/match_proofs/proof_6808f2eac80ab3.90341856.PNG', '739545584309252547', 'Defeat'),
(109, 74, '../uploads/match_proofs/proof_6808f2efca9454.61994751.jpeg', '739619517876286394', 'Not Found'),
(110, 74, '../uploads/match_proofs/proof_6808f2f0ad30e9.75336218.jpeg', '739720818874930542', 'Victory'),
(111, 75, '../uploads/match_proofs/proof_6808f412b03528.05334941.PNG', '739720818974930542', 'Not Found'),
(112, 75, '../uploads/match_proofs/proof_6808f413a4f4a9.06613190.jpeg', '739619517876286394', 'Not Found'),
(113, 75, '../uploads/match_proofs/proof_6808f414760ab5.06460260.jpeg', '739720818874930542', 'Not Found'),
(114, 76, '../uploads/match_proofs/proof_6808f491b41d95.35261794.PNG', '739545584309252547', 'Defeat'),
(115, 76, '../uploads/match_proofs/proof_6808f4935018b0.39790716.jpeg', '739619517876286394', 'Not Found'),
(116, 76, '../uploads/match_proofs/proof_6808f4942b5bf0.89089073.jpeg', '739720818874930542', 'Victory'),
(117, 77, '../uploads/match_proofs/proof_6808f4bdb9f1d4.04120485.PNG', '739619517876286394', 'Defeat'),
(118, 77, '../uploads/match_proofs/proof_6808f4beb1f443.58718959.PNG', '739720818974930542', 'Defeat'),
(119, 77, '../uploads/match_proofs/proof_6808f4bf95fc58.28822639.jpeg', '739619517876286394', 'Not Found'),
(120, 78, '../uploads/match_proofs/proof_6808f4d00abf16.35830201.PNG', '739720818974930542', 'Defeat'),
(121, 78, '../uploads/match_proofs/proof_6808f4d0d65c04.53528516.PNG', '739545584309252547', 'Defeat'),
(122, 78, '../uploads/match_proofs/proof_6808f4d1b5ab29.97647712.jpeg', '739720818874930542', 'Victory'),
(123, 79, '../uploads/match_proofs/proof_68091901280e11.37576967.PNG', '739720818974930542', 'Defeat'),
(124, 79, '../uploads/match_proofs/proof_68091904cffa04.04050609.PNG', '739545584309252547', 'Defeat'),
(125, 79, '../uploads/match_proofs/proof_680919058e31a0.98939020.png', '201965272562210724', 'Victory'),
(126, 80, '../uploads/match_proofs/proof_680924ddb6c1d4.73147456.png', '201965272562210724', 'Victory'),
(127, 80, '../uploads/match_proofs/proof_680924df101ba8.08795587.png', '202093683494426957', 'Defeat'),
(128, 80, '../uploads/match_proofs/proof_680924dfc18a89.80737122.png', '202171675805555293', 'Defeat'),
(129, 81, '../uploads/match_proofs/proof_6809252e1853e2.21841725.PNG', '201965272562210724', 'Defeat'),
(130, 81, '../uploads/match_proofs/proof_6809252ee671c6.03331116.PNG', '202093683494426957', 'Not Found'),
(131, 81, '../uploads/match_proofs/proof_6809252fbe2524.36310931.PNG', '202171675805555293', 'Victory'),
(132, 82, '../uploads/match_proofs/proof_6809254c2732a8.02493526.PNG', '201965272562210724', 'Defeat'),
(133, 82, '../uploads/match_proofs/proof_6809254cd8e120.79983458.PNG', '202093683494426957', 'Not Found'),
(134, 82, '../uploads/match_proofs/proof_6809254d92b710.58722894.PNG', '202171675805555293', 'Victory'),
(135, 83, '../uploads/match_proofs/proof_68092650d35032.52026494.PNG', '201965272562210724', 'Defeat'),
(136, 83, '../uploads/match_proofs/proof_68092651b4de23.07520995.PNG', '202093683494426957', 'Not Found'),
(137, 83, '../uploads/match_proofs/proof_680926526b8a12.44765311.PNG', '202171675805555293', 'Victory'),
(138, 84, '../uploads/match_proofs/proof_68092714050f36.79872875.png', '202216021342886650', 'Victory'),
(139, 84, '../uploads/match_proofs/proof_680927154d4ed3.12193692.png', '739372183595850689', 'Victory'),
(140, 84, '../uploads/match_proofs/proof_680927161218a8.59819256.png', '202314977389386851', 'Defeat'),
(141, 85, '../uploads/match_proofs/proof_68092738b78765.23787305.PNG', '202216021342886650', 'Defeat'),
(142, 85, '../uploads/match_proofs/proof_68092739725409.34749027.PNG', '739372183595850689', 'Defeat'),
(143, 85, '../uploads/match_proofs/proof_6809273a2ca428.30919474.PNG', '202314977389386851', 'Victory'),
(144, 86, '../uploads/match_proofs/proof_680928ff2211e0.69973089.PNG', '739402677863652640', 'Defeat'),
(145, 86, '../uploads/match_proofs/proof_68092900774923.48161598.PNG', '202409230446697934', 'Victory'),
(146, 86, '../uploads/match_proofs/proof_6809290134fbc1.15533404.PNG', '739428439077494364', 'Victory'),
(147, 87, '../uploads/match_proofs/proof_6809292851cfb9.12920973.png', '739402677863652640', 'Victory'),
(148, 87, '../uploads/match_proofs/proof_680929290eaee1.05896174.png', '202409230446697934', 'Defeat'),
(149, 87, '../uploads/match_proofs/proof_68092929c8f3d7.12183003.png', '739428439077494364', 'Defeat'),
(150, 88, '../uploads/match_proofs/proof_680929fb9beb53.64984819.PNG', '202216021342886650', 'Defeat'),
(151, 88, '../uploads/match_proofs/proof_680929fc6ffd78.67415897.PNG', '739372183595850689', 'Defeat'),
(152, 88, '../uploads/match_proofs/proof_680929fd2e6124.26467714.PNG', '202314977389386851', 'Victory'),
(153, 89, '../uploads/match_proofs/proof_68092a24309c51.75431458.png', '202216021342886650', 'Victory'),
(154, 89, '../uploads/match_proofs/proof_68092a24e27c11.00824936.png', '739372183595850689', 'Victory'),
(155, 89, '../uploads/match_proofs/proof_68092a25a57f67.83203255.png', '202314977389386851', 'Defeat'),
(156, 90, '../uploads/match_proofs/proof_68092dde9d3cf0.94179139.png', '739402677863652640', 'Victory'),
(157, 90, '../uploads/match_proofs/proof_68092ddfea13f8.44361434.png', '202409230446697934', 'Defeat'),
(158, 90, '../uploads/match_proofs/proof_68092de0994138.47593964.png', '739428439077494364', 'Defeat'),
(159, 91, '../uploads/match_proofs/proof_68092e2dc437b3.88566832.PNG', '739402677863652640', 'Defeat'),
(160, 91, '../uploads/match_proofs/proof_68092e2e834805.02098530.PNG', '202409230446697934', 'Victory'),
(161, 91, '../uploads/match_proofs/proof_68092e2f356629.20763506.PNG', '739428439077494364', 'Victory'),
(162, 92, '../uploads/match_proofs/proof_68092e74434925.35663821.PNG', '202216021342886650', 'Defeat'),
(163, 92, '../uploads/match_proofs/proof_68092e74ed7da2.97522770.PNG', '739372183595850689', 'Defeat'),
(164, 92, '../uploads/match_proofs/proof_68092e75a18e97.49610382.PNG', '202314977389386851', 'Victory'),
(165, 93, '../uploads/match_proofs/proof_68092e99a44207.98115619.png', '202216021342886650', 'Victory'),
(166, 93, '../uploads/match_proofs/proof_68092e9a5a1611.09618152.png', '739372183595850689', 'Victory'),
(167, 93, '../uploads/match_proofs/proof_68092e9b08b466.16209237.png', '202314977389386851', 'Defeat'),
(168, 94, '../uploads/match_proofs/proof_68092f29a15aa0.86493825.PNG', '739402677863652640', 'Defeat'),
(169, 94, '../uploads/match_proofs/proof_68092f2a759973.32059297.PNG', '202409230446697934', 'Victory'),
(170, 94, '../uploads/match_proofs/proof_68092f2b2bbf64.07431836.PNG', '739428439077494364', 'Victory'),
(171, 95, '../uploads/match_proofs/proof_68092f51dc1452.77065967.png', '739402677863652640', 'Victory'),
(172, 95, '../uploads/match_proofs/proof_68092f52960c46.28008434.png', '202409230446697934', 'Defeat'),
(173, 95, '../uploads/match_proofs/proof_68092f53456f36.84894324.png', '739428439077494364', 'Defeat'),
(174, 96, '../uploads/match_proofs/proof_680937dcd66590.04714076.PNG', '739718774571741505', 'Victory'),
(175, 96, '../uploads/match_proofs/proof_680937de61aa29.06250343.PNG', '739735185641779905', 'Victory'),
(176, 96, '../uploads/match_proofs/proof_680937df274b51.58450044.PNG', '203407526875181942', 'Victory'),
(177, 96, '../uploads/match_proofs/proof_680937dfde6fc2.98037069.PNG', '739751184394957886', 'Defeat'),
(178, 96, '../uploads/match_proofs/proof_680937e09bee03.71395353.PNG', '739765310542394789', 'Defeat'),
(179, 97, '../uploads/match_proofs/proof_68093849122bf8.04402807.png', '739718774571741505', 'Defeat'),
(180, 97, '../uploads/match_proofs/proof_68093849d77247.68027178.png', '739735185641779905', 'Defeat'),
(181, 97, '../uploads/match_proofs/proof_6809384a996fb0.59702397.png', '203407526875181942', 'Defeat'),
(182, 97, '../uploads/match_proofs/proof_6809384b4d54c0.98271922.png', '739751184394957886', 'Victory'),
(183, 97, '../uploads/match_proofs/proof_6809384c087102.13824536.png', '739765310542394789', 'Victory'),
(184, 98, '../uploads/match_proofs/proof_68093a5dc24713.90402810.PNG', '739718774571741505', 'Victory'),
(185, 98, '../uploads/match_proofs/proof_68093a5f192e84.32925760.PNG', '739735185641779905', 'Victory'),
(186, 98, '../uploads/match_proofs/proof_68093a6007f852.52967656.PNG', '203407526875181942', 'Victory'),
(187, 98, '../uploads/match_proofs/proof_68093a60c1d886.87941797.PNG', '739751184394957886', 'Defeat'),
(188, 98, '../uploads/match_proofs/proof_68093a61743e63.41718339.PNG', '739765310542394789', 'Defeat'),
(189, 99, '../uploads/match_proofs/proof_68093a9ec36971.78458179.png', '739718774571741505', 'Defeat'),
(190, 99, '../uploads/match_proofs/proof_68093a9f8c9803.22681875.png', '739735185641779905', 'Defeat'),
(191, 99, '../uploads/match_proofs/proof_68093aa03c66f9.82825375.png', '203407526875181942', 'Defeat'),
(192, 99, '../uploads/match_proofs/proof_68093aa0e0dbf6.83951518.png', '739751184394957886', 'Victory'),
(193, 99, '../uploads/match_proofs/proof_68093aa18fe194.04268958.png', '739765310542394789', 'Victory'),
(194, 100, '../uploads/match_proofs/proof_68093bd2286f34.57423366.png', '739718774571741505', 'Defeat'),
(195, 100, '../uploads/match_proofs/proof_68093bd2edb744.15934934.png', '739735185641779905', 'Defeat'),
(196, 100, '../uploads/match_proofs/proof_68093bd3a89b67.66317855.png', '203407526875181942', 'Defeat'),
(197, 100, '../uploads/match_proofs/proof_68093bd4675213.05479620.png', '739751184394957886', 'Victory'),
(198, 100, '../uploads/match_proofs/proof_68093bd524f9f9.25651513.png', '739765310542394789', 'Victory'),
(199, 101, '../uploads/match_proofs/proof_68093c0cca8862.96848140.PNG', '739718774571741505', 'Victory'),
(200, 101, '../uploads/match_proofs/proof_68093c0d8859d4.05255753.PNG', '739735185641779905', 'Victory'),
(201, 101, '../uploads/match_proofs/proof_68093c0e4a6261.48288608.PNG', '203407526875181942', 'Victory'),
(202, 101, '../uploads/match_proofs/proof_68093c0ef1ba24.11192893.PNG', '739751184394957886', 'Defeat'),
(203, 101, '../uploads/match_proofs/proof_68093c0fa7a544.59949503.PNG', '739765310542394789', 'Defeat'),
(204, 102, '../uploads/match_proofs/proof_68093ca1eb4a00.94275891.png', '739402677863652640', 'Victory'),
(205, 102, '../uploads/match_proofs/proof_68093ca2a21564.89462957.png', '202409230446697934', 'Defeat'),
(206, 102, '../uploads/match_proofs/proof_68093ca3555729.32310774.png', '739428439077494364', 'Defeat'),
(207, 103, '../uploads/match_proofs/proof_68093ccee01453.84038286.PNG', '739402677863652640', 'Defeat'),
(208, 103, '../uploads/match_proofs/proof_68093ccfa921d4.75630375.PNG', '202409230446697934', 'Victory'),
(209, 103, '../uploads/match_proofs/proof_68093cd06f6ab0.48963557.PNG', '739428439077494364', 'Victory'),
(210, 104, '../uploads/match_proofs/proof_68093e863428c6.64234340.png', '202216021342886650', 'Victory'),
(211, 104, '../uploads/match_proofs/proof_68093e87c9b0a7.24265487.png', '739372183595850689', 'Victory'),
(212, 104, '../uploads/match_proofs/proof_68093e8884f734.15126603.png', '202314977389386851', 'Defeat'),
(213, 105, '../uploads/match_proofs/proof_68093f216198d9.60666777.PNG', '202216021342886650', 'Defeat'),
(214, 105, '../uploads/match_proofs/proof_68093f22394c28.45922414.PNG', '739372183595850689', 'Defeat'),
(215, 105, '../uploads/match_proofs/proof_68093f2300dc75.06804481.PNG', '202314977389386851', 'Victory'),
(216, 106, '../uploads/match_proofs/proof_680941a0388948.49774872.png', '739718774571741505', 'Defeat'),
(217, 106, '../uploads/match_proofs/proof_680941a1884390.76518572.png', '739735185641779905', 'Defeat'),
(218, 106, '../uploads/match_proofs/proof_680941a24afad9.19785927.png', '203407526875181942', 'Defeat'),
(219, 106, '../uploads/match_proofs/proof_680941a30133c4.17541422.png', '739751184394957886', 'Victory'),
(220, 106, '../uploads/match_proofs/proof_680941a3ab4d37.57939647.png', '739765310542394789', 'Victory'),
(221, 107, '../uploads/match_proofs/proof_680941e327d9b1.56043002.PNG', '739718774571741505', 'Victory'),
(222, 107, '../uploads/match_proofs/proof_680941e40bec42.23530150.PNG', '739735185641779905', 'Victory'),
(223, 107, '../uploads/match_proofs/proof_680941e4ce67e8.09929636.PNG', '203407526875181942', 'Victory'),
(224, 107, '../uploads/match_proofs/proof_680941e58fcc52.59719243.PNG', '739751184394957886', 'Defeat'),
(225, 107, '../uploads/match_proofs/proof_680941e64d7828.21024239.PNG', '739765310542394789', 'Defeat'),
(226, 108, '../uploads/match_proofs/proof_6809423ebeb892.67189440.PNG', '202216021342886650', 'Defeat'),
(227, 108, '../uploads/match_proofs/proof_6809423f9a67e8.22672205.PNG', '739372183595850689', 'Defeat'),
(228, 108, '../uploads/match_proofs/proof_6809424058f392.62732043.PNG', '202314977389386851', 'Victory'),
(229, 109, '../uploads/match_proofs/proof_680942684eb9f9.38538626.png', '202216021342886650', 'Victory'),
(230, 109, '../uploads/match_proofs/proof_680942690d1db6.59044303.png', '739372183595850689', 'Victory'),
(231, 109, '../uploads/match_proofs/proof_68094269bb8107.01369288.png', '202314977389386851', 'Defeat'),
(232, 110, '../uploads/match_proofs/proof_6809482e7434b8.07396480.PNG', '739402677863652640', 'Defeat'),
(233, 110, '../uploads/match_proofs/proof_6809482fc238d6.88499154.PNG', '202409230446697934', 'Victory'),
(234, 110, '../uploads/match_proofs/proof_68094830847677.75810138.PNG', '739428439077494364', 'Victory'),
(235, 111, '../uploads/match_proofs/proof_68094858d405c6.81241506.png', '739402677863652640', 'Victory'),
(236, 111, '../uploads/match_proofs/proof_6809485995a6b0.75864862.png', '202409230446697934', 'Defeat'),
(237, 111, '../uploads/match_proofs/proof_6809485a4f90f9.66655132.png', '739428439077494364', 'Defeat'),
(238, 112, '../uploads/match_proofs/proof_6809c839466e07.53764205.PNG', '739402677863652640', 'Defeat'),
(239, 112, '../uploads/match_proofs/proof_6809c83e9a8729.34925278.PNG', '202409230446697934', 'Victory'),
(240, 112, '../uploads/match_proofs/proof_6809c83fdea589.45868989.PNG', '739428439077494364', 'Victory'),
(241, 113, '../uploads/match_proofs/proof_6809c88383b024.48194952.png', '739402677863652640', 'Victory'),
(242, 113, '../uploads/match_proofs/proof_6809c884c33969.55164425.png', '202409230446697934', 'Defeat'),
(243, 113, '../uploads/match_proofs/proof_6809c885f37729.66124010.png', '739428439077494364', 'Defeat'),
(244, 114, '../uploads/match_proofs/proof_6809e23ec00cb0.29801656.png', '739718774571741505', 'Defeat'),
(245, 114, '../uploads/match_proofs/proof_6809e23fe942c5.04613734.png', '739735185641779905', 'Defeat'),
(246, 114, '../uploads/match_proofs/proof_6809e2409bf2b1.20154197.png', '203407526875181942', 'Defeat'),
(247, 114, '../uploads/match_proofs/proof_6809e2414c01d7.09860639.png', '739751184394957886', 'Victory'),
(248, 114, '../uploads/match_proofs/proof_6809e241f089c5.46259426.png', '739765310542394789', 'Victory'),
(249, 115, '../uploads/match_proofs/proof_6809e266ac93e5.72658464.png', '739765310542394789', 'Victory'),
(250, 115, '../uploads/match_proofs/proof_6809e267611e69.62155863.png', '739718774571741505', 'Defeat'),
(251, 115, '../uploads/match_proofs/proof_6809e2680ef0c0.11269692.png', '739735185641779905', 'Defeat'),
(252, 115, '../uploads/match_proofs/proof_6809e268b09f26.76639008.png', '203407526875181942', 'Defeat'),
(253, 115, '../uploads/match_proofs/proof_6809e2695c4e88.58641247.png', '739751184394957886', 'Victory'),
(254, 116, '../uploads/match_proofs/proof_6809e30314efd9.55256190.PNG', '739718774571741505', 'Victory'),
(255, 116, '../uploads/match_proofs/proof_6809e3040243f5.83794598.PNG', '739735185641779905', 'Victory'),
(256, 116, '../uploads/match_proofs/proof_6809e304a95ee4.31899949.PNG', '203407526875181942', 'Victory'),
(257, 116, '../uploads/match_proofs/proof_6809e3055ef222.81109048.PNG', '739751184394957886', 'Defeat'),
(258, 116, '../uploads/match_proofs/proof_6809e3060eab17.61661392.PNG', '739765310542394789', 'Defeat'),
(259, 117, '../uploads/match_proofs/proof_6809e3c75a4042.30058029.PNG', '739402677863652640', 'Defeat'),
(260, 117, '../uploads/match_proofs/proof_6809e3c81759b1.00932608.PNG', '202409230446697934', 'Victory'),
(261, 117, '../uploads/match_proofs/proof_6809e3c8c52406.21506717.PNG', '739428439077494364', 'Victory'),
(262, 118, '../uploads/match_proofs/proof_6809e44c289183.29400905.png', '739402677863652640', 'Victory'),
(263, 118, '../uploads/match_proofs/proof_6809e44cda5140.18179217.png', '202409230446697934', 'Defeat'),
(264, 118, '../uploads/match_proofs/proof_6809e44d898db5.71724102.png', '739428439077494364', 'Defeat'),
(265, 119, '../uploads/match_proofs/proof_6809e9c8ead3d3.84273678.PNG', '739402677863652640', 'Defeat'),
(266, 119, '../uploads/match_proofs/proof_6809e9cc79a130.03837480.PNG', '202409230446697934', 'Victory'),
(267, 119, '../uploads/match_proofs/proof_6809e9cd343237.38746368.PNG', '739428439077494364', 'Victory'),
(268, 120, '../uploads/match_proofs/proof_6809e9ce052b23.35224251.PNG', '739402677863652640', 'Defeat'),
(269, 120, '../uploads/match_proofs/proof_6809e9ceb49203.24323608.PNG', '202409230446697934', 'Victory'),
(270, 120, '../uploads/match_proofs/proof_6809e9cf66b962.58957208.PNG', '739428439077494364', 'Victory'),
(271, 121, '../uploads/match_proofs/proof_680bd5ebc1fe36.92879304.png', '202216021342886650', 'Victory'),
(272, 121, '../uploads/match_proofs/proof_680bd5efbff2f0.45716108.png', '739372183595850689', 'Victory'),
(273, 121, '../uploads/match_proofs/proof_680bd5f0ad0e49.19245138.png', '202314977389386851', 'Defeat'),
(274, 122, '../uploads/match_proofs/proof_680bd6ad0cfdb6.81378332.PNG', '202216021342886650', 'Defeat'),
(275, 122, '../uploads/match_proofs/proof_680bd6ae092e02.24933586.PNG', '739372183595850689', 'Defeat'),
(276, 122, '../uploads/match_proofs/proof_680bd6aec6b887.22739586.PNG', '202314977389386851', 'Victory'),
(277, 123, '../uploads/match_proofs/proof_680bd728b32e84.73522445.PNG', '739718774571741505', 'Victory'),
(278, 123, '../uploads/match_proofs/proof_680bd7298db4d4.91618597.PNG', '739735185641779905', 'Victory'),
(279, 123, '../uploads/match_proofs/proof_680bd72a4fd7b8.87927574.PNG', '203407526875181942', 'Victory'),
(280, 123, '../uploads/match_proofs/proof_680bd72b0a2c47.55860324.PNG', '739751184394957886', 'Defeat'),
(281, 123, '../uploads/match_proofs/proof_680bd72bb62782.84344836.PNG', '739765310542394789', 'Defeat'),
(282, 124, '../uploads/match_proofs/proof_680bda30a35333.25358522.PNG', '739718774571741505', 'Victory'),
(283, 124, '../uploads/match_proofs/proof_680bda31f35794.27125865.PNG', '739735185641779905', 'Victory'),
(284, 124, '../uploads/match_proofs/proof_680bda32a9fe07.89779246.PNG', '203407526875181942', 'Victory'),
(285, 124, '../uploads/match_proofs/proof_680bda3360d583.11541180.PNG', '739751184394957886', 'Defeat'),
(286, 124, '../uploads/match_proofs/proof_680bda341b3882.42123556.PNG', '739765310542394789', 'Defeat'),
(287, 125, '../uploads/match_proofs/proof_680bdadd5179e4.66855806.png', '739718774571741505', 'Defeat'),
(288, 125, '../uploads/match_proofs/proof_680bdade3ac744.77134244.png', '739735185641779905', 'Defeat'),
(289, 125, '../uploads/match_proofs/proof_680bdadee54141.84587006.png', '203407526875181942', 'Defeat'),
(290, 125, '../uploads/match_proofs/proof_680bdadf906d64.44210681.png', '739751184394957886', 'Victory'),
(291, 125, '../uploads/match_proofs/proof_680bdae043c1e4.06320909.png', '739765310542394789', 'Victory'),
(292, 126, '../uploads/match_proofs/proof_680bdb1d84ad25.45029771.PNG', '739718774571741505', 'Victory'),
(293, 126, '../uploads/match_proofs/proof_680bdb1e454bb2.06051028.PNG', '739735185641779905', 'Victory'),
(294, 126, '../uploads/match_proofs/proof_680bdb1ef334f8.62787754.PNG', '203407526875181942', 'Victory'),
(295, 126, '../uploads/match_proofs/proof_680bdb1fa655c6.21186101.PNG', '739751184394957886', 'Defeat'),
(296, 126, '../uploads/match_proofs/proof_680bdb205cb234.71682728.PNG', '739765310542394789', 'Defeat'),
(297, 127, '../uploads/match_proofs/proof_680e3b42be5df2.62028745.PNG', '202216021342886650', 'Defeat'),
(298, 127, '../uploads/match_proofs/proof_680e3b46afde85.56085658.PNG', '739372183595850689', 'Defeat'),
(299, 127, '../uploads/match_proofs/proof_680e3b47777f63.59002311.PNG', '202314977389386851', 'Victory'),
(300, 128, '../uploads/match_proofs/proof_680e3b93e39801.57216469.png', '202216021342886650', 'Victory'),
(301, 128, '../uploads/match_proofs/proof_680e3b9504eb39.62859009.png', '739372183595850689', 'Victory'),
(302, 128, '../uploads/match_proofs/proof_680e3b9624cf63.89990802.png', '202314977389386851', 'Defeat'),
(303, 129, '../uploads/match_proofs/proof_680e3bc579ffc2.58388059.PNG', '739718774571741505', 'Victory'),
(304, 129, '../uploads/match_proofs/proof_680e3bc646aad7.43482656.PNG', '739735185641779905', 'Victory'),
(305, 129, '../uploads/match_proofs/proof_680e3bc72e4f41.53978638.PNG', '203407526875181942', 'Victory'),
(306, 129, '../uploads/match_proofs/proof_680e3bc7ef3ed3.60913029.PNG', '739751184394957886', 'Defeat'),
(307, 129, '../uploads/match_proofs/proof_680e3bc8b778e0.43436270.PNG', '739765310542394789', 'Defeat'),
(308, 130, '../uploads/match_proofs/proof_680e3c23cd3f64.48972343.png', '739718774571741505', 'Defeat'),
(309, 130, '../uploads/match_proofs/proof_680e3c2499a334.51613818.png', '739735185641779905', 'Defeat'),
(310, 130, '../uploads/match_proofs/proof_680e3c255b51a4.16987952.png', '203407526875181942', 'Defeat'),
(311, 130, '../uploads/match_proofs/proof_680e3c2615e4a3.84946502.png', '739751184394957886', 'Victory'),
(340, 140, '/var/www/html/abyss/uploads/match_proofs/proof_680f3fa72477d2.26462277.png', '201965272562210724', 'Victory'),
(341, 140, '/var/www/html/abyss/uploads/match_proofs/proof_680f3fa7e8caa5.26158522.png', '202093683494426957', 'Defeat'),
(342, 140, '/var/www/html/abyss/uploads/match_proofs/proof_680f3fa8ae9111.65338193.png', '202171675805555293', 'Defeat'),
(343, 140, '/var/www/html/abyss/uploads/match_proofs/proof_680f3fa96aae78.85291620.png', '202216021342886650', 'Victory'),
(344, 140, '/var/www/html/abyss/uploads/match_proofs/proof_680f3faa2b5d37.55784910.png', '739372183595850689', 'Victory'),
(345, 144, '/var/www/html/abyss/uploads/match_proofs/proof_6810fa77a474f6.84799785.png', '202216021342886650', 'Victory'),
(346, 144, '/var/www/html/abyss/uploads/match_proofs/proof_6810fa78759c66.36912575.png', '739372183595850689', 'Victory'),
(347, 144, '/var/www/html/abyss/uploads/match_proofs/proof_6810fa79388a17.36215881.png', '202314977389386851', 'Defeat'),
(348, 146, '/var/www/html/abyss/uploads/match_proofs/proof_6810fb364747d1.11581086.png', '202216021342886650', 'Victory'),
(349, 146, '/var/www/html/abyss/uploads/match_proofs/proof_6810fb37189242.23624545.png', '739372183595850689', 'Victory'),
(350, 146, '/var/www/html/abyss/uploads/match_proofs/proof_6810fb37d89d64.10141210.png', '202314977389386851', 'Defeat');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `Report_ID` int(11) NOT NULL,
  `Reporter_ID` int(11) DEFAULT NULL,
  `Reported_User_ID` int(11) DEFAULT NULL,
  `Report_Category` varchar(255) DEFAULT NULL,
  `Report_Details` text DEFAULT NULL,
  `Proof_File` varchar(255) DEFAULT NULL,
  `Report_Status` enum('Pending','Reviewed','Action Taken','') DEFAULT NULL,
  `Date_Reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `Reviewed_By` int(255) DEFAULT NULL,
  `Sanction_Taken` text DEFAULT NULL,
  `Date_Reviewed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reports`
--

INSERT INTO `tbl_reports` (`Report_ID`, `Reporter_ID`, `Reported_User_ID`, `Report_Category`, `Report_Details`, `Proof_File`, `Report_Status`, `Date_Reported`, `Reviewed_By`, `Sanction_Taken`, `Date_Reviewed`) VALUES
(1, 10, 28670, 'Toxicity', 'hello', '../uploads/reports/report_67f57a3e69ccf0.75060334.png', 'Pending', '2025-04-08 19:34:22', NULL, NULL, NULL),
(2, 17, 28670, 'Toxicity', 'cdcdc', '../uploads/reports/report_67f57c10c7be02.30630043.png', 'Pending', '2025-04-08 19:42:08', NULL, NULL, NULL),
(3, 17, 28670, 'Other', 'cdcdc', NULL, 'Action Taken', '2025-04-08 19:44:52', NULL, NULL, '2025-04-29 16:18:43'),
(4, 17, 28670, 'Other', 'cdcdc', NULL, 'Pending', '2025-04-08 19:45:01', NULL, NULL, NULL),
(5, 17, 28670, 'Harassment', 'cdcdc', NULL, 'Pending', '2025-04-08 19:46:02', NULL, NULL, NULL),
(6, 17, 28670, 'Harassment', 'cdcdc', NULL, 'Pending', '2025-04-08 19:49:32', NULL, NULL, NULL),
(7, 17, 28670, 'Account Sharing', 'cdcdc', NULL, 'Pending', '2025-04-08 19:50:44', NULL, NULL, NULL),
(8, 17, 28670, 'Account Sharing', 'cdcdc', NULL, 'Pending', '2025-04-08 19:51:04', NULL, NULL, NULL),
(9, 17, 28670, 'Account Sharing', 'cdcdc', NULL, 'Pending', '2025-04-08 19:51:41', NULL, NULL, NULL),
(10, 17, 28670, 'Account Sharing', 'cdcdc', NULL, 'Pending', '2025-04-08 19:52:17', NULL, NULL, NULL),
(11, 17, 28670, 'Account Sharing', 'cdcdc', NULL, 'Pending', '2025-04-08 19:52:52', NULL, NULL, NULL),
(12, 10, 38224, 'Cheating', 'rerhe', NULL, 'Pending', '2025-04-09 05:34:17', NULL, NULL, NULL),
(13, 19, 28670, 'Toxicity', 'Britney Spears', '../uploads/reports/report_67f7c5d64c5839.43845512.jpg', 'Pending', '2025-04-10 13:21:26', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrimslog`
--

CREATE TABLE `tbl_scrimslog` (
  `Match_ID` int(11) NOT NULL,
  `Squad1_ID` int(11) DEFAULT NULL,
  `Squad2_ID` int(11) DEFAULT NULL,
  `Scheduled_Time` datetime DEFAULT NULL,
  `No_Of_Games` int(255) DEFAULT NULL,
  `Status` enum('Upcoming','Finished') DEFAULT 'Upcoming' COMMENT 'should be changing',
  `Winner_Squad_ID` int(11) DEFAULT NULL,
  `Winner_Score` int(11) DEFAULT NULL,
  `Loser_Score` int(11) DEFAULT NULL,
  `Screenshot_Proof` varchar(255) DEFAULT NULL,
  `Date_Submitted` datetime DEFAULT NULL,
  `OCR_Validated` tinyint(1) DEFAULT 0,
  `Verification_Submitted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_scrimslog`
--

INSERT INTO `tbl_scrimslog` (`Match_ID`, `Squad1_ID`, `Squad2_ID`, `Scheduled_Time`, `No_Of_Games`, `Status`, `Winner_Squad_ID`, `Winner_Score`, `Loser_Score`, `Screenshot_Proof`, `Date_Submitted`, `OCR_Validated`, `Verification_Submitted`) VALUES
(1, 98078, 28670, '2017-04-05 08:49:00', 5, 'Upcoming', 28670, 2, 0, 'basta nanalo pero dapat file path to', '2025-04-30 14:46:19', 1, 0),
(5, 98078, 28670, '2025-04-07 16:03:00', 7, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(7, 98078, 28670, '2025-04-11 00:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(8, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(9, 28670, 72997, '2025-04-21 00:00:00', 3, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(10, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(11, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(12, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(13, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(14, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(15, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(16, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(17, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(18, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(19, 72997, 28670, '2025-04-09 00:00:00', 7, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(20, 96990, 28670, '2025-04-21 00:00:00', 3, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(21, 55548, 28670, '2025-04-11 00:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(22, 28670, 55548, '2025-04-09 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(23, 55548, 28670, '2025-04-11 00:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(24, 53932, 55548, '2025-04-11 00:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(25, 55548, 53932, '2025-04-09 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 1),
(26, 43844, 28670, '2025-04-11 00:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(27, 53932, 55548, '2025-04-11 00:00:00', 3, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(28, 55548, 28670, '2025-04-10 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(29, 28670, 55548, '2025-04-07 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(30, 28670, 55548, '2025-04-09 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(31, 28670, 55548, '2025-04-03 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(32, 28670, 55548, '2025-04-08 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(33, 43844, 55548, '2025-04-08 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(34, 28670, 55548, '2025-04-09 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(35, 55548, 28670, '2025-04-11 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(36, 55548, 28670, '2025-04-11 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(37, 99569, 28670, '2025-04-04 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(38, 99569, 28670, '2025-04-14 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(39, 28670, 99569, '2025-02-21 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(40, 28670, 99569, '2025-02-03 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(41, 28670, 99569, '2025-04-01 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(42, 28670, 99569, '2025-04-06 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(43, 28670, 99569, '2025-04-16 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(44, 99569, 28670, '2025-04-04 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(45, 99569, 28670, '2025-04-10 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(46, 99569, 28670, '2025-04-15 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(47, 28670, 99569, '2025-04-02 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(48, 28670, 99569, '2025-04-10 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(49, 54124, 58871, '2025-04-21 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(50, 54124, 58871, '2025-04-22 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(51, 54124, 58871, '2025-04-23 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(52, 58871, 54124, '2025-04-17 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(53, 58871, 54124, '2025-04-18 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(54, 58871, 54124, '2025-04-19 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(55, 58871, 54124, '2025-04-18 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(56, 58871, 54124, '2025-04-04 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(57, 58871, 54124, '2025-04-07 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(58, 54124, 58871, '2025-04-02 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(59, 54124, 58871, '2025-04-03 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(60, 54124, 58871, '2025-04-10 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(61, 54124, 58871, '2025-04-11 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(62, 54124, 58871, '2025-04-18 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(63, 58871, 54124, '2025-04-16 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(64, 58871, 54124, '2025-04-18 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(65, 58871, 54124, '2025-04-14 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(66, 58871, 54124, '2025-04-14 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(67, 54124, 58871, '2025-04-18 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(68, 54124, 58871, '2025-04-18 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(69, 54124, 58871, '2025-04-16 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(70, 58871, 54124, '2025-04-06 00:00:00', 0, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(71, 54124, 58871, '2025-03-31 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(72, 58871, 54124, '2025-04-09 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(73, 58871, 54124, '2025-04-12 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(74, 28670, 51675, '2025-04-25 00:00:00', 3, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, 0),
(75, 28670, 51675, '2025-04-22 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(76, 28670, 51675, '2025-04-10 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(77, 28670, 51675, '2025-04-18 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(78, 58871, 54124, '2025-04-22 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(79, 58871, 54124, '2025-04-24 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(80, 58871, 58871, '2025-04-11 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(81, 54124, 58871, '2025-04-25 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(82, 58871, 54124, '2025-04-26 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(83, 58871, 54124, '2025-04-26 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(84, 54124, 58871, '2025-04-25 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(85, 58871, 54124, '2025-04-24 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(86, 54124, 58871, '2025-04-23 00:00:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(87, 58871, 54124, '2025-04-22 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(88, 58871, 54124, '2025-04-22 00:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(89, 54124, 58871, '2025-04-12 10:10:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, 0),
(90, 58871, 54124, '2025-04-12 01:14:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(91, 58871, 54124, '2025-04-12 01:14:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(92, 58871, 54124, '2025-04-12 01:14:00', 5, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(93, 49784, 54124, '2025-04-07 17:26:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(94, 49784, 54124, '2025-04-01 03:50:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(95, 58871, 54124, '2025-04-18 01:08:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(96, 49784, 97086, '2025-04-30 08:19:00', 3, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(97, 49784, 28670, '2025-04-29 22:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(98, 49784, 28670, '2025-04-29 22:00:00', 5, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(99, 99569, 28670, '2025-04-14 06:21:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(100, 53827, 58871, '2025-04-30 16:19:00', 3, 'Upcoming', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(101, 96697, 54124, '2025-04-01 17:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL),
(102, 96697, 54124, '2025-03-31 12:00:00', 3, 'Finished', NULL, NULL, NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrimslogdatitokasimaybagoaqdadadag`
--

CREATE TABLE `tbl_scrimslogdatitokasimaybagoaqdadadag` (
  `Match_ID` int(255) NOT NULL,
  `Squad1_ID` int(255) DEFAULT NULL,
  `Squad2_ID` int(255) DEFAULT NULL,
  `Scheduled_Time` datetime NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(255) NOT NULL COMMENT 'Upcoming/Finished',
  `Winner_Squad_ID` int(255) DEFAULT NULL,
  `Winner_Score` int(11) DEFAULT NULL,
  `Loser_Score` int(11) DEFAULT NULL,
  `Screenshot_Proof` text DEFAULT NULL,
  `Date_Submitted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `OCR_Validated` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrimslogorig`
--

CREATE TABLE `tbl_scrimslogorig` (
  `Match_ID` int(255) NOT NULL,
  `Squad1_ID` int(255) DEFAULT NULL,
  `Squad2_ID` int(255) DEFAULT NULL,
  `Scheduled_Time` datetime DEFAULT NULL,
  `Scrim_Status` varchar(255) NOT NULL DEFAULT 'Upcoming' COMMENT 'Upcoming/Finished',
  `Winner_Squad_ID` int(255) DEFAULT NULL,
  `Winner_Score` int(11) DEFAULT NULL,
  `Loser_Score` int(11) DEFAULT NULL,
  `Screenshot_Proof` text DEFAULT NULL COMMENT 'File Path',
  `Date_Submitted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `OCR_Validated` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_squadposts`
--

CREATE TABLE `tbl_squadposts` (
  `Post_ID` int(255) NOT NULL,
  `Squad_ID` int(255) DEFAULT NULL,
  `Post_Label` varchar(255) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `Image_URL` varchar(255) DEFAULT NULL,
  `Post_Type` enum('Private','Public') NOT NULL DEFAULT 'Public',
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_squadposts`
--

INSERT INTO `tbl_squadposts` (`Post_ID`, `Squad_ID`, `Post_Label`, `Content`, `Image_URL`, `Post_Type`, `Timestamp`) VALUES
(1, 1, '', 'hello', '/uploads/Screenshot (1).png', 'Public', '2025-04-05 08:30:29'),
(2, 43844, 'Test', 'Test Message', 'uploads/1744277868_a0dc444a-53a6-4a7b-a57e-4015124a3aae.jpg', 'Public', '2025-04-24 04:11:41'),
(3, 43844, 'Greetings', 'Baksicles', 'uploads/1744277886_a0dc444a-53a6-4a7b-a57e-4015124a3aae.jpg', 'Private', '2025-04-10 09:38:06'),
(6, 55548, 'Test', 'Testing again', 'uploads/1744290241_b7b945de-5c02-4741-9109-1b8523c165e5.jpg', 'Public', '2025-04-10 13:04:01'),
(7, 28670, '', 'hi', '', 'Public', '2025-04-24 00:46:38'),
(8, 51675, '', 'Hello Welcome Team!', 'uploads/1745477461_IMG_7496.png', 'Public', '2025-04-24 06:51:01'),
(9, 51675, '', 'Hello Welcome Team! Private post here.', 'uploads/1745477631_Elina (21).png', 'Private', '2025-04-24 06:53:51'),
(10, 28670, 'Test', 'Hey there!', 'uploads/1745764419_Elina (22).png', 'Public', '2025-04-27 14:33:39'),
(11, 28670, 'Test', 'Testing again', 'uploads/1745764817_IMG_7496.png', 'Private', '2025-04-27 14:40:17'),
(12, 28670, 'Test', 'Testttt', 'uploads/1745764833_Elina (21).png', 'Public', '2025-04-27 14:40:33'),
(13, 28670, 'Test', 'test 5', 'uploads/1745764848_Elina (21).png', 'Public', '2025-04-27 14:40:48'),
(14, 28670, 'Test', 'test 6', 'uploads/1745764860_Elina (17).png', 'Public', '2025-04-27 14:41:00'),
(15, 28670, 'Test', 'test 7', 'uploads/1745764872_Elina (21).png', 'Public', '2025-04-27 14:41:12'),
(16, 28670, '', 'test 8', 'uploads/1745764879_Elina (21).png', 'Public', '2025-04-27 14:41:19'),
(17, 28670, 'Test', 'test 9', 'uploads/1745764889_Elina (21).png', 'Public', '2025-04-27 14:41:29'),
(18, 28670, 'Test', 'test 10', 'uploads/1745764898_IMG_7496.png', 'Private', '2025-04-27 14:41:38'),
(19, 28670, 'Test', 'heeeeee', 'uploads/1745764912_Elina (21).png', 'Public', '2025-04-27 14:41:52'),
(20, 28670, 'Test', 'tester 5', 'uploads/1745764928_Elina (21).png', 'Public', '2025-04-27 14:42:08'),
(23, 54124, '', 'Ff', '', 'Public', '2025-04-29 16:05:10'),
(24, 54124, NULL, 'Just graduated from UPD!', '/var/www/html/abyss/IMG/post_uploads/img_6810fa95c08632.90710577.jpg', 'Public', '2025-04-29 16:13:09'),
(25, 54124, '', 'Just graduated from UPD!', 'uploads/1745943189_vspsGRAD3_1581.jpg', 'Public', '2025-04-29 16:13:09'),
(26, 96697, 'Test', 'Test Post', 'uploads/1745943422_ETUDE (1900 x 800 px).PNG', 'Public', '2025-04-29 16:17:02'),
(27, 96697, 'Test', 'Testing Private Post', '', 'Private', '2025-04-29 16:17:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_squadprofile`
--

CREATE TABLE `tbl_squadprofile` (
  `Squad_Index` int(11) NOT NULL,
  `Squad_ID` int(11) DEFAULT NULL,
  `Squad_Name` varchar(100) DEFAULT NULL,
  `Squad_Acronym` varchar(45) DEFAULT NULL,
  `Squad_Description` varchar(200) DEFAULT NULL,
  `Squad_Level` varchar(45) DEFAULT NULL,
  `Squad_Logo` blob DEFAULT NULL,
  `Total_Stars` int(255) DEFAULT NULL,
  `Player_Count` int(255) DEFAULT NULL,
  `Average_Star` float(15,4) DEFAULT NULL,
  `ABYSS_Score` int(11) NOT NULL DEFAULT 0,
  `isPenalized` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_squadprofile`
--

INSERT INTO `tbl_squadprofile` (`Squad_Index`, `Squad_ID`, `Squad_Name`, `Squad_Acronym`, `Squad_Description`, `Squad_Level`, `Squad_Logo`, `Total_Stars`, `Player_Count`, `Average_Star`, `ABYSS_Score`, `isPenalized`) VALUES
(1, 60976, 'adf', 'sac', 'cascsaca', 'Amateur', NULL, 235235, 1, 235235.0000, 0, 0),
(2, 38224, 'C++ Esports', 'C++', 'College of Computer Studies', 'Amateur', NULL, 497, 5, 99.4000, 0, 0),
(3, 86771, 'Frost Hunters', 'frzt', 'The best squad in town', 'Amateur', NULL, 121, 5, 24.2000, 0, 0),
(4, 81346, 'Thunder Novas', 'THV', 'Thunder Novas lang sakalam', 'Amateur', NULL, 170, 5, 34.0000, 0, 0),
(5, 28670, 'Lightning Requiem', 'LRe', 'mga mamaw magselos', 'Collegiate', NULL, 865, 5, 173.0000, 0, 1),
(6, 96990, 'NeoBeasts', 'neo', 'NeoBeats Pro Players', 'Professional', NULL, 3968, 5, 793.6000, 0, 0),
(7, 54892, 'The Overdrive', 'ovr', 'Overdrive Squad', 'Amateur', NULL, 433, 5, 86.6000, 0, 0),
(8, 78910, 'Leonin Fighters', 'LFS', 'lore of the best leonin', 'Amateur', NULL, 319, 5, 63.8000, 0, 0),
(9, 26601, 'MetaTzy', 'tzy', 'ayasib vs golagat', 'Amateur', NULL, 245, 5, 49.0000, 0, 0),
(10, 72997, 'Yu Yu Hakusho', 'YYH', 'Oshiete Oshiete', 'Professional', NULL, 6382, 5, 1276.4000, 0, 0),
(11, 98078, 'The Targaryen House', 'TTH', 'Dragons of Targaryen House', 'Amateur', NULL, 495, 5, 99.0000, 0, 0),
(12, 64652, 'DAZABABERS', 'DAZ', 'Hi! We are DAZABABERS', 'Amateur', NULL, 330, 5, 66.0000, 0, 0),
(13, 59427, 'JUNYELERS', 'JUN', 'Hi! We are JUNYELERS', 'Amateur', NULL, 23, 1, 23.0000, 0, 0),
(14, 55548, 'DAGOK', 'DGK', 'Hi! We are DAGOK', 'Amateur', NULL, 187, 5, 37.4000, 0, 0),
(15, 10766, 'GNOMES', 'GNM', 'HIHIHIHI', 'Amateur', NULL, 69, 2, 34.5000, 0, 0),
(16, 53932, 'JULIESBAKESHOP', 'JLB', 'Hi! We are JULIESBAKESHOP', 'Amateur', NULL, 72, 2, 36.0000, 0, 0),
(17, 42704, 'AQUINOS', 'AQN', 'Hi! We are AQUINOS', 'Amateur', NULL, 179, 2, 89.5000, 0, 0),
(18, 60828, 'LELEMES', 'LLM', 'Hi! We are LELEMES', 'Amateur', NULL, 140, 2, 70.0000, 0, 0),
(19, 88242, 'JUNNIEBELS', 'JNB', 'Hi! We are JUNNIEBELS', 'Amateur', NULL, 127, 2, 63.5000, 0, 0),
(20, 71837, 'CHACHA', 'CHA', 'Hi! We are CHACHA', 'Amateur', NULL, 131, 2, 65.5000, 0, 0),
(21, 99569, 'KIMCHIFRIEDRICE', 'KFR', 'Hi! We are KIMCHIFRIEDRICE', 'Amateur', NULL, 149, 2, 74.5000, 50, 0),
(22, 43844, 'MEZEREP', 'MZP', 'Hi! We are MEZEREP', 'Amateur', NULL, 1281, 2, 640.5000, 0, 0),
(23, 1, 'ABYSS AUTOMATED SYSTEM', 'ABYSS', 'This is for official ABYSS Automated Messages.', NULL, NULL, 0, 0, 0.0000, 0, 0),
(24, 58871, 'DREAMTEAM', 'DRM', 'Hi! We are DREAMTEAM', 'Amateur', NULL, 3362, 5, 672.4000, 175, 0),
(25, 54124, 'EMERLOOS', 'EMR', 'Hi! We are EMERLOOS', 'Amateur', NULL, 3374, 5, 674.8000, 325, 0),
(26, 94903, 'TEST', 'TEST', 'TEST', 'Professional', NULL, 103, 1, 103.0000, 0, 0),
(27, 65925, 'COMSTUD', 'CCS', 'Hi! We are COMSTUD', 'Amateur', NULL, 3063, 6, 510.5000, 0, 0),
(28, 26091, 'HWASUBUN ESPORTS', 'HSE', 'kimbap', 'Amateur', NULL, 2028, 5, 405.6000, 0, 0),
(29, 51675, 'lsbccs', 'lsc', 'Lyceum Subic Bay', 'Amateur', NULL, 1984, 5, 396.8000, 100, 0),
(30, 49784, 'TESTINGSQUADS', 'TTS', 'Hi! We are TESTINGSQUAD', 'Amateur', NULL, 1622, 5, 324.4000, 0, 0),
(31, 97086, 'SejunTheBest', 'SJN', 'I am Sejun, I love SB19', 'Amateur', NULL, 1599, 1, 1599.0000, 0, 0),
(35, 53827, 'NNUNUNANA', 'NNU', 'Hi! We are NNUNUNANA', 'Amateur', NULL, 405, 1, 405.0000, 0, 0),
(36, 96697, 'AVIORADICALS', 'AVR', 'Hello! We are AVIORADICALS!', 'Amateur', NULL, 3077, 5, 615.4000, 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_squadverification`
--

CREATE TABLE `tbl_squadverification` (
  `Verification_ID` int(255) NOT NULL,
  `Squad_ID` int(255) DEFAULT NULL,
  `Submitted_By` int(255) DEFAULT NULL COMMENT 'Referenced to tbl_useraccount',
  `Verification_Status` enum('Pending','Approved','Rejected','') DEFAULT NULL,
  `Submission_Date` datetime DEFAULT NULL,
  `Approval_Date` datetime DEFAULT NULL,
  `Verified_By` int(255) DEFAULT NULL COMMENT 'Referenced to tbl_modaccount',
  `Rejection_Reason` text DEFAULT NULL,
  `Supporting_Documents` varchar(255) DEFAULT NULL COMMENT 'File Path 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_useraccount`
--

CREATE TABLE `tbl_useraccount` (
  `User_ID` int(11) NOT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Username` varchar(100) DEFAULT NULL,
  `Squad_ID` int(255) NOT NULL,
  `Role` enum('Admin','Moderator','User') NOT NULL DEFAULT 'User',
  `token` text DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_useraccount`
--

INSERT INTO `tbl_useraccount` (`User_ID`, `Email_Address`, `Password`, `Username`, `Squad_ID`, `Role`, `token`, `verified`) VALUES
(4, 'sebelletolero@gmail.com', '$2y$12$UZ2O1QikkKPBrQqGbst9e.3LHzRWz4Jn0CDeTUuuEiTDYVMAtUreO', 'sebelle', 60976, 'User', NULL, 0),
(6, 'kamorahalls@gmail.com', 'hall', 'kamora', 1, 'Admin', NULL, 0),
(7, 'cjtoress@gmail.com', '$2y$12$Z1G1P4DrNnD0Y.4M5y2sKuV3jSnpFUoBw5e6VI14LwIxduDByIzpO', 'cole', 38224, 'User', NULL, 0),
(8, 'mirabel123@gmail.com', '$2y$12$vl2AzOLWzDiSNofHjKsmVuYkbeFfvp8qlNUR8BywUT8bGYLrWIzj6', 'mirabel', 86771, 'User', NULL, 0),
(9, 'xuchiitoledo@gmail.com', '$2y$12$b70Fj4eMhTd.y0Av0FgJk.5wYES0qb5jSPXugDZhkFYcUYbjUTQ2i', 'xuchiicakes', 81346, 'User', NULL, 0),
(10, 'selwynatics@gmail.com', '$2y$12$H6Qg7v9LEeXEFNm8OVB0kOAhy9r5SQ1weIDeyiLenPIFnxCrda82.', 'selwynatics', 28670, 'User', NULL, 0),
(11, 'neobeast@gmail.com', '$2y$12$G1R4PpQDX4ejfGTS27.MH.o/Pr2B624ZrMU9A2k6RyeRyPL6UX9Im', 'Neo', 96990, 'User', NULL, 0),
(12, 'theolords@gmail.com', '$2y$12$Rz24TSCJIkWSaO6kYAmDG.siNrQBdLJH24Y6u186TatPQHa0nMA0C', 'Theo', 54892, 'User', NULL, 0),
(13, 'romeoandjuliet@gmail.com', '$2y$12$vxqXz.aoIWpLOqlY4DhSHeJBey32xlyDR.dPk/wB/34Kjrf2xvfVS', 'Randj', 78910, 'User', NULL, 0),
(14, 'kianatics@gmail.com', '$2y$12$TcmjeHpcMjPyiRRSiDwnd.wm6RXKiCBnCt.H4QkACUiS1m8P4iNHm', 'Kianna', 26601, 'User', NULL, 0),
(15, 'theholygrounds@gmail.com', '$2y$12$HUnJ3SCM1qCFOXj/j0QTl.t0R0xYP/CdzoSU1bTwUyYWZEP6W0Aye', 'HolyGrounds', 72997, 'User', NULL, 0),
(16, 'aceofspade@gmail.com', '$2y$12$0QWH5YhRDMeKs1mE9u5tMuFyeJCKL5zIxEjsNhv9nsuXK7CEurmkS', 'Spade', 98078, 'User', NULL, 0),
(17, 'isabelledazabels@gmail.com', '$2y$12$JyMqQdQgeGXpHtuNVVCg7uFay04TtZi2eiY0/QHI3Lg.QJSQ2VeL6', 'isabelle', 64652, 'Moderator', NULL, 0),
(18, 'chachacha!@gmail.com', '$2y$12$blVhIkEvilW48ETPtB9es.SfXn3p1i1cnVJzDFzyG4.nTZwz/WVC.', 'junyel', 59427, 'Admin', NULL, 0),
(19, 'reginageorge@gmail.com', '$2y$12$yuxK9p9oKVsDmlMBsaTY0OmHLIocqRTQ5vQ9qRELWG72shX18Hkli', 'regina', 55548, 'User', NULL, 0),
(20, 'angelojohnjohn@gmail.com', '$2y$12$5a8AS8cbBKuW7Wz6Rn4LzOUiuHbLrUO8Sa30yO2M3ukOnGMb.qw.K', 'angelow', 10766, 'User', NULL, 0),
(21, 'julianne@gmail.com', '$2y$12$X7q6DLixnEwux2KHw.zNvuX1CYBKewqg0N6HdIOeX2taRJ8d2wCdW', 'juliecakes', 53932, 'User', NULL, 0),
(22, 'bimby@gmail.com', '$2y$12$J9APOwaY7PNz86yLEGcZVO8D4N4zlcJoXQaYW0FL2iH2nUqYrqNK2', 'bimb', 42704, 'User', NULL, 0),
(23, 'lelelermey@gmail.com', '$2y$12$zC6IaxOPRAe0gELaRjIc6e671SsleJlmoNmCCgDHfEwMKQVcwFG/m', 'lermey', 60828, 'User', NULL, 0),
(24, 'junjun@gmail.com', '$2y$12$MDrxWObFLbRHEym30oe6TenHkQgqcOuSgAGfUseh1bvocxTdxN3.S', 'junjun', 88242, 'User', NULL, 0),
(25, 'charlieboi@gmail.com', '$2y$12$tOmMJChXmG2BLWvUM1H3wuW2j6uIv5aK4cpxEy/LQqf7t42GVTU/a', 'charlie', 71837, 'User', NULL, 0),
(26, 'kimchi@gmail.com', '$2y$12$HmcjCbM1F/MdfyZDomU4AOCAGR5IplELCu.gC29csHo5S5aSIyCeu', 'kimchi', 99569, 'User', NULL, 0),
(29, 'azerethzerep@gmail.com', '$2y$12$W09XCWW8bCw6Qb3UJq96dO0jcaX45QCHHy/od9cUO5wT4euIQxCpa', 'zerep', 43844, 'User', NULL, 0),
(30, 'papapips@gmail.com', '$2y$12$oHVi0mPKT7.hSWctqb2qPOPrsq/Oy2aj/fPrD4CEv5rHebjrVjBtC', 'papapo', 82280, 'Moderator', NULL, 0),
(31, 'marugame@gmail.com', '$2y$12$Z9wv1RfKFSK5XCoFSk.3ZuVHOL0lOnEuEkazDr1FosmEy6y2mz726', 'marugame', 87557, 'User', NULL, 0),
(32, 'paulinetoledoo026@gmail.com', '$2y$12$.FBjUoWVIebalM4cmO6VsejpRuz/RkJenX0Vjq3aSQmfQU0FwIUvy', 'paupau', 58871, 'User', NULL, 0),
(33, 'pauline.ptoledo@gmail.com', '$2y$12$SDWK7pRLeBJjnHjT4MyAb.lBiWrCbijFfJDuilNJP3KtFGL/qah3G', 'ptoledz', 54124, 'User', NULL, 0),
(34, 'louisjno@gmail.com', '$2y$12$0GDppp0Gmf2olZU2EY8v3OG9hmNSq5ZrljYQAUKVQnga94H47OQma', 'louis', 52504, 'User', NULL, 0),
(35, 'lexi.loregomez@gmail.com', '$2y$12$5IX8NnSKEs013Lsi7dL0cu9X7/VcgOgjgnpEwRbnfPPKMLBAMF316', 'HUWA', 58885, 'User', NULL, 0),
(36, 'selwyntolero20@gmail.com', '$2y$12$EFWpKQcaQOQtMPcbVOtLveIj3hj2xRGE3qaIUTzPwuicQ6gbVEHqS', 'cinna', 94903, 'User', NULL, 0),
(37, '2232976@slu.edu.ph', '$2y$12$NHGbbr0WuZZUvSrkknM/f.SlZBX4K36Ud/DgyZyxpBNoP9NU4LzSC', 'isabelleR', 93648, 'User', NULL, 0),
(38, 'rikugelo@gmail.com', '$2y$12$O9M3auGf2SDfaU0iXXXWEe/Yigtk7Jhpr1z8oQuHPuM4AhrAlncfC', 'riku', 65925, 'User', NULL, 0),
(39, 'roldancchristian@gmail.com', '$2y$12$rbtVkRLyiik4It46xXUMuOxVRu.0NKx0IeLFwSj4VfISQY57.HyXm', 'tian', 26091, 'User', NULL, 0),
(40, 'aburayag@lsb.edu.ph', '$2y$12$2AFelZy/6tTcudg9Lqptx.q15Eyn0vpPpJ8XkTJ4tJTGGgobD9hA.', 'armainebiel', 51675, 'User', NULL, 0),
(41, 'REMOVED@GMAIL.COM', '$2y$12$NK4jb3Fp9GQDRu2xkUp5vOrlIxz9DOpXr3fl1E1h8Q0EruOavSBqu', 'REMOVED0X1', 47773, 'User', '6c991e6d1ae4e616bfb5bdb55ceffee0', 0),
(42, 'REMOVED@GMAIL.COM1', '$2y$12$DGs1mpYuAkNPrxkEUyq07ewE8SjfXXqC75IBIVE4MFm8nncidZ3XG', 'REMOVED0X12', 53402, 'User', NULL, 1),
(43, 'siopauliine@gmail.com', '$2y$12$CsQYYcP08FsNp5BMjaxp9OBzAdagRqJpNh.5e1g9gH1OHr/HNJHUi', 'siopauline', 49784, 'User', NULL, 1),
(45, 'sejun@gmail.com', '$2y$12$5F0LkiS3fDqVR/Nb0Av06OnWKiuKyMf0qhvit/IZ6ZZLAbqwir4V2', 'Sejun', 20196, 'User', 'a983a3bad5b91b6cebb5cbe10a30f816', 0),
(46, 'deguzmancharles03@gmail.com', '$2y$12$ifJj365BLprecJ4.PWXn4Oq8pzwGHi.6uflSiHpcZyHn40iUQ7.NO', 'CardioDalisay', 31375, 'User', NULL, 1),
(48, 'mousealock18@gmail.com', '$2y$12$Dl8q2oMAaTsj6UbR06KLIeqTTiWrqWJenRHCGEfhViib1UEJ2RUhC', 'Sejunah', 97086, 'User', NULL, 1),
(49, 'slwyntlr05@gmail.com', '$2y$12$BueDXEwlBo5cmW.za14Gu.x3N35av4HPTIy6PsKKMB3p3L9SsVCsG', 'Tartarus', 35506, 'User', 'e0212127c05ac83e40441b17441b5380', 0),
(51, 'tolerosebelle213@gmail.com', '$2y$12$KsYCPs0DDUqBOJICCn6rx.fQY0qoF2oOChO3uFewROO6iFZlWmDj6', 'durexination', 34030, 'User', 'ccf3a42bd88648b8baff324bb701f6df', 0),
(53, 'sebelletlr@gmail.com', '$2y$12$Pwa1V3gtdXnSz5t32423OuviUYJOOIvVYxHTbkcWJAzeLqMgr09YK', 'JUNNIEBOY', 16458, 'User', '1724dc6a6900b277af6a6acc141a7cf2', 0),
(60, 'col.2023010206@lsb.edu.ph', '$2y$12$Hmgxb77KyieA0rH0Qfgl.eWeHBoCx5drvLWZp3hFYPACr/y4dpAR6', 'tartarusy', 20489, 'User', NULL, 1),
(63, 'col.2023010205@lsb.edu.phP', '$2y$12$dvyvyWTkKB5INtMZxyLSn.U2k0j/rcIklLqcr1PZm2N/gN6BKCjLy', 'siopaobolabola', 53827, 'User', NULL, 1),
(67, 'col.2023010205@lsb.edu.ph', '$2y$12$TG5O1w4O2aDYxlRbiyydReP0TEhP.B.wEYu3cf5T1ahjoX1g2ZwQq', 'xuchipau', 96697, 'User', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_useractivitylog`
--

CREATE TABLE `tbl_useractivitylog` (
  `Log_ID` int(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Activity_Type` varchar(255) DEFAULT NULL,
  `Activity` text DEFAULT NULL,
  `Squad_ID` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userlogin`
--

CREATE TABLE `tbl_userlogin` (
  `Login_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Login_Time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verificationrequests`
--

CREATE TABLE `tbl_verificationrequests` (
  `Request_ID` int(11) NOT NULL,
  `Squad_ID` int(11) DEFAULT NULL,
  `Squad_Name` int(11) DEFAULT NULL,
  `Squad_Level` enum('Amateur','Collegiate','Professional','') DEFAULT NULL,
  `Proof_Type` varchar(255) DEFAULT NULL,
  `Proof_File` varchar(255) DEFAULT NULL,
  `Status` enum('Pending','Approved','Rejected','') NOT NULL DEFAULT 'Pending',
  `Date_Submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `Date_Reviewed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_verificationrequests`
--

INSERT INTO `tbl_verificationrequests` (`Request_ID`, `Squad_ID`, `Squad_Name`, `Squad_Level`, `Proof_Type`, `Proof_File`, `Status`, `Date_Submitted`, `Date_Reviewed`) VALUES
(1, 60976, NULL, 'Amateur', 'Official Team Registration', '../uploads/verification/proof_67ee4869a47762.32581965.png', 'Pending', '2025-04-03 08:35:53', NULL),
(2, 38224, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f38ac364d644.88134231.jpg', 'Pending', '2025-04-07 08:20:19', NULL),
(3, 86771, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f38f2d6b7076.48371957.jpg', 'Pending', '2025-04-07 08:39:09', NULL),
(4, 81346, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3919537f847.09702721.jpg', 'Pending', '2025-04-07 08:49:25', NULL),
(5, 28670, NULL, 'Collegiate', 'Official Team Registration', '../uploads/verification/proof_67f393b093a455.47413859.jpg', 'Approved', '2025-04-07 08:58:24', '2025-04-29 16:19:02'),
(6, 96990, NULL, 'Professional', 'Tournament Participation', '../uploads/verification/proof_67f39d12178616.70366738.jpg', 'Approved', '2025-04-07 09:38:26', '2025-04-07 05:39:06'),
(7, 54892, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f39f34db9c75.62616713.jpg', 'Pending', '2025-04-07 09:47:32', NULL),
(8, 78910, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3a0b709aa30.49888957.jpg', 'Pending', '2025-04-07 09:53:59', NULL),
(9, 26601, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3a26287dd87.46825107.jpg', 'Pending', '2025-04-07 10:01:06', NULL),
(10, 72997, NULL, 'Professional', 'Tournament Participation', '../uploads/verification/proof_67f3a48ddef4a1.11534830.jpg', 'Approved', '2025-04-07 10:10:21', '2025-04-07 10:04:17'),
(11, 98078, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3a6132f6d76.49148977.jpg', 'Pending', '2025-04-07 10:16:51', NULL),
(12, 64652, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3bd3d3810b1.77893890.pdf', 'Pending', '2025-04-07 11:55:41', NULL),
(13, 59427, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3cecf2192c3.48382666.pdf', 'Pending', '2025-04-07 13:10:39', NULL),
(14, 55548, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 06:29:34', NULL),
(15, 10766, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 06:42:18', NULL),
(16, 53932, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 06:50:32', NULL),
(17, 42704, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 07:09:52', NULL),
(18, 60828, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 07:16:33', NULL),
(19, 88242, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 07:21:02', NULL),
(20, 71837, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 07:24:15', NULL),
(21, 99569, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 07:30:43', NULL),
(22, 43844, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-10 07:53:07', NULL),
(23, 87557, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-23 07:53:48', NULL),
(24, 58871, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-23 17:18:05', NULL),
(25, 54124, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-23 17:21:59', NULL),
(26, 94903, NULL, 'Professional', 'Official Team Registration', '../uploads/verification/proof_6809814ede5ad_Excuse Letter.pdf', 'Pending', '2025-04-24 00:09:50', NULL),
(27, 65925, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-24 04:57:53', NULL),
(28, 26091, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-24 06:38:21', NULL),
(29, 51675, NULL, 'Amateur', 'Certificate of Enrollment', 'N/A', 'Pending', '2025-04-24 06:48:59', NULL),
(30, 49784, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-27 19:48:54', NULL),
(31, 97086, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 12:18:54', NULL),
(32, 20280, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 12:46:20', NULL),
(33, 69454, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 18:42:18', NULL),
(34, 34429, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 18:44:36', NULL),
(35, 58318, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 18:53:01', NULL),
(36, 20489, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 19:04:59', NULL),
(37, 51343, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 19:51:39', NULL),
(38, 15009, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 20:09:52', NULL),
(39, 53827, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-28 20:13:12', NULL),
(40, 25487, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-29 14:53:29', NULL),
(41, 71912, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-29 15:08:33', NULL),
(42, 23636, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-29 15:17:53', NULL),
(43, 96697, NULL, 'Amateur', 'N/A', 'N/A', 'Pending', '2025-04-29 15:31:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_videoads`
--

CREATE TABLE `tbl_videoads` (
  `VideoAd_ID` int(11) NOT NULL,
  `Video_File` varchar(255) DEFAULT NULL,
  `Show_Status` varchar(10) DEFAULT 'Hidden',
  `Created_At` timestamp NULL DEFAULT current_timestamp(),
  `Updated_At` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_adminaccount`
--
ALTER TABLE `tbl_adminaccount`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `tbl_admin_notes`
--
ALTER TABLE `tbl_admin_notes`
  ADD PRIMARY KEY (`Note_ID`);

--
-- Indexes for table `tbl_auditlogs`
--
ALTER TABLE `tbl_auditlogs`
  ADD PRIMARY KEY (`Audit_ID`),
  ADD KEY `fk_modID` (`Moderator_ID`);

--
-- Indexes for table `tbl_carousels`
--
ALTER TABLE `tbl_carousels`
  ADD PRIMARY KEY (`Carousel_ID`);

--
-- Indexes for table `tbl_contentmanagement`
--
ALTER TABLE `tbl_contentmanagement`
  ADD PRIMARY KEY (`Content_ID`);

--
-- Indexes for table `tbl_conversations`
--
ALTER TABLE `tbl_conversations`
  ADD PRIMARY KEY (`Conversation_ID`),
  ADD KEY `Squad1_ID` (`Squad1_ID`),
  ADD KEY `Squad2_ID` (`Squad2_ID`),
  ADD KEY `tbl_conversations_ibfk_3` (`Last_Message_ID`);

--
-- Indexes for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  ADD PRIMARY KEY (`Feedback_ID`);

--
-- Indexes for table `tbl_heroimages`
--
ALTER TABLE `tbl_heroimages`
  ADD PRIMARY KEY (`Hero_ID`),
  ADD UNIQUE KEY `unique_hero_name` (`Hero_Name`);

--
-- Indexes for table `tbl_instructions`
--
ALTER TABLE `tbl_instructions`
  ADD PRIMARY KEY (`Instruction_ID`);

--
-- Indexes for table `tbl_inviteslog`
--
ALTER TABLE `tbl_inviteslog`
  ADD PRIMARY KEY (`Schedule_ID`);

--
-- Indexes for table `tbl_matchverifications`
--
ALTER TABLE `tbl_matchverifications`
  ADD PRIMARY KEY (`Verification_ID`),
  ADD KEY `Match_ID` (`Match_ID`),
  ADD KEY `Squad_ID` (`Squad_ID`);

--
-- Indexes for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `Conversation_ID` (`Conversation_ID`),
  ADD KEY `Sender_Squad_ID` (`Sender_Squad_ID`),
  ADD KEY `Recipient_Squad_ID` (`Recipient_Squad_ID`);

--
-- Indexes for table `tbl_messagesyhsryhsryhrs`
--
ALTER TABLE `tbl_messagesyhsryhsryhrs`
  ADD PRIMARY KEY (`Message_ID`),
  ADD KEY `Sender_Squad_ID` (`Sender_Squad_ID`),
  ADD KEY `Recipient_Squad_ID` (`Recipient_Squad_ID`);

--
-- Indexes for table `tbl_modaccount`
--
ALTER TABLE `tbl_modaccount`
  ADD PRIMARY KEY (`Moderator_ID`);

--
-- Indexes for table `tbl_penalties`
--
ALTER TABLE `tbl_penalties`
  ADD PRIMARY KEY (`Penalty_ID`);

--
-- Indexes for table `tbl_pendingverif`
--
ALTER TABLE `tbl_pendingverif`
  ADD PRIMARY KEY (`Verification_ID`);

--
-- Indexes for table `tbl_playerprofile`
--
ALTER TABLE `tbl_playerprofile`
  ADD PRIMARY KEY (`Player_ID`),
  ADD KEY `fk_squadonprofile` (`Squad_ID`),
  ADD KEY `fk_hero1` (`Hero_1`),
  ADD KEY `fk_hero2` (`Hero_2`),
  ADD KEY `fk_hero3` (`Hero_3`);

--
-- Indexes for table `tbl_prooffiles`
--
ALTER TABLE `tbl_prooffiles`
  ADD PRIMARY KEY (`Proof_ID`),
  ADD KEY `Verification_ID` (`Verification_ID`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `tbl_scrimslog`
--
ALTER TABLE `tbl_scrimslog`
  ADD PRIMARY KEY (`Match_ID`),
  ADD KEY `Squad1_ID` (`Squad1_ID`),
  ADD KEY `Squad2_ID` (`Squad2_ID`),
  ADD KEY `Winner_Squad_ID` (`Winner_Squad_ID`);

--
-- Indexes for table `tbl_scrimslogdatitokasimaybagoaqdadadag`
--
ALTER TABLE `tbl_scrimslogdatitokasimaybagoaqdadadag`
  ADD PRIMARY KEY (`Match_ID`);

--
-- Indexes for table `tbl_scrimslogorig`
--
ALTER TABLE `tbl_scrimslogorig`
  ADD PRIMARY KEY (`Match_ID`);

--
-- Indexes for table `tbl_squadposts`
--
ALTER TABLE `tbl_squadposts`
  ADD PRIMARY KEY (`Post_ID`);

--
-- Indexes for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  ADD PRIMARY KEY (`Squad_Index`),
  ADD KEY `fk_squadonsquad` (`Squad_ID`);

--
-- Indexes for table `tbl_squadverification`
--
ALTER TABLE `tbl_squadverification`
  ADD PRIMARY KEY (`Verification_ID`);

--
-- Indexes for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Squad_ID` (`Squad_ID`) USING BTREE;

--
-- Indexes for table `tbl_useractivitylog`
--
ALTER TABLE `tbl_useractivitylog`
  ADD PRIMARY KEY (`Log_ID`);

--
-- Indexes for table `tbl_userlogin`
--
ALTER TABLE `tbl_userlogin`
  ADD PRIMARY KEY (`Login_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `tbl_verificationrequests`
--
ALTER TABLE `tbl_verificationrequests`
  ADD PRIMARY KEY (`Request_ID`);

--
-- Indexes for table `tbl_videoads`
--
ALTER TABLE `tbl_videoads`
  ADD PRIMARY KEY (`VideoAd_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_adminaccount`
--
ALTER TABLE `tbl_adminaccount`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_admin_notes`
--
ALTER TABLE `tbl_admin_notes`
  MODIFY `Note_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_auditlogs`
--
ALTER TABLE `tbl_auditlogs`
  MODIFY `Audit_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_carousels`
--
ALTER TABLE `tbl_carousels`
  MODIFY `Carousel_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_contentmanagement`
--
ALTER TABLE `tbl_contentmanagement`
  MODIFY `Content_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_conversations`
--
ALTER TABLE `tbl_conversations`
  MODIFY `Conversation_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1245;

--
-- AUTO_INCREMENT for table `tbl_heroimages`
--
ALTER TABLE `tbl_heroimages`
  MODIFY `Hero_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `tbl_instructions`
--
ALTER TABLE `tbl_instructions`
  MODIFY `Instruction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_inviteslog`
--
ALTER TABLE `tbl_inviteslog`
  MODIFY `Schedule_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tbl_matchverifications`
--
ALTER TABLE `tbl_matchverifications`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `tbl_messagesyhsryhsryhrs`
--
ALTER TABLE `tbl_messagesyhsryhsryhrs`
  MODIFY `Message_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_modaccount`
--
ALTER TABLE `tbl_modaccount`
  MODIFY `Moderator_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_penalties`
--
ALTER TABLE `tbl_penalties`
  MODIFY `Penalty_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_pendingverif`
--
ALTER TABLE `tbl_pendingverif`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_playerprofile`
--
ALTER TABLE `tbl_playerprofile`
  MODIFY `Player_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `tbl_prooffiles`
--
ALTER TABLE `tbl_prooffiles`
  MODIFY `Proof_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_scrimslog`
--
ALTER TABLE `tbl_scrimslog`
  MODIFY `Match_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tbl_scrimslogdatitokasimaybagoaqdadadag`
--
ALTER TABLE `tbl_scrimslogdatitokasimaybagoaqdadadag`
  MODIFY `Match_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_scrimslogorig`
--
ALTER TABLE `tbl_scrimslogorig`
  MODIFY `Match_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_squadposts`
--
ALTER TABLE `tbl_squadposts`
  MODIFY `Post_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  MODIFY `Squad_Index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_squadverification`
--
ALTER TABLE `tbl_squadverification`
  MODIFY `Verification_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_useractivitylog`
--
ALTER TABLE `tbl_useractivitylog`
  MODIFY `Log_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_userlogin`
--
ALTER TABLE `tbl_userlogin`
  MODIFY `Login_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_verificationrequests`
--
ALTER TABLE `tbl_verificationrequests`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_videoads`
--
ALTER TABLE `tbl_videoads`
  MODIFY `VideoAd_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_auditlogs`
--
ALTER TABLE `tbl_auditlogs`
  ADD CONSTRAINT `fk_modID` FOREIGN KEY (`Moderator_ID`) REFERENCES `tbl_modaccount` (`Moderator_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_conversations`
--
ALTER TABLE `tbl_conversations`
  ADD CONSTRAINT `tbl_conversations_ibfk_1` FOREIGN KEY (`Squad1_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`),
  ADD CONSTRAINT `tbl_conversations_ibfk_2` FOREIGN KEY (`Squad2_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`),
  ADD CONSTRAINT `tbl_conversations_ibfk_3` FOREIGN KEY (`Last_Message_ID`) REFERENCES `tbl_messages` (`Message_ID`);

--
-- Constraints for table `tbl_matchverifications`
--
ALTER TABLE `tbl_matchverifications`
  ADD CONSTRAINT `tbl_matchverifications_ibfk_1` FOREIGN KEY (`Match_ID`) REFERENCES `tbl_scrimslog` (`Match_ID`),
  ADD CONSTRAINT `tbl_matchverifications_ibfk_2` FOREIGN KEY (`Squad_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`);

--
-- Constraints for table `tbl_messages`
--
ALTER TABLE `tbl_messages`
  ADD CONSTRAINT `tbl_messages_ibfk_1` FOREIGN KEY (`Conversation_ID`) REFERENCES `tbl_conversations` (`Conversation_ID`),
  ADD CONSTRAINT `tbl_messages_ibfk_2` FOREIGN KEY (`Sender_Squad_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`),
  ADD CONSTRAINT `tbl_messages_ibfk_3` FOREIGN KEY (`Recipient_Squad_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`);

--
-- Constraints for table `tbl_messagesyhsryhsryhrs`
--
ALTER TABLE `tbl_messagesyhsryhsryhrs`
  ADD CONSTRAINT `tbl_messagesyhsryhsryhrs_ibfk_1` FOREIGN KEY (`Sender_Squad_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`),
  ADD CONSTRAINT `tbl_messagesyhsryhsryhrs_ibfk_2` FOREIGN KEY (`Recipient_Squad_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`);

--
-- Constraints for table `tbl_pendingverif`
--
ALTER TABLE `tbl_pendingverif`
  ADD CONSTRAINT `fk_squadID` FOREIGN KEY (`Verification_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_playerprofile`
--
ALTER TABLE `tbl_playerprofile`
  ADD CONSTRAINT `fk_hero1` FOREIGN KEY (`Hero_1`) REFERENCES `tbl_heroimages` (`Hero_Name`),
  ADD CONSTRAINT `fk_hero2` FOREIGN KEY (`Hero_2`) REFERENCES `tbl_heroimages` (`Hero_Name`),
  ADD CONSTRAINT `fk_hero3` FOREIGN KEY (`Hero_3`) REFERENCES `tbl_heroimages` (`Hero_Name`),
  ADD CONSTRAINT `fk_squadonprofile` FOREIGN KEY (`Squad_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`);

--
-- Constraints for table `tbl_prooffiles`
--
ALTER TABLE `tbl_prooffiles`
  ADD CONSTRAINT `tbl_prooffiles_ibfk_1` FOREIGN KEY (`Verification_ID`) REFERENCES `tbl_matchverifications` (`Verification_ID`);

--
-- Constraints for table `tbl_scrimslog`
--
ALTER TABLE `tbl_scrimslog`
  ADD CONSTRAINT `tbl_scrimslog_ibfk_1` FOREIGN KEY (`Squad1_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`),
  ADD CONSTRAINT `tbl_scrimslog_ibfk_2` FOREIGN KEY (`Squad2_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`),
  ADD CONSTRAINT `tbl_scrimslog_ibfk_3` FOREIGN KEY (`Winner_Squad_ID`) REFERENCES `tbl_squadprofile` (`Squad_ID`);

--
-- Constraints for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  ADD CONSTRAINT `fk_squadonsquad` FOREIGN KEY (`Squad_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
