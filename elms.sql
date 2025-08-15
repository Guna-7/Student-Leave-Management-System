-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 05:22 AM
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
-- Database: `elms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`UserName`, `Password`) VALUES
('admin', '5531a5834816222280f20d1ef9e95f69'),
('ashwin', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartments`
--

CREATE TABLE `tbldepartments` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(150) DEFAULT NULL,
  `DepartmentShortName` varchar(100) NOT NULL,
  `DepartmentCode` varchar(50) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbldepartments`
--

INSERT INTO `tbldepartments` (`id`, `DepartmentName`, `DepartmentShortName`, `DepartmentCode`, `CreationDate`) VALUES
(1, 'CSE', 'CSE', '', '2017-11-01 07:16:25'),
(2, 'ECE', 'ECE', '', '2017-11-01 07:19:37'),
(3, 'EEE', 'EEE', '', '2017-12-02 21:28:56'),
(5, 'IT', 'IT', '', '2023-10-08 19:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(100) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `EmailId` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(200) NOT NULL,
  `Country` varchar(150) NOT NULL,
  `Phonenumber` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`id`, `EmpId`, `FirstName`, `LastName`, `EmailId`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `City`, `Country`, `Phonenumber`, `Status`, `RegDate`) VALUES
(1, 'PHPTPOINT101', 'Abilash', 'R', 'er.gautamarya@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', '3 February, 1999', 'Information Technology', 'Hosur', 'Delhi', 'India', '9608993215', 0, '2020-07-07 11:29:59'),
(2, 'PHPTPOINT1012', 'sanjeev', 'kumar', 'phptpoint@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Male', '3 February, 1990', 'Information Technology', 'Noida ', 'Up', 'India', '8587944255', 1, '2017-11-10 13:40:02'),
(3, 'ashwin', 'Ashwin', 'D', 'ashwin@gmail.com', '56746c912b8f827a21d0f44f4cecdd28', 'Male', '3 October, 2017', '', 'Agraharam', 'Tirupattur', 'India', '9876543210', 1, '2023-10-08 12:03:02'),
(4, 'Guna', 'Guna', 'D', 'duna@gmail.com', '5531a5834816222280f20d1ef9e95f69', '', '', '', 'bbbb', 'aaa', 'aaaaa', '7894561230', 1, '2023-10-08 12:10:00'),
(5, 'AC20UCS017', 'Bhuvanesh', 'KR', 'bhuva@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '', '', 'Hosur', 'Hosur', 'India', '7788994455', 1, '2023-10-08 19:42:09'),
(6, 'AC20UCS002', 'ABILASH', 'R', 'abi@gmail.com', '7e45696bc221625bbb2242260d0f6cf2', 'Male', '2 July, 2015', 'CSE', 'XXXX', 'HOSUR', 'INDIA', '9087654321', 1, '2023-10-23 13:04:44');

-- --------------------------------------------------------

--
-- Table structure for table `tblleaves`
--

CREATE TABLE `tblleaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblleaves`
--

INSERT INTO `tblleaves` (`id`, `LeaveType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`) VALUES
(7, 'Casual Leave', '10/02/2020', '29/10/2020', 'test', '2020-05-01 13:11:21', 'publishing industries for ', '2017-12-02 23:26:27 ', 2, 1, 1),
(8, 'Medical Leave test', '21/10/2020', '25/10/2020', 'test', '2020-05-01 11:14:14', 'Lorem ipsum  borum.', '2017-12-02 23:24:39 ', 1, 1, 1),
(9, 'Medical Leave test', '08/12/2022', '12/12/2022', 'test', '2020-06-01 18:26:01', 'ok', '2020-07-07 16:13:33 ', 2, 1, 2),
(10, 'Restricted Holiday(RH)', '25/12/2020', '25/12/2022', 'test', '2020-07-02 08:29:07', 'done', '2017-12-03 14:06:12 ', 1, 1, 1),
(11, 'Casual Leave', '11/02/2033', '11/02/2033', 'dbdfb', '2020-07-07 10:51:37', 'goooo', '2020-07-07 16:30:52 ', 1, 1, 1),
(12, '', '15/10/2023', '11/10/2023', 'to addend brothers marrage', '2023-10-08 11:41:38', 'leave accepted', '2023-10-08 17:13:12 ', 1, 1, 2),
(13, 'Casual Leave', '17/10/2023', '15/10/2023', '4otyuth', '2023-10-09 05:27:15', 'seekrama vanthranum seriyaaaa\r\n', '2023-10-09 10:58:10 ', 1, 1, 5),
(14, 'Casual Leave', '17/10/2023', '15/10/2023', 'example ', '2023-10-09 07:01:41', 'ex', '2023-10-09 12:33:47 ', 1, 1, 5),
(15, 'Casual Leave', '12/12/2023', '12/12/2023', 'zzz', '2023-10-17 13:48:45', NULL, NULL, 0, 0, 5),
(16, 'Out-College', '30/12/2022', '20/12/2022', 'sym', '2023-10-17 13:56:02', NULL, NULL, 0, 1, 5),
(17, '', '14/05/2012', '05/04/2054', 'iv', '2023-10-17 14:00:02', NULL, NULL, 0, 0, 5),
(18, 'In-College', '05/05/2055', '05/05/2055', '.n.nn', '2023-10-17 14:12:39', NULL, NULL, 0, 1, 5),
(19, 'Casual Leave', '15/12/2023', '12/12/2023', 'as', '2023-10-17 16:28:07', 'take leave\r\n', '2023-10-17 21:59:09 ', 1, 1, 5),
(20, '', '14/12/2023', '12/12/2023', 'dd', '2023-10-17 17:57:44', NULL, NULL, 0, 0, 5),
(21, '', '14/12/2023', '12/12/2023', 'dd', '2023-10-17 17:58:22', NULL, NULL, 0, 0, 5),
(22, '', '14/11/2011', '11/11/2011', 'example 11', '2023-10-17 18:00:21', NULL, NULL, 0, 0, 5),
(23, '', '14/11/2011', '11/11/2011', 'example 11', '2023-10-17 18:01:16', NULL, NULL, 0, 0, 5),
(24, '', '14/11/2011', '11/11/2011', 'example 11', '2023-10-17 18:02:49', NULL, NULL, 0, 0, 5),
(25, 'Out-College', '14/12/2023', '12/12/2023', 'exp 12', '2023-10-17 18:05:24', NULL, NULL, 0, 1, 5),
(26, '', '20/12/2023', '14/12/2023', 'exp 22', '2023-10-17 18:15:48', NULL, NULL, 0, 0, 5),
(27, 'Out-College', '19/12/2023', '17/12/2023', 'exp 24', '2023-10-17 18:16:53', NULL, NULL, 0, 1, 5),
(28, 'In-College', '14/12/2023', '11/12/2023', 'exp 27', '2023-10-17 19:55:34', NULL, NULL, 0, 0, 5),
(29, 'In-College', '14/12/2023', '11/12/2023', 'exp 27', '2023-10-17 19:56:40', NULL, NULL, 0, 0, 5),
(30, 'In-College', '15/12/2023', '12/12/2023', 'exp 28', '2023-10-17 19:57:14', NULL, NULL, 0, 1, 5),
(31, 'In-College', '12/12/2023', '11/12/2023', 'exp 30', '2023-10-17 20:00:45', NULL, NULL, 0, 0, 5),
(32, 'In-College', '15/12/2023', '14/12/2023', 'exp 32', '2023-10-17 20:24:13', NULL, NULL, 0, 0, 5),
(33, 'In-College', '12/10/2023', '10/10/2023', 'exp 32', '2023-10-18 03:27:33', NULL, NULL, 0, 1, 5),
(34, 'In-College', '05/10/2023', '02/10/2023', 'im sorry', '2023-10-18 03:40:17', 'take leave', '2023-10-18 10:31:50 ', 1, 1, 5),
(35, 'Casual Leave', '12/11/2023', '11/11/2023', 'going to temple', '2023-10-18 05:02:58', 'LEAVE APPROVED', '2023-10-23 18:44:19 ', 1, 1, 5),
(36, '(OD) In-College', '11/12/2023', '11/11/2023', 'sympo', '2023-10-18 05:08:53', 'take leave\r\n', '2023-10-18 10:42:00 ', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `LeaveType`, `Description`, `CreationDate`) VALUES
(1, 'Casual Leave', 'Casual Leave ', '2017-11-01 12:07:56'),
(2, 'Medical Leave test', 'Medical Leave  test', '2017-11-06 13:16:09'),
(3, 'Restricted Holiday(RH)', 'Restricted Holiday(RH)', '2017-11-06 13:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `tblod`
--

CREATE TABLE `tblod` (
  `id` int(11) NOT NULL,
  `OdType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblod`
--

INSERT INTO `tblod` (`id`, `OdType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`) VALUES
(0, 'In-College', '05/05/2055', '05/05/2055', 'KN J ', '2023-10-17 14:14:51', NULL, NULL, 0, 0, 5),
(0, 'Out-College', '05/05/2055', '05/05/2055', ',JLBNLB', '2023-10-17 14:15:07', NULL, NULL, 0, 0, 5),
(0, 'In-College', '14/10/2023', '10/02/2020', 'aaa', '2023-10-17 17:45:08', NULL, NULL, 0, 0, 5),
(0, 'In-College', '12/12/2023', '10/12/2023', 'aa', '2023-10-17 17:45:34', NULL, NULL, 0, 0, 5),
(0, 'In-College', '13/04/2022', '12/04/2022', 'qece', '2023-10-17 17:46:11', NULL, NULL, 0, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tblodtype`
--

CREATE TABLE `tblodtype` (
  `id` int(11) NOT NULL,
  `OdType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblodtype`
--

INSERT INTO `tblodtype` (`id`, `OdType`, `Description`, `CreationDate`) VALUES
(1, '(OD) In-College', '(OD) In-Collegee ', '2017-11-01 06:37:56'),
(2, '(OD) Out-College', '(OD) Out-Collegee', '2017-11-06 07:46:09');

--
-- Indexes for dumped tables
--
CREATE TABLE `tblstaff` (
  `StaffID` int(11) NOT NULL,
  `StaffName` varchar(255) DEFAULT NULL,
  `DOB` date NOT NULL,
  `Designation` varchar(255) DEFAULT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO 'tblstaff' ('StaffID','StaffName','DOB','Designation') VALUES ('1234','guna','3 February, 1999','ggg')
--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleaves`
--
ALTER TABLE `tblleaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserEmail` (`empid`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblodtype`
--
ALTER TABLE `tblodtype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblleaves`
--
ALTER TABLE `tblleaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
