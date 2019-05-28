-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2019 at 08:53 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aspareus`
--

-- --------------------------------------------------------

--
-- Table structure for table `companytests`
--

CREATE TABLE `companytests` (
  `TestID` int(25) NOT NULL,
  `CompanyID` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companyuserresults`
--

CREATE TABLE `companyuserresults` (
  `ResultID` int(255) NOT NULL,
  `TestID` int(255) NOT NULL,
  `UserID` int(255) NOT NULL,
  `Result` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `companyusers`
--

CREATE TABLE `companyusers` (
  `UserID` int(25) NOT NULL,
  `CompanyID` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `ID` int(11) NOT NULL,
  `OptionID` int(25) NOT NULL,
  `Option` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `ID` int(11) NOT NULL,
  `QuestionID` int(25) NOT NULL,
  `TestID` int(25) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `ID` int(11) NOT NULL,
  `TestID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `TypeID` int(255) NOT NULL,
  `TypeName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`TypeID`, `TypeName`) VALUES
(1, 'Admin'),
(2, 'Company'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(255) NOT NULL,
  `UserName` text NOT NULL,
  `Password` varchar(25) NOT NULL,
  `Name` text NOT NULL,
  `CompanyInitials` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `UserName`, `Password`, `Name`, `CompanyInitials`) VALUES
(882363892, 'super-admin@admin.as', 'Qwer1234', 'Super-Admin', 'as');

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE `usertypes` (
  `UserID` int(255) NOT NULL,
  `TypeID` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`UserID`, `TypeID`) VALUES
(882363892, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companytests`
--
ALTER TABLE `companytests`
  ADD PRIMARY KEY (`TestID`);

--
-- Indexes for table `companyuserresults`
--
ALTER TABLE `companyuserresults`
  ADD PRIMARY KEY (`ResultID`);

--
-- Indexes for table `companyusers`
--
ALTER TABLE `companyusers`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`TypeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `usertypes`
--
ALTER TABLE `usertypes`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companytests`
--
ALTER TABLE `companytests`
  MODIFY `TestID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=908678575;

--
-- AUTO_INCREMENT for table `companyuserresults`
--
ALTER TABLE `companyuserresults`
  MODIFY `ResultID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=975939942;

--
-- AUTO_INCREMENT for table `companyusers`
--
ALTER TABLE `companyusers`
  MODIFY `UserID` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=944793702;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `TypeID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=972918702;

--
-- AUTO_INCREMENT for table `usertypes`
--
ALTER TABLE `usertypes`
  MODIFY `UserID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=972918702;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
