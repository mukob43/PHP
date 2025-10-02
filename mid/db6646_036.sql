-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2025 at 06:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db6646_036`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb6646_036`
--

CREATE TABLE `tb6646_036` (
  `n_name` varchar(50) NOT NULL,
  `key` int(5) NOT NULL,
  `std_id` varchar(9) NOT NULL,
  `f_name` varchar(100) NOT NULL,
  `l_name` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb6646_036`
--

INSERT INTO `tb6646_036` (`n_name`, `key`, `std_id`, `f_name`, `l_name`, `mail`, `tel`, `created_at`) VALUES
('', 1, '664230036', 'กอบพงศ์', 'อยู่สถิตย์', 'mukob42@mail.com', '0982767180', '2025-10-02 03:20:25'),
('', 2, '664230051', 'กอบพงศ์', 'อยู่สถิตย์', 'mukob1@mail.com', '0982767180', '2025-10-02 03:51:23'),
('กอบ', 3, '664230001', 'กอบพงศ์', 'รอบที่3', 'mukob2@mail.com', '0982767180', '2025-10-02 03:54:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb6646_036`
--
ALTER TABLE `tb6646_036`
  ADD PRIMARY KEY (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb6646_036`
--
ALTER TABLE `tb6646_036`
  MODIFY `key` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
