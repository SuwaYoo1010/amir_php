-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2024 at 02:39 PM
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
-- Database: `studentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `password`, `name`, `course`, `email`, `role`, `student_id`) VALUES
(24, '$2y$10$TE9vhVLscKQrmQgKqP1HVeYg.gE83gXtTz0twkScgaA0yeFbCXojy', 'Lee Hi', 'Bachelor of Arts in Multimedia Arts', 'hahatdoggz@gmail.com', 'admin', 20),
(27, '$2y$10$H24NulC00Qz15pRrb3NAFe2rOuKAIK0uSVM0ExIK0YbKeUwwSBrxK', 'Hash Tagger', 'Bachelor of Science in Civil Engineering', 'hash@gmail.com', '', 22),
(28, '$2y$10$iLztRUcNhuJaIPCxbQnU1O.YDz.r6//A00AVud2v/ptdiNFtqz4qq', 'Syd Hartha', 'Bachelor of Arts in Multimedia Arts', 'nibgba@gmail.com', '', 23),
(30, '$2y$10$2bSsGRynKh55rbb4RWRa6.IIIwvLSHTnDmcy8p.y6/vluD/eLmwm2', 'Sophia Macapodi', 'Bachelor of Science in Nursing', 'mamawmagselos@gmail.com', '', 25),
(31, '$2y$10$rDG9h/s9ng4aWiuy1gHdJe22OChW4.cWo977Sv5CERr1egDSGPIta', 'Yor Forger', 'Bachelor of Science in Tourism Management', 'yor@forger.com', '', 26),
(32, '$2y$10$gNLqXQNj2dArcN1WwbRYc.FvZMxUrosJfawHT4W49FVRXETNz2CIy', 'Luna Fox', 'Bachelor of Science in Textile', 'lluna@gmail.com', '', 27),
(33, '$2y$10$imasj8PRYKp.ypsG4T2yqO2GSVqqu.92FA/14iaLUDw0sWrVCXXX2', 'Natuto Shapaden', 'Bachelor of Arts in Multimedia Arts', 'tanders@gmail.com', '', 28),
(34, '$2y$10$GleLDYlbR6UIh9FJMpslc.8H2HiGoYeADSlg7IYuSRd1FJ6Ogd5Oa', 'Vanessa Elise', 'Bachelor of Science in Architecture', 'tugkilers@gmail.com', '', 29),
(35, '$2y$10$/lY61MM81VN1H4itk.1ftOuDbLTK7k0rayJ/5oEXrZtzILkVadgOm', 'Kaisa Tapiz', 'Bachelor of Science in Nursing', 'rwtsw@email.com', '', 30),
(36, '$2y$10$EnSNUvoDXh6MxQdXLMfJr.ektwiwkWvCMomad0ZMmx370gTK6jll2', 'Katalista Herrera', 'Bachelor of Science in Accountancy', 'eyyow65@yopmail.com', '', 31),
(37, '$2y$10$VviHFqPQE4o6USeKwvjhDe.zBQumR9YLBysjhqYtke5BEimf2dzni', 'Lumiere Kara', 'Bachelor of Arts in Multimedia Arts', 'ash@gmail.com', '', 32),
(38, '$2y$10$fHUCbPsyRceYJ.yhiOAXoeQNwZlw1DrgTboTvRjJREvjs5QGdGY1O', 'Allen Walker', 'Bachelor of Science in Civil Engineering', 'halla@gm.com', '', 33);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `age` int(2) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `gpa` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `age`, `email`, `gpa`) VALUES
(20, 'Lee Hi', 20, 'hahatdoggz@gmail.com', 1.25),
(22, 'Hash Tagger', 19, 'hash@gmail.com', 1.75),
(23, 'Syd Hartha', 19, 'nibgba@gmail.com', 2.75),
(25, 'Sophia Macapodi', 19, 'mamawmagselos@gmail.com', 1),
(26, 'Yor Forger', 25, 'yor@forger.com', 2.25),
(27, 'Luna Fox', 21, 'lluna@gmail.com', 3),
(28, 'Natuto Shapaden', 25, 'tanders@gmail.com', 2),
(29, 'Vanessa Elise', 24, 'tugkilers@gmail.com', 1.5),
(30, 'Kaisa Tapiz', 22, 'rwtsw@email.com', 1),
(31, 'Katalista Herrera', 21, 'eyyow65@yopmail.com', 1.5),
(32, 'Lumiere Kara', 26, 'ash@gmail.com', 1),
(33, 'Allen Walker', 19, 'halla@gm.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
