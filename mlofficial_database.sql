-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2025 at 10:21 PM
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
  `Hero_1` varchar(255) DEFAULT NULL,
  `Hero_2` varchar(255) DEFAULT NULL,
  `Hero_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_playerprofile`
--

INSERT INTO `tbl_playerprofile` (`Player_ID`, `Squad_ID`, `IGN`, `Full_Name`, `Game_ID`, `Current_Rank`, `Current_Star`, `Highest_Rank`, `Highest_Star`, `Role`, `Hero_1`, `Hero_2`, `Hero_3`) VALUES
(8, 23679, 'Tartarus', 'Selwyn tolero', '4928231 (4331)', 'Mythical Glory', 142, 'Grandmaster', 111, 'Support', NULL, NULL, NULL),
(9, 23679, 'xuchii', 'Pauline Toledo', '4928231 (6331)', 'Elite', 3, 'Master', 8, 'Tank', NULL, NULL, NULL),
(10, 21957, 'Tartarus', 'Selwyn Tolero', '09052700278', 'Mythical Immortal', 100, 'Mythical Immortal', 149, 'Mage', NULL, NULL, NULL),
(11, 86573, 'Tartarus', 'Selwyn Tolero', '098837832', 'Elite', 23, 'Grandmaster', 34, 'Fighter', NULL, NULL, NULL),
(12, 60591, 'megurine', 'Pauline Toledo', '4352 5364 (456)', 'Mythic', 23, 'Warrior', 40, 'Assassin', NULL, NULL, NULL),
(13, 17241, 'rav', 'Aj Langgomez', '8979878798', 'Mythical Immortal', 154, 'Mythical Immortal', 170, 'Mage', NULL, NULL, NULL),
(14, 14132, 'Tartarus', 'Selwyn Tolero', '8979878798', 'Epic', 1, 'Mythical Immortal', 149, 'Mage', NULL, NULL, NULL),
(15, 99556, 'xuchii', 'Pauline Toledo', '4928231 (4331)', 'Master', 142, 'Mythical Honor', 200, 'Mage', NULL, NULL, NULL),
(16, 42668, 'xuchii', 'Selwyn tolero', '4928231 (4331)', 'Grandmaster', 123, 'Mythical Honor', 200, 'Mage', NULL, NULL, NULL),
(17, 54802, 'Esper', 'Julianne Pena', '4928231 (4331)', 'Epic', 123, 'Mythical Glory', 200, 'Mage', NULL, NULL, NULL);

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
(1234, 6789, 5432, 'Cheating', 'Maphack', NULL, 'Pending', '2025-03-31 06:18:10', NULL, NULL, NULL),
(1324, 124314, 2133, 'Absence', 'Nde pumunta', NULL, 'Pending', '2025-03-31 06:43:19', NULL, NULL, NULL);

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

--
-- Dumping data for table `tbl_scrimschedules`
--

INSERT INTO `tbl_scrimschedules` (`Schedule_ID`, `Challenger_Squad_ID`, `Squad_ID`, `Scrim_Date`, `Scrim_Time`, `Scrim_Notes`, `Status`, `Created_At`) VALUES
(1, 0, 21957, '2025-03-25', '02:54:00', 'TITE', 'Pending', '2025-04-01 20:02:59'),
(2, 0, 47255, '2025-03-25', '02:56:00', 'TITE FROM', 'Pending', '2025-04-01 20:02:59'),
(3, 0, 47255, '2025-03-06', '16:13:00', 'DHDH', 'Pending', '2025-04-01 20:02:59'),
(4, 0, 47255, '2025-04-02', '16:50:00', 'rgawerg', 'Pending', '2025-04-01 20:02:59');

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
(17, 1, 'BITCH NA PEKE', 'This is my first post! AHH DADII!', '/uploads/R.jpg', 'Private', '2025-03-24 13:11:01');

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

--
-- Dumping data for table `tbl_squadprofile`
--

