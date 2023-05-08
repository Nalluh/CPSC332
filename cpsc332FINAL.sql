-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 04:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpsc332`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `questionID` int(11) NOT NULL,
  `questionType` varchar(20) DEFAULT NULL,
  `QuestionAmount` varchar(20) DEFAULT NULL,
  `id` bigint(20) DEFAULT NULL,
  `TimeStamp` date DEFAULT current_timestamp(),
  `description` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--




-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `questionNumber` varchar(3) DEFAULT NULL,
  `answer` varchar(200) DEFAULT NULL,
  `id` bigint(20) DEFAULT NULL,
  `surveyID` varchar(100) DEFAULT NULL,
  `TimeStamp` date DEFAULT current_timestamp(),
  `RID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `responses`
--




-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `SurveyID` varchar(100) NOT NULL,
  `questionID` int(11) DEFAULT NULL,
  `id` bigint(20) DEFAULT NULL,
  `surveyName` varchar(20) DEFAULT NULL,
  `TimeStamp` date DEFAULT current_timestamp(),
  `status` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survey`
--




-- --------------------------------------------------------

--
-- Table structure for table `surveyqnr`
--

CREATE TABLE `surveyqnr` (
  `SurveyID` varchar(100) DEFAULT NULL,
  `id` bigint(20) DEFAULT NULL,
  `surveyOptions` varchar(200) DEFAULT NULL,
  `surveyQuestions` varchar(200) DEFAULT NULL,
  `TimeStamp` date DEFAULT current_timestamp(),
  `questionNumber` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `FName` varchar(20) NOT NULL,
  `LName` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `FName`, `LName`, `email`, `PhoneNumber`, `date`) VALUES
(0, 'anonymous', '0', '0', '0', '0', '0', '2023-05-07 23:26:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`questionID`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD KEY `id` (`id`),
  ADD KEY `surveyID` (`surveyID`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`SurveyID`),
  ADD KEY `id` (`id`),
  ADD KEY `questionID` (`questionID`);

--
-- Indexes for table `surveyqnr`
--
ALTER TABLE `surveyqnr`
  ADD KEY `SurveyID` (`SurveyID`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `questionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`);

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`surveyID`) REFERENCES `survey` (`SurveyID`);

--
-- Constraints for table `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_ibfk_1` FOREIGN KEY (`id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `survey_ibfk_2` FOREIGN KEY (`questionID`) REFERENCES `questions` (`questionID`);

--
-- Constraints for table `surveyqnr`
--
ALTER TABLE `surveyqnr`
  ADD CONSTRAINT `surveyqnr_ibfk_1` FOREIGN KEY (`SurveyID`) REFERENCES `survey` (`SurveyID`),
  ADD CONSTRAINT `surveyqnr_ibfk_2` FOREIGN KEY (`id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
