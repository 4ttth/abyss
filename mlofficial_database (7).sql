-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 11:11 AM
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
-- Database: `mlofficial_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_notes`
--

CREATE TABLE `tbl_admin_notes` (
  `Note_ID` int(11) NOT NULL,
  `Admin_ID` int(11) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_notes`
--

INSERT INTO `tbl_admin_notes` (`Note_ID`, `Admin_ID`, `Subject`, `Message`, `Created_At`) VALUES
(1, 18, 'Moderator Management', 'asdasdasdasd', '2025-04-07 19:05:52'),
(2, 18, 'Masikip Ka Ba?', 'Sino ang PINAKAMASIKIP na moderator?', '2025-04-07 19:07:20'),
(3, 18, 'Pinakamasikip?', 'Sino', '2025-04-08 06:10:44'),
(4, 18, 'AJ BA TO??', 'slight', '2025-04-08 06:38:55'),
(5, 18, 'Testing', 'test everything', '2025-04-08 08:53:50');

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
-- Table structure for table `tbl_contentmanagement`
--

CREATE TABLE `tbl_contentmanagement` (
  `Content_ID` int(11) NOT NULL,
  `Event_Name` varchar(255) NOT NULL,
  `Event_Duration` text NOT NULL,
  `Event_Details` text NOT NULL,
  `Promotional_Content` varchar(255) NOT NULL COMMENT 'Path IMG Displayed',
  `Youtube_Link` varchar(255) NOT NULL,
  `Youtube_Banner` varchar(255) NOT NULL COMMENT 'Path IMG Displayed',
  `Advertisement_Link` varchar(255) NOT NULL,
  `Advertisement_Banner` varchar(255) NOT NULL COMMENT 'Path IMG Displayed',
  `Is_Displayed` tinyint(1) NOT NULL COMMENT 'Boolean (Yes/No)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contentmanagement`
--

INSERT INTO `tbl_contentmanagement` (`Content_ID`, `Event_Name`, `Event_Duration`, `Event_Details`, `Promotional_Content`, `Youtube_Link`, `Youtube_Banner`, `Advertisement_Link`, `Advertisement_Banner`, `Is_Displayed`) VALUES
(1, 'KISHIN DENSETU', 'draw event will be available on 02/03/2025', 'Obtain event-exclusive items such as Chat Bubble and more!', 'IMG/essentials/advertisement.png', 'https://www.youtube.com/watch?v=aYlB6u7YOWQ', '../IMG/essentials/youtubeLink2.png', 'https://play.google.com/store/apps/details?id=com.hhgame.mlbbvn&hl=en-US&pli=1', 'IMG/essentials/advertisement.png', 1),
(2, 'SQUAD BATTLE ROYALE', 'event available from 01/06/2025 to 01/07/2025', 'Team-based strategy battle with rewards for top performers.', 'Join your squad and fight for the championship title with exclusive in-game items.', 'https://www.youtube.com/watch?v=zFgB6gT-KYQ', '../IMG/essentials/youtubeLink3.png', 'https://www.example.com', 'IMG/essentials/advertisement2.png', 0),
(3, 'NEW SEASON LAUNCH', 'starting on 10/05/2025', 'Welcome the new season with updates, skins, and exciting challenges.', 'Seasonal content with exclusive rewards for new season champions.', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', '../IMG/essentials/youtubeLink4.png', 'https://www.storelink.com', 'IMG/essentials/advertisement3.png', 0),
(4, 'EXCLUSIVE OFFERS', 'special offers until 15/05/2025', 'Enjoy discounts and bonus items in this special limited-time event.', 'Get premium content at discounted rates for a limited time!', 'https://www.youtube.com/watch?v=nNfiVmDDYc0', '../IMG/essentials/youtubeLink5.png', 'https://www.deals.com', 'IMG/essentials/advertisement4.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedbacks`
--

CREATE TABLE `tbl_feedbacks` (
  `Feedback_ID` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Feedback_Category` varchar(255) NOT NULL,
  `Feedback_Details` text NOT NULL,
  `Date_Submitted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_feedbacks`
--

INSERT INTO `tbl_feedbacks` (`Feedback_ID`, `User_ID`, `Feedback_Category`, `Feedback_Details`, `Date_Submitted`) VALUES
(1234, 1234, 'Good Sports', 'Sobrang LATINA!', '2025-04-01 06:21:16');

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
-- Table structure for table `tbl_inviteslog`
--

CREATE TABLE `tbl_inviteslog` (
  `Schedule_ID` int(255) NOT NULL,
  `Challenger_Squad_ID` int(11) NOT NULL,
  `Squad_ID` int(255) NOT NULL,
  `Scrim_Date` date NOT NULL,
  `Scrim_Time` time NOT NULL,
  `Scrim_Notes` varchar(255) NOT NULL,
  `Status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_inviteslog`
--

INSERT INTO `tbl_inviteslog` (`Schedule_ID`, `Challenger_Squad_ID`, `Squad_ID`, `Scrim_Date`, `Scrim_Time`, `Scrim_Notes`, `Status`, `Created_At`) VALUES
(1, 28670, 98078, '2025-04-23', '08:49:00', 'hello', 'Pending', '2025-04-07 06:49:18');

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
(3, 'selwyntolero@yahoo.com.phh', '$2y$10$3MF4fuSGLvZnk3n./oVB8.z8D30V/4y16PPwUAoDPTru9zehkQbLS'),
(5, 'sample@gmail.com', '$2y$10$QoxGX0PPf7p4fezPkJc6deqP6wJwSbeKJhKrjgTEiOuhZovQj6qhG');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penalties`
--

CREATE TABLE `tbl_penalties` (
  `Penalty_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Squad_ID` varchar(255) DEFAULT NULL,
  `Penalty_Type` enum('timeout','ban','warning') NOT NULL,
  `Duration_Days` int(11) DEFAULT NULL,
  `Start_Date` datetime NOT NULL,
  `End_Date` datetime DEFAULT NULL,
  `Reason` text NOT NULL,
  `Status` enum('Active','Expired','Penalized') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_penalties`
--

INSERT INTO `tbl_penalties` (`Penalty_ID`, `User_ID`, `Squad_ID`, `Penalty_Type`, `Duration_Days`, `Start_Date`, `End_Date`, `Reason`, `Status`) VALUES
(2, 0, '28670', 'timeout', 1, '2025-04-08 10:11:11', '2025-04-09 10:11:11', 'd', 'Active');

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
  `Full_Name` varchar(100) DEFAULT NULL,
  `Game_ID` varchar(100) DEFAULT NULL,
  `Current_Rank` varchar(45) DEFAULT NULL,
  `Current_Star` int(11) DEFAULT NULL,
  `Highest_Rank` varchar(45) DEFAULT NULL,
  `Highest_Star` int(11) DEFAULT NULL,
  `Role` varchar(45) DEFAULT NULL,
  `Hero_1` varchar(100) DEFAULT NULL,
  `Hero_2` varchar(100) DEFAULT NULL,
  `Hero_3` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_playerprofile`
--

INSERT INTO `tbl_playerprofile` (`Player_ID`, `Squad_ID`, `IGN`, `Full_Name`, `Game_ID`, `Current_Rank`, `Current_Star`, `Highest_Rank`, `Highest_Star`, `Role`, `Hero_1`, `Hero_2`, `Hero_3`) VALUES
(1, 60976, 'brtgb', 'fb', 'bfgb', 'Grandmaster', 23, 'Warrior', 235235, 'Assassin', 'X.Borg', 'Minsitthar', 'Barats'),
(2, 38224, 'Belserion', 'Cj Torress', '81234567', 'Mythical Honor', 30, 'Mythical Immortal', 100, 'Mage', 'Selena', 'Kagura', 'Xavier'),
(3, 38224, 'Synx', 'Joed Guitierez', '987345612', 'Mythical Honor', 40, 'Mythical Immortal', 123, 'Assassin', 'Fanny', 'Suyou', 'Joy'),
(4, 38224, 'kenra', 'Ken Jabagat', '912384756', 'Mythical Honor', 25, 'Mythical Glory', 63, 'Marksman', 'Granger', 'Popol and Kupa', 'Harith'),
(5, 38224, 'gilgamesh', 'Justin Zamora', '823746591', 'Mythical Honor', 28, 'Mythical Immortal', 102, 'Tank', 'Tigreal', 'Ghatotkacha', 'Edith'),
(6, 38224, 'neuvillette', 'Kevin Gelig', '938475610', 'Mythical Glory', 76, 'Mythical Immortal', 109, 'Fighter', 'Balmond', 'Martis', 'Dyrroth'),
(7, 86771, 'DarkNova', 'Jordan Rivera', '948273561', 'Mythic', 13, 'Mythical Glory', 54, 'Fighter', 'Freya', 'Alpha', 'Sun'),
(8, 86771, 'Zanerift', 'Miguel Santos', '895627481', 'Epic I', 4, 'Mythic', 13, 'Mage', 'Gord', 'Valir', 'Vexana'),
(9, 86771, 'frostbyte', 'Enzo Delgado', '934758261', 'Legend I', 2, 'Mythical Honor', 27, 'Fighter', 'Ghatotkacha', 'Dyrroth', 'Yu Zhong'),
(10, 86771, 'nightcrawler', 'Kevin Uy', '879345672', 'Mythic', 7, 'Mythic', 24, 'Marksman', 'Ixia', 'Popol and Kupa', 'Natan'),
(11, 86771, 'SkyeFlare', 'Rafael Cruz', '918273645', 'Epic II', 3, 'Legend III', 3, 'Support', 'Rafaela', 'Mathilda', 'Chip'),
(12, 81346, 'VOIDSNAP', 'James Leo', '976384512', 'Mythic', 5, 'Mythical Glory', 67, 'Assassin', 'Hayabusa', 'Benedetta', 'Lancelot'),
(13, 81346, 'CrysTitan', 'Angelo Torres', '903847162', 'Legend II', 4, 'Mythical Honor', 26, 'Fighter', 'Aldous', 'Masha', 'X.Borg'),
(14, 81346, 'novarea', 'Mark Mendoza', '884736291', 'Epic III', 3, 'Legend IV', 3, 'Mage', 'Cecilion', 'Pharsa', 'Luo Yi'),
(15, 81346, 'BlitzCrank', 'Adrian Co', '965827430', 'Mythic', 11, 'Mythical Honor', 30, 'Marksman', 'Ixia', 'Miya', 'Karrie'),
(16, 81346, 'lightning', 'Dale Enriquez', '901283746', 'Legend I', 5, 'Mythical Honor', 44, 'Tank', 'Khufra', 'Atlas', 'Baxia'),
(17, 28670, 'Kenzo', 'Kenzo Aguilar', '937462851', 'Mythical Glory', 56, 'Mythical Immortal', 157, 'Fighter', 'Ruby', 'Benedetta', 'Lapu-Lapu'),
(18, 28670, 'Yuriii', 'Yuri Santos', '923748652', 'Mythical Glory', 78, 'Mythical Immortal', 207, 'Assassin', 'Fanny', 'Ling', 'Hayabusa'),
(19, 28670, 'whos drei?', 'Andrei Santos', '902837461', 'Mythical Glory', 55, 'Mythical Immortal', 149, 'Marksman', 'Granger', 'Claude', 'Irithel'),
(20, 28670, 'Luxx.', 'Trisha Santos', '978364219', 'Mythical Honor', 34, 'Mythical Immortal', 189, 'Mage', 'Kagura', 'Luo Yi', 'Lunox'),
(21, 28670, 'sai.', 'Isaih Dela Cruz', '995837461', 'Mythical Glory', 56, 'Mythical Immortal', 163, 'Tank', 'Tigreal', 'Chou', 'Jawhead'),
(22, 96990, 'neo?', 'Neo Vince Veracruz', '942837561', 'Mythical Immortal', 108, 'Mythical Immortal', 789, 'Assassin', 'Hayabusa', 'Joy', 'Fanny'),
(23, 96990, 'ashlynx', 'Ashley Martinez', '934756102', 'Mythical Glory', 78, 'Mythical Immortal', 770, 'Mage', 'Valentina', 'Yve', 'Luo Yi'),
(24, 96990, 'renzyTzy', 'Lorenzo Garcia', '988273645', 'Mythical Immortal', 115, 'Mythical Immortal', 1031, 'Marksman', 'Moskov', 'Brody', 'Beatrix'),
(25, 96990, 'darkin clay', 'Clayton Navarro', '975384621', 'Mythical Immortal', 101, 'Mythical Immortal', 670, 'Fighter', 'Edith', 'Ghatotkacha', 'Lapu-Lapu'),
(26, 96990, 'iceice', 'Unice Montemayor', '973846210', 'Mythical Glory', 98, 'Mythical Immortal', 708, 'Support', 'Mathilda', 'Carmilla', 'Estes'),
(27, 54892, 'theooo', 'Theodore Lim', '973846210', 'Mythical Honor', 30, 'Mythical Glory', 89, 'Assassin', 'Alpha', 'Hayabusa', 'Joy'),
(28, 54892, 'juno', 'Juno Sebastion', '964782310', 'Mythical Honor', 32, 'Mythical Immortal', 121, 'Mage', 'Cecilion', 'Pharsa', 'Vexana'),
(29, 54892, 'eli..?', 'Elijah Mendoza', '919283745', 'Mythic', 7, 'Mythical Honor', 27, 'Support', 'Diggie', 'Angela', 'Floryn'),
(30, 54892, 'Blaise', 'Blaise Ramos', '947382614', 'Mythic', 23, 'Mythical Glory', 92, 'Fighter', 'Badang', 'Freya', 'Thamuz'),
(31, 54892, 'NASH.', 'Ignacio Herrerea', '939274851', 'Mythical Glory', 51, 'Mythical Immortal', 104, 'Marksman', 'Hanabi', 'Karrie', 'Lesley'),
(32, 78910, 'romeTzy', 'Jerome Tan', '902834761', 'Mythical Honor', 34, 'Mythical Glory', 89, 'Assassin', 'X.Borg', 'Hayabusa', 'Hanzo'),
(33, 78910, 'yasuo', 'Louie Fernandez', '998273645', 'Mythical Honor', 43, 'Mythical Glory', 78, 'Marksman', 'Hanabi', 'Beatrix', 'Harith'),
(34, 78910, 'vince', 'Vince Dizon', '933748296', 'Mythic', 23, 'Mythical Glory', 65, 'Mage', 'Eudora', 'Chang\'e', 'Zhask'),
(35, 78910, 'jaijai', 'Jhaiden Perez', '910284736', 'Mythic', 9, 'Mythical Honor', 43, 'Fighter', 'Yu Zhong', 'Minsitthar', 'Badang'),
(36, 78910, 'lionin', 'Leonidas Evangelista', '945827361', 'Mythic', 14, 'Mythical Honor', 44, 'Support', 'Estes', 'Hylos', 'Belerick'),
(37, 26601, 'Kianna?', 'Kianna Ong', '973264819', 'Mythical Honor', 30, 'Mythical Glory', 67, 'Mage', 'Kagura', 'Valir', 'Yve'),
(38, 26601, 'DreiTzy', 'Andrei Lao', '987364215', 'Legend IV', 3, 'Mythical Honor', 29, 'Assassin', 'Saber', 'Karina', 'Gusion'),
(39, 26601, 'zezz', 'Zevin Morales', '924738615', 'Mythical Honor', 25, 'Mythical Glory', 52, 'Marksman', 'Ixia', 'Natan', 'Irithel'),
(40, 26601, 'aurelion', 'Kael Salazar', '932874165', 'Mythical Honor', 25, 'Mythical Glory', 54, 'Tank', 'Akai', 'Uranus', 'Khufra'),
(41, 26601, 'riku', 'Rico Martinez', '975648213', 'Legend IV', 2, 'Mythical Honor', 43, 'Fighter', 'Thamuz', 'Leomord', 'Badang'),
(42, 72997, 'Kale', 'Caleb Torres', '991837264', 'Mythical Immortal', 190, 'Mythical Immortal', 1320, 'Assassin', 'Fanny', 'Lancelot', 'Ling'),
(43, 72997, 'gabbie', 'Gabriel Yao', '907182346', 'Mythical Immortal', 122, 'Mythical Immortal', 1289, 'Fighter', 'Chou', 'Lapu-Lapu', 'Benedetta'),
(44, 72997, 'whoszack', 'Zachary Pineda', '948263174', 'Mythical Glory', 98, 'Mythical Immortal', 1231, 'Marksman', 'Wanwan', 'Melissa', 'Beatrix'),
(45, 72997, 'rosie', 'Ren Dela Pena', '948263174', 'Mythical Immortal', 124, 'Mythical Immortal', 1452, 'Mage', 'Cecilion', 'Vexana', 'Kagura'),
(46, 72997, 'yuroichi', 'Yuijiro Tanaka', '948263174', 'Mythical Immortal', 121, 'Mythical Immortal', 1090, 'Tank', 'Khufra', 'Chou', 'Jawhead'),
(47, 98078, 'acethebeast', 'Ace Mariano', '976384512', 'Mythic', 23, 'Mythical Immortal', 122, 'Assassin', 'Benedetta', 'Hanzo', 'Gusion'),
(48, 98078, 'kiel TheGreat', 'Mikhail Santos', '918374625', 'Mythical Honor', 42, 'Mythical Glory', 98, 'Fighter', 'Suyou', 'Sun', 'Alpha'),
(49, 98078, 'jjomjjom', 'Jomar Delos Reyes', '927364815', 'Mythical Honor', 29, 'Mythical Glory', 78, 'Marksman', 'Clint', 'Layla', 'Moskov'),
(50, 98078, 'daxx.', 'Dax Guiterrez', '934762851', 'Mythic', 6, 'Mythical Glory', 65, 'Tank', 'Gloo', 'Uranus', 'Baxia'),
(51, 98078, 'reii', 'Reign Santos', '988263740', 'Mythical Honor', 41, 'Mythical Immortal', 132, 'Mage', 'Pharsa', 'Lunox', 'Kagura'),
(52, 64652, 'xuchii', 'Pauline Toledo', '4928231', 'Elite II', 2, 'Legend III', 5, 'Mage', 'Gord', 'Chang\'e', 'Nana'),
(53, 64652, 'Tartarus', 'Selwyn tolero', '4928232', 'Mythic', 24, 'Mythical Glory', 75, 'Marksman', 'Miya', 'Layla', 'Karrie'),
(54, 64652, 'Esper', 'Julianne Pena', '4928233', 'Legend IV', 5, 'Mythical Glory', 98, 'Tank', 'Akai', 'Grock', 'Johnson'),
(55, 64652, 'Rava', 'Angelo Langgomez', '4928234', 'Legend V', 5, 'Mythical Immortal', 128, 'Support', 'Estes', 'Angela', 'Floryn'),
(56, 64652, 'Daza', 'Isabelle Esquivel', '4928235', 'Legend IV', 5, 'Mythic', 24, 'Fighter', 'Balmond', 'Leomord', 'Yu Zhong'),
(57, 59427, 'xuchii', 'Pauline Toledo', '4928231', 'Grandmaster V', 4, 'Mythic', 23, 'Support', 'Estes', 'Angela', 'Floryn');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `Report_ID` int(11) NOT NULL,
  `Reporter_ID` int(11) NOT NULL,
  `Reported_User_ID` int(11) NOT NULL,
  `Report_Category` varchar(255) NOT NULL,
  `Report_Details` text NOT NULL,
  `Proof_File` varchar(255) DEFAULT NULL,
  `Report_Status` enum('Pending','Reviewed','Action Taken','') NOT NULL,
  `Date_Reported` timestamp NOT NULL DEFAULT current_timestamp(),
  `Reviewed_By` int(255) DEFAULT NULL,
  `Sanction_Taken` text DEFAULT NULL,
  `Date_Reviewed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reports`
--

INSERT INTO `tbl_reports` (`Report_ID`, `Reporter_ID`, `Reported_User_ID`, `Report_Category`, `Report_Details`, `Proof_File`, `Report_Status`, `Date_Reported`, `Reviewed_By`, `Sanction_Taken`, `Date_Reviewed`) VALUES
(1, 96990, 28670, 'Cheating', 'Maphack', NULL, 'Action Taken', '2025-04-08 07:28:43', NULL, NULL, '2025-04-08 08:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrimslog`
--

CREATE TABLE `tbl_scrimslog` (
  `Match_ID` int(255) NOT NULL,
  `Squad1_ID` int(255) NOT NULL,
  `Squad2_ID` int(255) NOT NULL,
  `Scheduled_Time` datetime NOT NULL,
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
  `Squad1_ID` int(255) NOT NULL,
  `Squad2_ID` int(255) NOT NULL,
  `Scheduled_Time` datetime NOT NULL,
  `Scrim_Status` varchar(255) NOT NULL DEFAULT 'Upcoming' COMMENT 'Upcoming/Finished',
  `Winner_Squad_ID` int(255) DEFAULT NULL,
  `Winner_Score` int(11) DEFAULT NULL,
  `Loser_Score` int(11) DEFAULT NULL,
  `Screenshot_Proof` text NOT NULL COMMENT 'File Path',
  `Date_Submitted` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `OCR_Validated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_squadposts`
--

CREATE TABLE `tbl_squadposts` (
  `Post_ID` int(255) NOT NULL,
  `Squad_ID` int(255) NOT NULL,
  `Post_Label` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Image_URL` varchar(255) NOT NULL,
  `Post_Type` enum('Private','Public') NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_squadposts`
--

INSERT INTO `tbl_squadposts` (`Post_ID`, `Squad_ID`, `Post_Label`, `Content`, `Image_URL`, `Post_Type`, `Timestamp`) VALUES
(1, 1, '', 'hello', '/uploads/Screenshot (1).png', 'Public', '2025-04-05 08:30:29');

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
  `Total_Stars` int(255) NOT NULL,
  `Player_Count` int(255) NOT NULL,
  `Average_Star` float(15,4) NOT NULL,
  `isPenalized` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_squadprofile`
--

INSERT INTO `tbl_squadprofile` (`Squad_Index`, `Squad_ID`, `Squad_Name`, `Squad_Acronym`, `Squad_Description`, `Squad_Level`, `Squad_Logo`, `Total_Stars`, `Player_Count`, `Average_Star`, `isPenalized`) VALUES
(1, 60976, 'adf', 'sac', 'cascsaca', 'Amateur', NULL, 235235, 1, 235235.0000, 0),
(2, 38224, 'C++ Esports', 'C++', 'College of Computer Studies', 'Amateur', NULL, 497, 5, 99.4000, 0),
(3, 86771, 'Frost Hunters', 'frzt', 'The best squad in town', 'Amateur', NULL, 121, 5, 24.2000, 0),
(4, 81346, 'Thunder Novas', 'THV', 'Thunder Novas lang sakalam', 'Amateur', NULL, 170, 5, 34.0000, 0),
(5, 28670, 'Lightning Requiem', 'LRe', 'mga mamaw magselos', 'Collegiate', NULL, 865, 5, 173.0000, 0),
(6, 96990, 'NeoBeasts', 'neo', 'NeoBeats Pro Players', 'Professional', NULL, 3968, 5, 793.6000, 0),
(7, 54892, 'The Overdrive', 'ovr', 'Overdrive Squad', 'Amateur', NULL, 433, 5, 86.6000, 0),
(8, 78910, 'Leonin Fighters', 'LFS', 'lore of the best leonin', 'Amateur', NULL, 319, 5, 63.8000, 0),
(9, 26601, 'MetaTzy', 'tzy', 'ayasib vs golagat', 'Amateur', NULL, 245, 5, 49.0000, 0),
(10, 72997, 'Yu Yu Hakusho', 'YYH', 'Oshiete Oshiete', 'Professional', NULL, 6382, 5, 1276.4000, 0),
(11, 98078, 'The Targaryen House', 'TTH', 'Dragons of Targaryen House', 'Amateur', NULL, 495, 5, 99.0000, 0),
(12, 64652, 'DAZABABERS', 'DAZ', 'Hi! We are DAZABABERS', 'Amateur', NULL, 330, 5, 66.0000, 0),
(13, 59427, 'JUNYELERS', 'JUN', 'Hi! We are JUNYELERS', 'Amateur', NULL, 23, 1, 23.0000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_squadverification`
--

CREATE TABLE `tbl_squadverification` (
  `Verification_ID` int(255) NOT NULL,
  `Squad_ID` int(255) NOT NULL,
  `Submitted_By` int(255) NOT NULL COMMENT 'Referenced to tbl_useraccount',
  `Verification_Status` enum('Pending','Approved','Rejected','') NOT NULL,
  `Submission_Date` datetime NOT NULL,
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
  `Role` enum('Admin','Moderator','User') NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_useraccount`
--

INSERT INTO `tbl_useraccount` (`User_ID`, `Email_Address`, `Password`, `Username`, `Squad_ID`, `Role`) VALUES
(3, 'charlieboi@gmail.com', '$2y$12$UM8jRk8M1xKFeVx2TmLEqOZcApfbxQ4zRrqpBCWx46Jk9JPMezPW6', 'charlieboi', 10457, 'User'),
(4, 'sebelletolero@gmail.com', '$2y$12$UZ2O1QikkKPBrQqGbst9e.3LHzRWz4Jn0CDeTUuuEiTDYVMAtUreO', 'sebelle', 60976, 'User'),
(6, 'kamorahalls@gmail.com', 'hall', 'kamora', 1, 'Admin'),
(7, 'cjtoress@gmail.com', '$2y$12$Z1G1P4DrNnD0Y.4M5y2sKuV3jSnpFUoBw5e6VI14LwIxduDByIzpO', 'cole', 38224, 'User'),
(8, 'mirabel123@gmail.com', '$2y$12$vl2AzOLWzDiSNofHjKsmVuYkbeFfvp8qlNUR8BywUT8bGYLrWIzj6', 'mirabel', 86771, 'User'),
(9, 'xuchiitoledo@gmail.com', '$2y$12$b70Fj4eMhTd.y0Av0FgJk.5wYES0qb5jSPXugDZhkFYcUYbjUTQ2i', 'xuchiicakes', 81346, 'User'),
(10, 'selwynatics@gmail.com', '$2y$12$H6Qg7v9LEeXEFNm8OVB0kOAhy9r5SQ1weIDeyiLenPIFnxCrda82.', 'selwynatics', 28670, 'User'),
(11, 'neobeast@gmail.com', '$2y$12$G1R4PpQDX4ejfGTS27.MH.o/Pr2B624ZrMU9A2k6RyeRyPL6UX9Im', 'Neo', 96990, 'User'),
(12, 'theolords@gmail.com', '$2y$12$Rz24TSCJIkWSaO6kYAmDG.siNrQBdLJH24Y6u186TatPQHa0nMA0C', 'Theo', 54892, 'User'),
(13, 'romeoandjuliet@gmail.com', '$2y$12$vxqXz.aoIWpLOqlY4DhSHeJBey32xlyDR.dPk/wB/34Kjrf2xvfVS', 'Randj', 78910, 'User'),
(14, 'kianatics@gmail.com', '$2y$12$TcmjeHpcMjPyiRRSiDwnd.wm6RXKiCBnCt.H4QkACUiS1m8P4iNHm', 'Kianna', 26601, 'User'),
(15, 'theholygrounds@gmail.com', '$2y$12$HUnJ3SCM1qCFOXj/j0QTl.t0R0xYP/CdzoSU1bTwUyYWZEP6W0Aye', 'HolyGrounds', 72997, 'User'),
(16, 'aceofspade@gmail.com', '$2y$12$0QWH5YhRDMeKs1mE9u5tMuFyeJCKL5zIxEjsNhv9nsuXK7CEurmkS', 'Spade', 98078, 'User'),
(17, 'isabelledazabels@gmail.com', '$2y$12$JyMqQdQgeGXpHtuNVVCg7uFay04TtZi2eiY0/QHI3Lg.QJSQ2VeL6', 'isabelle', 64652, 'Moderator'),
(18, 'chachacha!@gmail.com', '$2y$12$blVhIkEvilW48ETPtB9es.SfXn3p1i1cnVJzDFzyG4.nTZwz/WVC.', 'junyel', 59427, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_useractivitylog`
--

CREATE TABLE `tbl_useractivitylog` (
  `Log_ID` int(255) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Activity_Type` varchar(255) NOT NULL,
  `Activity` text NOT NULL,
  `Squad_ID` int(255) NOT NULL
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

--
-- Dumping data for table `tbl_userlogin`
--

INSERT INTO `tbl_userlogin` (`Login_ID`, `User_ID`, `Login_Time`) VALUES
(1, 15, '2025-04-08 07:00:20'),
(2, 17, '2025-04-08 07:00:41'),
(3, 17, '2025-04-08 07:51:55'),
(4, NULL, '2025-04-08 08:36:24'),
(5, NULL, '2025-04-08 08:37:14'),
(6, NULL, '2025-04-08 08:39:38'),
(7, 10, '2025-04-08 08:42:39'),
(8, 10, '2025-04-08 08:43:32'),
(9, 10, '2025-04-08 08:43:45'),
(10, 17, '2025-04-08 08:53:41'),
(11, 18, '2025-04-08 08:55:13'),
(12, 18, '2025-04-08 09:06:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_verificationrequests`
--

CREATE TABLE `tbl_verificationrequests` (
  `Request_ID` int(11) NOT NULL,
  `Squad_ID` int(11) NOT NULL,
  `Squad_Name` int(11) DEFAULT NULL,
  `Squad_Level` enum('Amateur','Collegiate','Professional','') NOT NULL,
  `Proof_Type` varchar(255) NOT NULL,
  `Proof_File` varchar(255) NOT NULL,
  `Status` enum('Pending','Approved','Rejected','') NOT NULL,
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
(5, 28670, NULL, 'Collegiate', 'Official Team Registration', '../uploads/verification/proof_67f393b093a455.47413859.jpg', 'Approved', '2025-04-07 08:58:24', '2025-04-07 06:15:48'),
(6, 96990, NULL, 'Professional', 'Tournament Participation', '../uploads/verification/proof_67f39d12178616.70366738.jpg', 'Approved', '2025-04-07 09:38:26', '2025-04-07 05:39:06'),
(7, 54892, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f39f34db9c75.62616713.jpg', 'Pending', '2025-04-07 09:47:32', NULL),
(8, 78910, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3a0b709aa30.49888957.jpg', 'Pending', '2025-04-07 09:53:59', NULL),
(9, 26601, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3a26287dd87.46825107.jpg', 'Pending', '2025-04-07 10:01:06', NULL),
(10, 72997, NULL, 'Professional', 'Tournament Participation', '../uploads/verification/proof_67f3a48ddef4a1.11534830.jpg', 'Approved', '2025-04-07 10:10:21', '2025-04-08 00:20:21'),
(11, 98078, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3a6132f6d76.49148977.jpg', 'Pending', '2025-04-07 10:16:51', NULL),
(12, 64652, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3bd3d3810b1.77893890.pdf', 'Pending', '2025-04-07 11:55:41', NULL),
(13, 59427, NULL, 'Amateur', 'Certificate of Enrollment', '../uploads/verification/proof_67f3cecf2192c3.48382666.pdf', 'Pending', '2025-04-07 13:10:39', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `tbl_contentmanagement`
--
ALTER TABLE `tbl_contentmanagement`
  ADD PRIMARY KEY (`Content_ID`);

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
-- Indexes for table `tbl_inviteslog`
--
ALTER TABLE `tbl_inviteslog`
  ADD PRIMARY KEY (`Schedule_ID`);

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
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`Report_ID`);

--
-- Indexes for table `tbl_scrimslog`
--
ALTER TABLE `tbl_scrimslog`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin_notes`
--
ALTER TABLE `tbl_admin_notes`
  MODIFY `Note_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_auditlogs`
--
ALTER TABLE `tbl_auditlogs`
  MODIFY `Audit_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contentmanagement`
--
ALTER TABLE `tbl_contentmanagement`
  MODIFY `Content_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_feedbacks`
--
ALTER TABLE `tbl_feedbacks`
  MODIFY `Feedback_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;

--
-- AUTO_INCREMENT for table `tbl_heroimages`
--
ALTER TABLE `tbl_heroimages`
  MODIFY `Hero_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `tbl_inviteslog`
--
ALTER TABLE `tbl_inviteslog`
  MODIFY `Schedule_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_modaccount`
--
ALTER TABLE `tbl_modaccount`
  MODIFY `Moderator_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_penalties`
--
ALTER TABLE `tbl_penalties`
  MODIFY `Penalty_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_pendingverif`
--
ALTER TABLE `tbl_pendingverif`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_playerprofile`
--
ALTER TABLE `tbl_playerprofile`
  MODIFY `Player_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_scrimslog`
--
ALTER TABLE `tbl_scrimslog`
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
  MODIFY `Post_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  MODIFY `Squad_Index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_squadverification`
--
ALTER TABLE `tbl_squadverification`
  MODIFY `Verification_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_useractivitylog`
--
ALTER TABLE `tbl_useractivitylog`
  MODIFY `Log_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_userlogin`
--
ALTER TABLE `tbl_userlogin`
  MODIFY `Login_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_verificationrequests`
--
ALTER TABLE `tbl_verificationrequests`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_auditlogs`
--
ALTER TABLE `tbl_auditlogs`
  ADD CONSTRAINT `fk_modID` FOREIGN KEY (`Moderator_ID`) REFERENCES `tbl_modaccount` (`Moderator_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Constraints for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  ADD CONSTRAINT `fk_squadonsquad` FOREIGN KEY (`Squad_ID`) REFERENCES `tbl_useraccount` (`Squad_ID`);

--
-- Constraints for table `tbl_userlogin`
--
ALTER TABLE `tbl_userlogin`
  ADD CONSTRAINT `tbl_userlogin_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `tbl_useraccount` (`User_ID`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `updatePenaltyStatus` ON SCHEDULE EVERY 1 SECOND STARTS '2025-04-08 16:18:48' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE tbl_penalties 
    SET Status = 'Expired' 
    WHERE End_Date <= NOW() 
    AND Status = 'Active';
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
