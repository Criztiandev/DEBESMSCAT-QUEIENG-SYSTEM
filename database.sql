-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2024 at 08:10 AM
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
-- Database: `debesmscat-queueing-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `BATCH_ID` varchar(255) NOT NULL,
  `QUEUE_ID` varchar(255) DEFAULT NULL,
  `DEPARTMENT_ID` varchar(255) DEFAULT NULL,
  `BOOKING_DATE` date DEFAULT NULL,
  `YEARLEVEL` varchar(64) DEFAULT NULL,
  `BATCH_NAME` varchar(64) DEFAULT NULL,
  `MAX_STUDENT` int(11) DEFAULT NULL,
  `STATUS` varchar(64) DEFAULT NULL,
  `STUDENT_IDS` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`STUDENT_IDS`)),
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`BATCH_ID`, `QUEUE_ID`, `DEPARTMENT_ID`, `BOOKING_DATE`, `YEARLEVEL`, `BATCH_NAME`, `MAX_STUDENT`, `STATUS`, `STUDENT_IDS`, `CREATED_AT`, `UPDATED_AT`) VALUES
('079b95dc-7d33-40d1-a3f5-e4599d7b6a53', NULL, '69b40feb-92d9-4452-a1b4-b0130befda82', '2024-08-28', '1', 'College of Arts and Science', 255, 'Active', '[\"817ddda8-1491-43de-b23f-e504798f7516\"]', '2024-08-29 02:49:45', '2024-08-29 03:40:52'),
('500d2b95-c080-4beb-b434-5bd04e7b21eb', NULL, 'd0f2f8d3-8b3d-4eb1-8427-a5d617da03ad', '2024-08-30', '1', 'CENG v1', 255, 'Active', '[\"0fbe760c-fa2b-4e17-afb0-2a66475ead77\",\"43707d53-0e94-44d8-8089-74363fdda9a5\"]', '2024-08-29 02:50:55', '2024-08-29 03:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `ID` varchar(255) NOT NULL,
  `STUDENT_ID` varchar(255) DEFAULT NULL,
  `BATCH_ID` varchar(255) DEFAULT NULL,
  `QUEUE_NUMBER` int(11) DEFAULT 0,
  `REQUEST_FORM` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`REQUEST_FORM`)),
  `PURPOSE` varchar(255) DEFAULT NULL,
  `STATUS` enum('PENDING','ACCEPTED','REJECTED') NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`ID`, `STUDENT_ID`, `BATCH_ID`, `QUEUE_NUMBER`, `REQUEST_FORM`, `PURPOSE`, `STATUS`, `CREATED_AT`, `UPDATED_AT`) VALUES
('3ad38f43-03d0-429d-a6b1-8c5b61c79328', '0fbe760c-fa2b-4e17-afb0-2a66475ead77', '500d2b95-c080-4beb-b434-5bd04e7b21eb', 0, '[\"TOR (NEW \\/ RE-ISSUE)\",\"CERTEFICATE OF HONOR GRADUATE\"]', 'sdfsdf', 'ACCEPTED', '2024-08-29 03:05:04', '2024-08-29 03:35:27'),
('803ed8ce-7692-410c-891f-21604656a27e', '43707d53-0e94-44d8-8089-74363fdda9a5', '500d2b95-c080-4beb-b434-5bd04e7b21eb', 0, '[\"TOR (NEW \\/ RE-ISSUE)\",\"CERTERFICATE OF UNIT EARNED\"]', 'sdfsdfsd', 'ACCEPTED', '2024-08-29 03:28:04', '2024-08-29 03:43:55'),
('e18e0244-7239-4edc-b476-d8a9edb600d9', '817ddda8-1491-43de-b23f-e504798f7516', '079b95dc-7d33-40d1-a3f5-e4599d7b6a53', 0, '[\"TOR (NEW \\/ RE-ISSUE)\",\"REQUEST LETTER FOR FORM 137\\/TOR\",\"ENROLLMENT DATA\"]', 'sdfsdfsdf', 'ACCEPTED', '2024-08-29 03:04:50', '2024-08-29 03:40:52');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `ID` varchar(255) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `DEPARTMENT_ID` varchar(255) NOT NULL,
  `STATUS` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`ID`, `NAME`, `DEPARTMENT_ID`, `STATUS`) VALUES
('54cc6f80-63b3-42f0-8694-8e0a498a5d06', 'Batchelor of Science in Computer Science', '69b40feb-92d9-4452-a1b4-b0130befda82', 'ACTIVE'),
('afac0010-acef-432b-9ac9-d71618c377b8', 'Bachelor of Science in Mechanical Engineering', 'd0f2f8d3-8b3d-4eb1-8427-a5d617da03ad', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DEPARTMENT_ID` varchar(255) NOT NULL,
  `OPERATOR_ID` varchar(255) NOT NULL,
  `DEPARTMENT_NAME` varchar(65) NOT NULL,
  `WINDOWS_NUMBER` int(11) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DEPARTMENT_ID`, `OPERATOR_ID`, `DEPARTMENT_NAME`, `WINDOWS_NUMBER`, `CREATED_AT`, `UPDATED_AT`) VALUES
('69b40feb-92d9-4452-a1b4-b0130befda82', '1dc55e07-f33c-490b-8303-15d2030c983d', 'College of Arts and Science', 1, '2024-08-29 02:04:04', '2024-08-29 02:04:04'),
('d0f2f8d3-8b3d-4eb1-8427-a5d617da03ad', '4ac48aaa-7736-4e64-b8c2-a51760d4e78a', 'College of Engineering', 2, '2024-08-29 02:50:37', '2024-08-29 02:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `ID` varchar(255) NOT NULL,
  `OPERATOR_ID` varchar(255) DEFAULT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `GENDER` varchar(64) NOT NULL,
  `PHONE_NUMBER` varchar(64) NOT NULL,
  `EMAIL` varchar(64) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL,
  `ROLE` enum('staff','admin') NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`ID`, `OPERATOR_ID`, `FIRST_NAME`, `LAST_NAME`, `GENDER`, `PHONE_NUMBER`, `EMAIL`, `PASSWORD`, `ROLE`, `CREATED_AT`, `UPDATED_AT`) VALUES
('1dc55e07-f33c-490b-8303-15d2030c983d', '1992828', 'Francisco', 'Baltazar', 'male', '092883838', 'francisco@gmail.com', '$2y$10$tJRmDOxZxeRbhYYcfxWXqOOFvsZ4qCcilZX4nJmG3vfd3kvu/WBFW', 'staff', '2024-08-29 02:02:57', '2024-08-29 02:02:57'),
('4ac48aaa-7736-4e64-b8c2-a51760d4e78a', '2333232', 'Michael', 'García Flores', 'male', '09288383838', 'michael@gmail.com', '$2y$10$3/ub2WbRllZwYlRibuX4beRp9gj46k3f6Mf73KfUCSuLu0S4T2xOy', 'staff', '2024-08-29 02:50:16', '2024-08-29 02:50:16'),
('783e646f-f2b0-4dac-b1cd-9db87293d2c3', 'admin@gmail.com', 'admin', 'admin', 'male', '09488283838', 'admin@gmail.com', '$2y$10$phWgReJkObxceOcfleljAeRieDQoWR4BJHIDU4Oep3xVA4T83KtBS', 'admin', '2024-08-29 01:44:54', '2024-08-29 01:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `queue_entries`
--

CREATE TABLE `queue_entries` (
  `QUEUE_ID` varchar(255) NOT NULL,
  `BATCH_ID` varchar(255) NOT NULL,
  `STUDENT_QUEUE` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`STUDENT_QUEUE`)),
  `STATUS` varchar(64) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `ID` varchar(255) NOT NULL,
  `STUDENT_ID` varchar(255) DEFAULT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `GENDER` varchar(64) NOT NULL,
  `PHONE_NUMBER` varchar(64) NOT NULL,
  `EMAIL` varchar(64) NOT NULL,
  `PASSWORD` varchar(64) NOT NULL,
  `COURSE` varchar(64) NOT NULL,
  `DEPARTMENT` varchar(64) NOT NULL,
  `YEARLEVEL` varchar(64) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`ID`, `STUDENT_ID`, `FIRST_NAME`, `LAST_NAME`, `GENDER`, `PHONE_NUMBER`, `EMAIL`, `PASSWORD`, `COURSE`, `DEPARTMENT`, `YEARLEVEL`, `CREATED_AT`, `UPDATED_AT`) VALUES
('0fbe760c-fa2b-4e17-afb0-2a66475ead77', '18828282', 'Jane', 'Foster', 'female', '09488282838', 'janefoster@gmail.com', '$2y$10$/7FM3lvuTbwhBiTjli4tFeKG2TYn7dy6zIbVpuq/6u.1/Kb0lH0ZG', 'afac0010-acef-432b-9ac9-d71618c377b8', 'd0f2f8d3-8b3d-4eb1-8427-a5d617da03ad', '1', '2024-08-29 03:03:18', '2024-08-29 03:03:18'),
('43707d53-0e94-44d8-8089-74363fdda9a5', '199283838', 'Another', 'Ceng', 'male', '094884848', 'anotherceng@gmail.com', '$2y$10$8FeWQtvg5f7eX33fTs5sjuQP4fBEN6.oXRkqDzeWOiN1D6M5tVNGa', 'afac0010-acef-432b-9ac9-d71618c377b8', 'd0f2f8d3-8b3d-4eb1-8427-a5d617da03ad', '1', '2024-08-29 03:27:38', '2024-08-29 03:27:38'),
('817ddda8-1491-43de-b23f-e504798f7516', '1992828222', 'Marl', 'Alves', 'male', '0948488283838', 'marl@gmail.com', '$2y$10$UThAatY5SBknuaYQ.hC2wOiAcyoJDGcWhho6.3jtYuT2knJQ6Vd.a', 'afac0010-acef-432b-9ac9-d71618c377b8', '69b40feb-92d9-4452-a1b4-b0130befda82', '1', '2024-08-29 02:48:29', '2024-08-29 03:26:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`BATCH_ID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DEPARTMENT_ID`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PHONE_NUMBER` (`PHONE_NUMBER`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `OPERATOR_ID` (`OPERATOR_ID`);

--
-- Indexes for table `queue_entries`
--
ALTER TABLE `queue_entries`
  ADD PRIMARY KEY (`QUEUE_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PHONE_NUMBER` (`PHONE_NUMBER`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`),
  ADD UNIQUE KEY `STUDENT_ID` (`STUDENT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
