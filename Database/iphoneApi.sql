-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2017 at 09:40 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iphoneApi`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `surName` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_img` varchar(250) NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `dateOfBirth` varchar(15) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `age` varchar(10) NOT NULL,
  `country` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `uidNumber` varchar(250) NOT NULL,
  `uidType` varchar(250) NOT NULL,
  `userType` enum('registerUser','webUser') NOT NULL COMMENT 'app use or web suer',
  `status` enum('Active','Inactive') NOT NULL,
  `createDt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surName`, `email`, `password`, `user_img`, `mobileNo`, `dateOfBirth`, `sex`, `age`, `country`, `city`, `address`, `latitude`, `longitude`, `uidNumber`, `uidType`, `userType`, `status`, `createDt`) VALUES
(1, 'pramod', 'jain', 'pramod.jain@consagous.com', '123', '1490265453.png', '9981462821', '3-2-1990', 'male', '27', 'india', 'indore', 'palasia indore', 22.000000, 75.500000, '123abcd', 'android', 'registerUser', 'Active', '2017-03-05 23:56:23'),
(11, 'ram', 'kumar', 'ram@consagous.com', '123', '', '9639632589', '', '', '', '', '', '', 23.000000, 75.000000, '', '', '', 'Active', '2017-06-27 07:39:15');

-- --------------------------------------------------------

--
-- Table structure for table `userloginaccesstoken`
--

CREATE TABLE `userloginaccesstoken` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `token` varchar(150) NOT NULL,
  `createDt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `userloginaccesstoken`
--

INSERT INTO `userloginaccesstoken` (`id`, `userId`, `token`, `createDt`) VALUES
(613, 1, '1_3FxvLg0rcKufi184mbEM', '2017-06-27 07:36:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `userloginaccesstoken`
--
ALTER TABLE `userloginaccesstoken`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `userloginaccesstoken`
--
ALTER TABLE `userloginaccesstoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=614;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
