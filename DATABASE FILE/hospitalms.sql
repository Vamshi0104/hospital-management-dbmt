-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2024 at 12:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospitalms`
--

-- --------------------------------------------------------

--
-- Table structure for table `ADMIN`
--

CREATE TABLE `ADMIN` (
  `ADMIN_ID` varchar(50) NOT NULL,
  `ADMIN_PASSWORD` varchar(30) NOT NULL,
  `DOCTOR_SPEC_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `ADMIN`
--

INSERT INTO `ADMIN` (`ADMIN_ID`, `ADMIN_PASSWORD`, `DOCTOR_SPEC_ID`) VALUES
('admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `APPOINTMENT`
--

CREATE TABLE `APPOINTMENT` (
  `APPOINTMENT_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `DOCTOR_ID` int(11) NOT NULL,
  `APPOINTMENT_DATE` datetime NOT NULL,
  `APPOINTMENT_TIME` time NOT NULL,
  `USER_STATUS` int(11) NOT NULL,
  `DOCTOR_STATUS` int(11) NOT NULL,
  `DOCTOR_SPEC_ID` int(11) NOT NULL,
  `REASON_FOR_VISIT` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `APPOINTMENT`
--

INSERT INTO `APPOINTMENT` (`APPOINTMENT_ID`, `PATIENT_ID`, `DOCTOR_ID`, `APPOINTMENT_DATE`, `APPOINTMENT_TIME`, `USER_STATUS`, `DOCTOR_STATUS`, `DOCTOR_SPEC_ID`, `REASON_FOR_VISIT`) VALUES
(13, 37, 2311953, '2024-04-25 00:00:00', '08:00:00', 1, 1, 1, 'dizziness'),
(17, 37, 2313782, '2024-04-30 00:00:00', '10:00:00', 1, 1, 6, 'Nerve weakness'),
(25, 47, 2344937, '2024-04-30 00:00:00', '12:00:00', 1, 0, 4, 'Heart Attack');

-- --------------------------------------------------------

--
-- Table structure for table `BILLING`
--

CREATE TABLE `BILLING` (
  `BILLING_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `TYPE` varchar(250) NOT NULL,
  `AMOUNT` float NOT NULL,
  `BALANCE_AMOUNT` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `BILLING`
--

INSERT INTO `BILLING` (`BILLING_ID`, `PATIENT_ID`, `ID`, `TYPE`, `AMOUNT`, `BALANCE_AMOUNT`) VALUES
(4, 37, 13, 'Consulting Fees', 450, 180),
(7, 37, 16, 'Consulting Fees', 200, 80),
(8, 37, 17, 'Consulting Fees', 500, 200),
(9, 40, 18, 'Consulting Fees', 200, 200),
(14, 38, 23, 'Consulting Fees', 200, 120),
(15, 38, 2, 'Prescription Fees', 1200, 720),
(16, 46, 24, 'Consulting Fees', 200, 200),
(17, 47, 25, 'Consulting Fees', 600, 600);

-- --------------------------------------------------------

--
-- Table structure for table `DOCTOR`
--

CREATE TABLE `DOCTOR` (
  `DOCTOR_ID` int(11) NOT NULL,
  `DOCTOR_PASSWORD` varchar(100) NOT NULL,
  `DOCTOR_NAME` varchar(150) NOT NULL,
  `DOCTOR_EMAIL` varchar(50) NOT NULL,
  `DOCTOR_SPEC` varchar(50) NOT NULL,
  `DOCTOR_FEES` int(11) NOT NULL,
  `DOCTOR_SPEC_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `DOCTOR`
--

INSERT INTO `DOCTOR` (`DOCTOR_ID`, `DOCTOR_PASSWORD`, `DOCTOR_NAME`, `DOCTOR_EMAIL`, `DOCTOR_SPEC`, `DOCTOR_FEES`, `DOCTOR_SPEC_ID`) VALUES
(2311953, '123456', 'Sumanth', 'venkata@gmail.com', 'General', 450, 1),
(2313042, '123456', 'Suchendra', 'suchendra@gmail.com', 'Gastroenterologist', 200, 5),
(2313313, '123456', 'Dakshika', 'dakshika@gmail.com', 'Gynecologist', 300, 2),
(2313782, '123456', 'Ashwitha', 'ashwitha@gmail.com', 'Neurologist', 500, 6),
(2344937, '123456', 'Vamshi', 'vamshi@gmail.com', 'Cardiologist', 600, 4);

-- --------------------------------------------------------

--
-- Table structure for table `FEEDBACK`
--

CREATE TABLE `FEEDBACK` (
  `FEEDBACK_ID` int(11) NOT NULL,
  `NAME` varchar(250) NOT NULL,
  `EMAIL` varchar(250) NOT NULL,
  `CONTACT` int(11) NOT NULL,
  `MESSAGE` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `INSURANCE_DETAILS`
--

CREATE TABLE `INSURANCE_DETAILS` (
  `INSURANCE_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `COVERAGE_PERCENT` int(11) NOT NULL,
  `INSURANCE_STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `INSURANCE_DETAILS`
--

INSERT INTO `INSURANCE_DETAILS` (`INSURANCE_ID`, `PATIENT_ID`, `COVERAGE_PERCENT`, `INSURANCE_STATUS`) VALUES
(2157906, 38, 40, 1),
(2311347, 39, 70, 1),
(2311953, 40, 75, 0),
(2312126, 37, 60, 1),
(2315011, 41, 50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PATIENT`
--

CREATE TABLE `PATIENT` (
  `PATIENT_ID` int(11) NOT NULL,
  `PATIENT_FIRST_NAME` varchar(50) NOT NULL,
  `PATIENT_LAST_NAME` varchar(50) NOT NULL,
  `PATIENT_GENDER` varchar(10) NOT NULL,
  `PATIENT_EMAIL` varchar(50) NOT NULL,
  `PATIENT_CONTACT` varchar(50) NOT NULL,
  `PATIENT_PASSWORD` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `PATIENT`
--

INSERT INTO `PATIENT` (`PATIENT_ID`, `PATIENT_FIRST_NAME`, `PATIENT_LAST_NAME`, `PATIENT_GENDER`, `PATIENT_EMAIL`, `PATIENT_CONTACT`, `PATIENT_PASSWORD`) VALUES
(37, 'Rishi', 'Yedlapalli', 'Male', 'rishi@gmail.com', '9898989898', '123456'),
(38, 'Spoorthy Shivani', 'Pabba', 'Female', 'spoo@gmail.com', '8787878787', '123456'),
(39, 'Teja', 'Akula', 'Male', 'teja@gmail.com', '7676767676', '123456'),
(40, 'Lekha', 'Chittajallu', 'Female', 'lekha@gmail.com', '6565656565', '123456'),
(41, 'Praveen', 'Gurlinka', 'Male', 'praveen@gmail.com', '5454545454', '123456'),
(42, 'Rishi James', 'Y', 'Male', 'rishij@gmail.com', '8765467876', '123456'),
(43, 'Rishi John', 'Junior', 'Male', 'rishiju@gmail.com', '7654567985', '123456'),
(44, 'Karthik', 'rao', 'Male', 'kartik@gmail.com', '2675312348', '123456'),
(46, 'Madhavan', 'R', 'Male', 'curtis@gmail.com', '1234567899', '123456'),
(47, 'HARISH', 'A', 'Male', 'harish@gmail.com', '9999999999', 'Harish@1');

-- --------------------------------------------------------

--
-- Table structure for table `PRESCRIPTION`
--

CREATE TABLE `PRESCRIPTION` (
  `PRESCRIPTION_ID` int(11) NOT NULL,
  `PATIENT_ID` int(11) NOT NULL,
  `DOCTOR_ID` int(11) NOT NULL,
  `APPOINTMENT_ID` int(11) NOT NULL,
  `DISEASE` varchar(250) DEFAULT NULL,
  `ALLERGY` varchar(250) DEFAULT NULL,
  `PRESCRIPTION` varchar(250) DEFAULT NULL,
  `PRESCRIPTION_AMOUNT` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SPECIALIZATION`
--

CREATE TABLE `SPECIALIZATION` (
  `DOCTOR_SPEC_ID` int(11) NOT NULL,
  `DOCTOR_SPEC` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `SPECIALIZATION`
--

INSERT INTO `SPECIALIZATION` (`DOCTOR_SPEC_ID`, `DOCTOR_SPEC`) VALUES
(1, 'General'),
(2, 'Gynecologist'),
(3, 'Oncologist'),
(4, 'Cardiologist'),
(5, 'Gastroenterologist'),
(6, 'Neurologist'),
(7, 'Pediatrician');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD KEY `fk_admin_specialization` (`DOCTOR_SPEC_ID`);

--
-- Indexes for table `APPOINTMENT`
--
ALTER TABLE `APPOINTMENT`
  ADD PRIMARY KEY (`APPOINTMENT_ID`),
  ADD KEY `fk_appointment_patient` (`PATIENT_ID`),
  ADD KEY `fk_appointment_doctor` (`DOCTOR_ID`),
  ADD KEY `fk_appointment_specialization` (`DOCTOR_SPEC_ID`);

--
-- Indexes for table `BILLING`
--
ALTER TABLE `BILLING`
  ADD PRIMARY KEY (`BILLING_ID`),
  ADD KEY `fk_billing_patient` (`PATIENT_ID`);

--
-- Indexes for table `DOCTOR`
--
ALTER TABLE `DOCTOR`
  ADD PRIMARY KEY (`DOCTOR_ID`),
  ADD KEY `fk_doctor_specialization` (`DOCTOR_SPEC_ID`);

--
-- Indexes for table `FEEDBACK`
--
ALTER TABLE `FEEDBACK`
  ADD PRIMARY KEY (`FEEDBACK_ID`);

--
-- Indexes for table `INSURANCE_DETAILS`
--
ALTER TABLE `INSURANCE_DETAILS`
  ADD PRIMARY KEY (`INSURANCE_ID`),
  ADD KEY `fk_insurance_patient` (`PATIENT_ID`);

--
-- Indexes for table `PATIENT`
--
ALTER TABLE `PATIENT`
  ADD PRIMARY KEY (`PATIENT_ID`);

--
-- Indexes for table `PRESCRIPTION`
--
ALTER TABLE `PRESCRIPTION`
  ADD PRIMARY KEY (`PRESCRIPTION_ID`),
  ADD KEY `fk_prescription_patient` (`PATIENT_ID`),
  ADD KEY `fk_prescription_doctor` (`DOCTOR_ID`),
  ADD KEY `fk_prescription_appointment` (`APPOINTMENT_ID`);

--
-- Indexes for table `SPECIALIZATION`
--
ALTER TABLE `SPECIALIZATION`
  ADD PRIMARY KEY (`DOCTOR_SPEC_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `APPOINTMENT`
--
ALTER TABLE `APPOINTMENT`
  MODIFY `APPOINTMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `BILLING`
--
ALTER TABLE `BILLING`
  MODIFY `BILLING_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `FEEDBACK`
--
ALTER TABLE `FEEDBACK`
  MODIFY `FEEDBACK_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `PATIENT`
--
ALTER TABLE `PATIENT`
  MODIFY `PATIENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `PRESCRIPTION`
--
ALTER TABLE `PRESCRIPTION`
  MODIFY `PRESCRIPTION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ADMIN`
--
ALTER TABLE `ADMIN`
  ADD CONSTRAINT `fk_admin_specialization` FOREIGN KEY (`DOCTOR_SPEC_ID`) REFERENCES `SPECIALIZATION` (`DOCTOR_SPEC_ID`);

--
-- Constraints for table `APPOINTMENT`
--
ALTER TABLE `APPOINTMENT`
  ADD CONSTRAINT `fk_appointment_doctor` FOREIGN KEY (`DOCTOR_ID`) REFERENCES `DOCTOR` (`DOCTOR_ID`),
  ADD CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`PATIENT_ID`) REFERENCES `PATIENT` (`PATIENT_ID`),
  ADD CONSTRAINT `fk_appointment_specialization` FOREIGN KEY (`DOCTOR_SPEC_ID`) REFERENCES `SPECIALIZATION` (`DOCTOR_SPEC_ID`);

--
-- Constraints for table `BILLING`
--
ALTER TABLE `BILLING`
  ADD CONSTRAINT `fk_billing_patient` FOREIGN KEY (`PATIENT_ID`) REFERENCES `PATIENT` (`PATIENT_ID`);

--
-- Constraints for table `DOCTOR`
--
ALTER TABLE `DOCTOR`
  ADD CONSTRAINT `fk_doctor_specialization` FOREIGN KEY (`DOCTOR_SPEC_ID`) REFERENCES `SPECIALIZATION` (`DOCTOR_SPEC_ID`);

--
-- Constraints for table `INSURANCE_DETAILS`
--
ALTER TABLE `INSURANCE_DETAILS`
  ADD CONSTRAINT `fk_insurance_patient` FOREIGN KEY (`PATIENT_ID`) REFERENCES `PATIENT` (`PATIENT_ID`);

--
-- Constraints for table `PRESCRIPTION`
--
ALTER TABLE `PRESCRIPTION`
  ADD CONSTRAINT `fk_prescription_appointment` FOREIGN KEY (`APPOINTMENT_ID`) REFERENCES `APPOINTMENT` (`APPOINTMENT_ID`),
  ADD CONSTRAINT `fk_prescription_doctor` FOREIGN KEY (`DOCTOR_ID`) REFERENCES `DOCTOR` (`DOCTOR_ID`),
  ADD CONSTRAINT `fk_prescription_patient` FOREIGN KEY (`PATIENT_ID`) REFERENCES `PATIENT` (`PATIENT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
