-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 21, 2021 at 10:07 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atrium-roadmap-automation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@mail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('8df5b1592a5139945f863106993b9fb9', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36', 1632115029, 'a:6:{s:9:\"user_data\";s:0:\"\";s:2:\"id\";s:1:\"6\";s:10:\"first_name\";s:7:\"Falguni\";s:9:\"last_name\";s:10:\"Chatterjee\";s:5:\"email\";s:31:\"mr.falguni.chatterjee@gmail.com\";s:3:\"otp\";s:6:\"789020\";}');

-- --------------------------------------------------------

--
-- Table structure for table `dbs`
--

CREATE TABLE `dbs` (
  `id` int(11) NOT NULL,
  `database_name` varchar(255) NOT NULL,
  `database_status` varchar(255) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_user` varchar(100) NOT NULL,
  `create_method` varchar(100) NOT NULL,
  `modify_date` date DEFAULT NULL,
  `modify_user` varchar(100) DEFAULT NULL,
  `modify_method` varchar(100) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `delete_user` varchar(100) DEFAULT NULL,
  `delete_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dbs`
--

INSERT INTO `dbs` (`id`, `database_name`, `database_status`, `create_date`, `create_user`, `create_method`, `modify_date`, `modify_user`, `modify_method`, `delete_date`, `delete_user`, `delete_method`) VALUES
(1, 'Atrium', 'Encrypted', '2021-05-06', 'Bubai', 'POST', '2021-05-06', 'Bubai', 'POST', NULL, NULL, NULL),
(3, 'Falguni', 'Encrypted', '2021-05-06', 'Bubai', 'POST', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `developer_efficiency`
--

CREATE TABLE `developer_efficiency` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `developer_name` varchar(255) DEFAULT NULL,
  `efficiency` float(10,2) DEFAULT NULL,
  `zoho_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `developer_efficiency`
--

INSERT INTO `developer_efficiency` (`id`, `developer_name`, `efficiency`, `zoho_id`) VALUES
(42, 'Jon Gear', 0.50, '406743000000144001'),
(43, 'Dan Dauchy', 0.50, '406743000000339001'),
(44, 'Ben Kahoussi', 0.50, '406743000000153001'),
(45, 'Nila Saha', 0.70, '406743000000366001'),
(46, 'David McQuillin', 0.80, '406743000000344001'),
(47, 'Alejandro Forero', 0.60, '406743000000371001'),
(48, 'Matt Stapleton', 0.90, '406743000000369001'),
(49, 'Karen Vicknair', 0.80, '406743000000392001');

-- --------------------------------------------------------

--
-- Table structure for table `development_amount`
--

CREATE TABLE `development_amount` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `development_amount`
--

INSERT INTO `development_amount` (`id`, `name`, `amount`) VALUES
(1, 'Atrium', 40.00),
(2, 'StudentLink', 80.00),
(3, 'India Firm', 30.00),
(4, 'V4', 40.00),
(5, 'Other Outside Firm', 70.00);

-- --------------------------------------------------------

--
-- Table structure for table `internal_rank`
--

CREATE TABLE `internal_rank` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `internal_rank`
--

INSERT INTO `internal_rank` (`id`, `name`, `amount`) VALUES
(1, 'Percentage of Total Strategic Ranking', 0.30),
(2, 'Percentage of Total Tactical Ranking', 0.40);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(50) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` int(11) DEFAULT NULL,
  `team` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `create_date` date DEFAULT current_timestamp(),
  `create_user` varchar(100) DEFAULT NULL,
  `create_method` varchar(100) DEFAULT NULL,
  `modify_date` date DEFAULT NULL,
  `modify_user` varchar(100) DEFAULT NULL,
  `modify_method` varchar(100) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `delete_user` varchar(100) DEFAULT NULL,
  `delete_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `first_name`, `last_name`, `username`, `password`, `mobile`, `email`, `otp`, `team`, `create_date`, `create_user`, `create_method`, `modify_date`, `modify_user`, `modify_method`, `delete_date`, `delete_user`, `delete_method`) VALUES
(6, 'Falguni', 'Chatterjee', 'falguni', '$1$JjK4dGEA$FKvam.6tkWH8hllX9oJGB.', '9732361967', 'mr.falguni.chatterjee@gmail.com', 789020, 'a:3:{i:0;s:3:\"CEO\";i:1;s:11:\"Engineering\";i:2;s:14:\"Implementation\";}', '2021-04-30', NULL, NULL, '2021-05-06', 'Bubai', NULL, NULL, NULL, NULL),
(18, 'Nilanjan', 'Saha', 'nilanjan', '$1$D7ew/N7f$knl3bfIwlP/jO4cAaqSOl/', '7899777798', 'nilanjan@gmail.com', NULL, 'a:2:{i:0;s:3:\"CEO\";i:1;s:11:\"Engineering\";}', '2021-05-13', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `release_definition`
--

CREATE TABLE `release_definition` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `release_definition`
--

INSERT INTO `release_definition` (`id`, `name`, `start_date`, `end_date`) VALUES
(7, '2019.DEC', '2019-12-01', '2020-05-31'),
(8, '2020.JUN', '2020-06-01', '2020-11-30'),
(9, '2020.DEC', '2020-12-01', '2021-05-31'),
(10, '2021.JUN', '2021-06-01', '2021-11-30'),
(11, '2021.DEC', '2021-12-01', '2022-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `can_assign` int(11) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_user` varchar(100) DEFAULT NULL,
  `create_method` varchar(100) DEFAULT NULL,
  `modify_date` date DEFAULT NULL,
  `modify_user` varchar(100) DEFAULT NULL,
  `modify_method` varchar(100) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `delete_user` varchar(100) DEFAULT NULL,
  `delete_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`id`, `team_name`, `can_assign`, `create_date`, `create_user`, `create_method`, `modify_date`, `modify_user`, `modify_method`, `delete_date`, `delete_user`, `delete_method`) VALUES
(19, 'CEO', 0, '2021-05-13', 'Falguni', 'POST', '2021-05-13', 'Falguni', 'POST', NULL, NULL, NULL),
(20, 'Sales', 1, '2021-05-13', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Engineering', 1, '2021-05-13', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Customer support', 1, '2021-05-13', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `refresh_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`id`, `access_token`, `refresh_token`) VALUES
(6, '1000.9efe7a42a1d56b220664ac3c669f4847.aee60b37558d85136a14f4f6fccd8f9c', '1000.a36cecc94cdfc49f76535c2557be9167.643b92a1dbe13515b1fbacc94e52e321');

-- --------------------------------------------------------

--
-- Table structure for table `versions`
--

CREATE TABLE `versions` (
  `id` int(11) NOT NULL,
  `version_name` varchar(255) NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `create_user` varchar(100) NOT NULL,
  `create_method` varchar(100) NOT NULL,
  `modify_date` date DEFAULT NULL,
  `modify_user` varchar(100) DEFAULT NULL,
  `modify_method` varchar(100) DEFAULT NULL,
  `delete_date` date DEFAULT NULL,
  `delete_user` varchar(100) DEFAULT NULL,
  `delete_method` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `versions`
--

INSERT INTO `versions` (`id`, `version_name`, `create_date`, `create_user`, `create_method`, `modify_date`, `modify_user`, `modify_method`, `delete_date`, `delete_user`, `delete_method`) VALUES
(1, '2021.05', '2021-05-26', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL),
(2, '2021.06', '2021-05-26', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL),
(3, '2021.05.2', '2021-05-31', 'Falguni', 'POST', NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `dbs`
--
ALTER TABLE `dbs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `developer_efficiency`
--
ALTER TABLE `developer_efficiency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `development_amount`
--
ALTER TABLE `development_amount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_rank`
--
ALTER TABLE `internal_rank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `release_definition`
--
ALTER TABLE `release_definition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `versions`
--
ALTER TABLE `versions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dbs`
--
ALTER TABLE `dbs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `developer_efficiency`
--
ALTER TABLE `developer_efficiency`
  MODIFY `id` bigint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `development_amount`
--
ALTER TABLE `development_amount`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `internal_rank`
--
ALTER TABLE `internal_rank`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `release_definition`
--
ALTER TABLE `release_definition`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `versions`
--
ALTER TABLE `versions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
