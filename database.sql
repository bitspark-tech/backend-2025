-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 11:49 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_mgmt_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseID` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text,
  `instructor` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseID`, `name`, `description`, `instructor`) VALUES
(1, 'functional analysis', 'the course is for students with a background in basic maths', 'mr. james'),
(2, 'english language', 'the course is for students who want to travel to england', 'madam paraclet'),
(3, 'french language', 'the course is for passe compose', 'mr animbom');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `stID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL,
  `enrollmentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`stID`, `courseID`, `enrollmentDate`) VALUES
(1, 1, '2025-07-31 13:24:24'),
(1, 2, '2025-07-31 13:24:24'),
(1, 3, '2025-07-31 13:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `fid` int(3) NOT NULL,
  `message` text,
  `rating` int(11) DEFAULT NULL,
  `feedbackDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `stID` int(11) NOT NULL,
  `courseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`fid`, `message`, `rating`, `feedbackDate`, `stID`, `courseID`) VALUES
(1, 'i am very happy, learning english language has greatly changed my life', 4, '2025-07-31 13:34:53', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

CREATE TABLE `responses` (
  `resId` int(2) NOT NULL,
  `message` text,
  `restDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `responses`
--

INSERT INTO `responses` (`resId`, `message`, `restDate`, `fid`) VALUES
(1, 'congratulations', '2025-07-31 13:43:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `stID` int(3) NOT NULL,
  `matriculeNo` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `pob` varchar(30) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(30) DEFAULT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`stID`, `matriculeNo`, `dob`, `pob`, `phone`, `address`, `userID`) VALUES
(1, 'bitspark001', '2000-01-31', 'batibo', '+237-677-777-77', 'bambui', 1),
(2, 'BITS-5718', '0000-00-00', NULL, NULL, NULL, 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(3) NOT NULL,
  `firstName` varchar(15) NOT NULL,
  `lastName` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `role` enum('admin','student') DEFAULT 'student',
  `pass` varchar(100) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gender` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `email`, `role`, `pass`, `createdAt`, `gender`) VALUES
(1, 'ngwa', 'paul', 'ngwa@gmail.com', 'student', '$2y$12$Z7lY/DBSJLI98c6yjketxeLV6EGmzlD9OWZfhImfLHAVeRyVjgsp6', '2025-07-31 12:35:51', 'male'),
(5, 'ngwa', 'peter', 'peter@gmail.com', 'student', '$2y$12$Z7lY/DBSJLI98c6yjketxeLV6EGmzlD9OWZfhImfLHAVeRyVjgsp6', '2025-07-31 12:43:23', 'male'),
(7, 'adzefe', 'abdulraman', 'adzefeabdulraman@gmail.com', 'admin', '$2y$12$v/hVaCeXwsQIQN33xF85su//4KAFaoHWt34hAfL/x9yPrNz0/2V4G', '2025-08-02 12:32:12', 'male'),
(8, 'mr', 'admin', 'administrator@gmail.com', 'student', '$2y$10$PRGmW4QEdzDvZXRPHVPVBuK9mk.xr6EaOyX6ZKKT/eMZbCnCDwIhu', '2025-08-05 09:44:07', 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`stID`,`courseID`),
  ADD KEY `fk_course_enrollment` (`courseID`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `fk_course_feedback` (`courseID`),
  ADD KEY `fk_feedback_student` (`stID`);

--
-- Indexes for table `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`resId`),
  ADD KEY `fk_response_feedback` (`fid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`stID`),
  ADD UNIQUE KEY `matriculeNo` (`matriculeNo`),
  ADD UNIQUE KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `courseID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `fid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `responses`
--
ALTER TABLE `responses`
  MODIFY `resId` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `stID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_course_enrollment` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`stID`) REFERENCES `students` (`stID`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `fk_course_feedback` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_feedback_student` FOREIGN KEY (`stID`) REFERENCES `students` (`stID`) ON DELETE CASCADE;

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `fk_response_feedback` FOREIGN KEY (`fid`) REFERENCES `feedbacks` (`fid`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