INSERT INTO `tbl_squadprofile` (`Squad_Index`, `Squad_ID`, `Squad_Name`, `Squad_Acronym`, `Squad_Description`, `Squad_Level`, `Squad_Logo`, `Total_Stars`, `Player_Count`, `Average_Star`) VALUES
(1, 23679, 'VESTA HEAVEN', 'VST', 'HELLO WORLD', 'ANIMO LASALLE', NULL, 220, 5, 44.0000),
(2, 21957, 'LSB SHARKS', 'LSB', 'HELLO PHILIPPINES', 'ANIMO LASALLE', NULL, 180, 4, 45.0000),
(3, 47255, 'BLACKLIST', 'BLCK', 'WORLD CHAMPIONS', 'PROFESSIONAL', NULL, 275, 6, 45.8300),
(4, 21957, 'VAESPA KARINA', 'VST', 'EWAN Q SAU BAKS', 'PROFESSIONAL', NULL, 260, 5, 52.0000),
(5, NULL, 'VSSST', 'heven', 'jdhcdhciehc', 'Amateur', NULL, 0, 0, 0.0000),
(6, NULL, 'LSBSharks', 'lsbShhhh', 'Strong', 'Professional', NULL, 0, 0, 0.0000),
(7, NULL, 'Masisikip', 'MSK', 'Super Sikip', 'Amateur', NULL, 0, 0, 0.0000),
(8, NULL, 'Masisikip', 'MSK', 'Super Sikip', 'Amateur', NULL, 0, 0, 0.0000),
(9, 14132, 'OLAKOMOTALE', 'OLA', 'I2 ANG PINAKAMAGALING SA LAHAT', 'Amateur', NULL, 0, 0, 0.0000),
(10, 99556, 'ARMAINES', 'ARM', 'HUHUEHIHA', 'Amateur', NULL, 200, 1, 200.0000),
(11, 42668, 'AESPAWS', 'AES', 'Hi! We are AESPAWS', 'Amateur', NULL, 200, 1, 200.0000),
(12, 54802, 'JULIESBAKESHOP', 'JBS', 'yummers', 'Amateur', NULL, 200, 1, 200.0000);

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
(51, 'paulinetoledoo026@gmail.com', '$2y$12$X6/vVo.Q63xxeq7UFxaOE.Y14aRIb8vZ398fUhJUnojhvpURNUwp6', 'xuchip', 47255, 'User'),
(52, 'charlesadrian@gmail.com', '$2y$12$1cdc48BCLyb.aaiBjrr4S.e0.fzIlUFZbFeXRGF3hAndzC5Rph2LW', 'charlieboi', 23679, 'User'),
(53, 'lexi.loregomez@gmail.com', '$2y$12$CwNqK/28qwx/QI9LHhc3V.W1cbk9qeh31S8r03Ox1UuNr9OjwrOVK', 'selwyntlr', 21957, 'User'),
(54, 'slwyntlr05@gmail.com', '$2y$12$9CqEHW7Frw2p2F9Hdw1/h.eL7weV8MGWqakURwTzuJrUfzcWwBcQq', 'slwyntlr', 86573, 'User'),
(55, 'col.2023010205@lsb.edu.ph', '$2y$12$5agdk9mLMtVz4RNpf5cdeuJdPcgGCkhkn/4OlWai8BzvTgg/zD4M2', 'xuchi', 60591, 'User'),
(56, 'ajlanggomez123@gmail.com', '$2y$12$MBi8uKn4ikx9MbgyuRKVo.ZjOvdbv9/sNO.yZH31e53uhrd7dqYVO', 'ajlangz', 17241, 'User'),
(57, 'lexi.loregomez@gmail.com', '$2y$12$Ty85Xmbw1Zr2pjM43bYYy.92N3I1pGV5FSijtUf1J1NiXoM8snTzy', 'Tartarus', 14132, 'User'),
(58, 'fourtholpindooo@gmail.com', '$2y$12$MQDYvj/lVZci4J/5zbD/Hez1GC9VgIWySNY8bUwHVoh9tvCxA9dpe', 'fourth', 99556, 'Admin'),
(59, 'jijijijajajaj@gmail.com', '$2y$12$YiEZht/G2UTdv4JFq00lhO8CkQ0rfstlSZKYhiWLDijRwxKiaiOAi', 'cucu', 42668, 'User'),
(60, 'mememe123@gmail.com', '$2y$12$LetQVFFv6vraW8HLx69ZM.Umm8e3DnmvjCiWc9gIrjzC6C/Qeg9z.', 'juliecakes', 54802, 'User');

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
-- Dumping data for table `tbl_verificationrequests`
--

INSERT INTO `tbl_verificationrequests` (`Request_ID`, `Squad_ID`, `Squad_Name`, `Squad_Level`, `Proof_Type`, `Proof_File`, `Status`, `Date_Submitted`, `Date_Reviewed`) VALUES
(1234, 1234, 1234, 'Collegiate', 'anjing', 'desktop/anjing', 'Pending', '2025-04-01 06:29:26', NULL);

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
  MODIFY `Hero_ID` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `Player_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `Report_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1325;

--
-- AUTO_INCREMENT for table `tbl_scrimschedules`
--
ALTER TABLE `tbl_scrimschedules`
  MODIFY `Schedule_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_squadposts`
--
ALTER TABLE `tbl_squadposts`
  MODIFY `Post_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_squadprofile`
--
ALTER TABLE `tbl_squadprofile`
  MODIFY `Squad_Index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_squadverification`
--
ALTER TABLE `tbl_squadverification`
  MODIFY `Verification_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_useraccount`
--
ALTER TABLE `tbl_useraccount`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_useractivitylog`
--
ALTER TABLE `tbl_useractivitylog`
  MODIFY `Log_ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_verificationrequests`
--
ALTER TABLE `tbl_verificationrequests`
  MODIFY `Request_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1235;

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