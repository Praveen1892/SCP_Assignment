-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2021 at 05:44 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_scp`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_details`
--

CREATE TABLE `course_details` (
  `course_id` int(11) NOT NULL COMMENT 'primarykey',
  `course_name` varchar(50) NOT NULL,
  `course_details` text NOT NULL,
  `created_datetime` varchar(20) NOT NULL,
  `modified_datetime` varchar(20) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `course_registration`
--

CREATE TABLE `course_registration` (
  `coursereg_id` int(11) NOT NULL COMMENT 'primarykey',
  `student_id` int(11) NOT NULL COMMENT 'foreign key reference to student regs table ',
  `course_id` int(11) NOT NULL COMMENT 'foreign key reference to course table',
  `created_datetime` varchar(20) NOT NULL,
  `modified_datetime` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `student_registration`
--

CREATE TABLE `student_registration` (
  `student_id` int(11) NOT NULL COMMENT 'primarykey',
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `dob` varchar(15) NOT NULL,
  `contactno` varchar(15) NOT NULL,
  `created_datetime` varchar(20) NOT NULL,
  `modified_datetime` varchar(20) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_details`
--
ALTER TABLE `course_details`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `course_registration`
--
ALTER TABLE `course_registration`
  ADD PRIMARY KEY (`coursereg_id`),
  ADD KEY `student_reg_id` (`student_id`) USING BTREE,
  ADD KEY `course_pk_id` (`course_id`) USING BTREE;

--
-- Indexes for table `student_registration`
--
ALTER TABLE `student_registration`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_details`
--
ALTER TABLE `course_details`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primarykey';

--
-- AUTO_INCREMENT for table `course_registration`
--
ALTER TABLE `course_registration`
  MODIFY `coursereg_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primarykey';

--
-- AUTO_INCREMENT for table `student_registration`
--
ALTER TABLE `student_registration`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primarykey';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
