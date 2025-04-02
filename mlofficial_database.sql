-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 07:21 AM
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
-- Table structure for table `tbl_adminaccount`
--

CREATE TABLE `tbl_adminaccount` (
  `Admin_ID` int(11) NOT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(69, "Chang'e", 'Mage', 'IMG/hero/Mage/mg-12.png'),
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
-- Table structure for table `tbl_modaccount`
--

CREATE TABLE `tbl_modaccount` (
  `Moderator_ID` int(11) NOT NULL,
  `Email_Address` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scrimschedules`
--

CREATE TABLE `tbl_scrimschedules` (
  `Schedule_ID` int(255) NOT NULL,
  `Challenger_Squad_ID` int(11) NOT NULL,
  `Squad_ID` int(255) NOT NULL,
  `Scrim_Date` date NOT NULL,
  `Scrim_Time` time NOT NULL,
  `Scrim_Notes` varchar(255) NOT NULL,
  `Status` enum('Pending','Accepted','Rejected') NOT NULL DEFAULT 'Pending',
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp()
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
  `Average_Star` float(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `Squad_ID` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_adminaccount`
--
ALTER TABLE `tbl_adminaccount`
  ADD PRIMARY KEY (`Admin_ID`);

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
-- Indexes for table `tbl_modaccount`
--
ALTER TABLE `tbl_modaccount`
  ADD PRIMARY KEY (`Moderator_ID`);

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
-- Indexes for table `tbl_scrimschedules`
--
ALTER TABLE `tbl_scrimschedules`
  ADD PRIMARY KEY (`Schedule_ID`);

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
  ADD UNIQUE KEY `Squad_ID` (`Squad_ID`);

--
-- Indexes for table `tbl_useractivitylog`
--
ALTER TABLE `tbl_useractivitylog`
  ADD PRIMARY KEY (`Log_ID`);

--
-- Indexes for table `tbl_verificationrequests`
--
ALTER TABLE `tbl_verificationrequests`
  ADD PRIMARY KEY (`Request_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_adminaccount`
--
ALTER TABLE `tbl_adminaccount`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `tbl_modaccount`
--
ALTER TABLE `tbl_modaccount`
  MODIFY `Moderator_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pendingverif`
--
ALTER TABLE `tbl_pendingverif`
  MODIFY `Verification_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_playerprofile`
--
ALTER TABLE `tbl_playerprofile`
  MODIFY `Player_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_scrimschedules`
--
ALTER TABLE `tbl_scrimschedules`
  MODIFY `Schedule_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_squadposts`
--
ALTER TABLE `tbl_squadposts`
  MODIFY `Post_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  MODIFY `Squad_Index` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_squadverification`
--
ALTER TABLE `tbl_squadverification`
  MODIFY `Verification_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_useractivitylog`
--
ALTER TABLE `tbl_useractivitylog`
  MODIFY `Log_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_verificationrequests`
--
ALTER TABLE `tbl_verificationrequests`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
