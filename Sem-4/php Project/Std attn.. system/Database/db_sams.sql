-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 05:13 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sams`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `id` int(11) NOT NULL,
  `roll` int(11) NOT NULL,
  `attend` varchar(255) NOT NULL,
  `att_time` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`id`, `roll`, `attend`, `att_time`) VALUES
(1, 1, 'absent', '2019-01-16'),
(2, 2, 'present', '2019-01-16'),
(3, 3, 'absent', '2019-01-16'),
(4, 4, 'absent', '2019-01-16'),
(5, 5, 'present', '2019-01-16'),
(6, 6, 'present', '2019-01-16'),
(7, 7, 'absent', '2019-01-16'),
(9, 1, 'present', '2019-01-17'),
(10, 2, 'present', '2019-01-17'),
(11, 3, 'absent', '2019-01-17'),
(12, 4, 'absent', '2019-01-17'),
(13, 5, 'present', '2019-01-17'),
(14, 6, 'absent', '2019-01-17'),
(15, 7, 'present', '2019-01-17'),
(31, 6, 'absent', '2019-01-18'),
(30, 5, 'absent', '2019-01-18'),
(29, 4, 'present', '2019-01-18'),
(28, 3, 'present', '2019-01-18'),
(27, 2, 'present', '2019-01-18'),
(26, 1, 'present', '2019-01-18'),
(32, 7, 'present', '2019-01-18'),
(33, 1, 'absent', '2025-03-12'),
(34, 2, 'present', '2025-03-12'),
(35, 3, 'present', '2025-03-12'),
(36, 4, 'present', '2025-03-12'),
(37, 5, 'present', '2025-03-12'),
(38, 6, 'present', '2025-03-12'),
(39, 7, 'present', '2025-03-12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `roll` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`id`, `name`, `roll`) VALUES
(1, 'vivek\r\n', 1),
(2, 'vijay', 2),
(3, 'dhruvraj', 3),
(4, 'pratham', 4),
(5, 'pruthvi\r\n', 5),
(6, 'meet\r\n', 6),
(7, 'nimesh', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
