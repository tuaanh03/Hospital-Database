-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 02:44 PM
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
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `cure`
--

CREATE TABLE `cure` (
  `TreatCode` varchar(50) NOT NULL,
  `DECode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cure`
--

INSERT INTO `cure` (`TreatCode`, `DECode`) VALUES
('T000000001', 'D123'),
('T000000001', 'D345'),
('T000000002', 'D234'),
('T000000002', 'D567');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DCode` varchar(50) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `DECode` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DCode`, `Title`, `DECode`) VALUES
('1', 'Cardiology', 'D123'),
('2', 'Ophthalmology', 'D234'),
('3', 'Pharmacy', 'D345');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `IMCode` varchar(50) NOT NULL,
  `MCode` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `PriceImport` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `ECode` varchar(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `StartDate` date NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL,
  `DoB` date NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Year` int(11) NOT NULL,
  `DCode` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`ECode`, `Gender`, `Address`, `StartDate`, `Fname`, `Lname`, `DoB`, `Phone`, `Name`, `Year`, `DCode`, `password`) VALUES
('D123', 'Male', '102/6 Hoa Hung', '2024-11-01', 'Tran', 'Hiep', '2024-11-01', '0909930828', 'ORB', 3, '1', 'adcd7048512e64b48da55b027577886ee5a36350'),
('D234', 'Female', '123 An Duong Vuong', '2024-11-22', 'Nguyen', 'Anh', '2024-11-23', '0909930828', 'HHH', 2, '2', 'adcd7048512e64b48da55b027577886ee5a36350'),
('D345', 'Male', '102/6 Hoa Hung', '2024-11-01', 'Trinh', 'Dien', '2024-11-01', '0909930828', 'ORB', 3, '3', 'adcd7048512e64b48da55b027577886ee5a36350'),
('D456', 'Male', '102/6 Hoa Hung', '2024-11-01', 'Ngo', 'Vinh', '2024-11-01', '0909930828', 'ORB', 3, '1', 'adcd7048512e64b48da55b027577886ee5a36350'),
('D567', 'Male', '102/6 Hoa Hung', '2024-11-01', 'Le', 'Phat', '2024-11-01', '1111111111111', 'ORB', 3, '2', 'adcd7048512e64b48da55b027577886ee5a36350');

-- --------------------------------------------------------

--
-- Table structure for table `examination`
--

CREATE TABLE `examination` (
  `ExamCode` varchar(50) NOT NULL,
  `Diagnosis` varchar(50) NOT NULL,
  `ExamDate` datetime NOT NULL,
  `NextExDate` date NOT NULL,
  `Fee` varchar(50) NOT NULL,
  `DECode` varchar(50) NOT NULL,
  `OPCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examination`
--

INSERT INTO `examination` (`ExamCode`, `Diagnosis`, `ExamDate`, `NextExDate`, `Fee`, `DECode`, `OPCode`) VALUES
('EX000000001', 'Headache', '2024-11-23 09:14:03', '2024-11-26', '310', 'D123', 'OP000000001'),
('EX000000002', 'Toothache', '2024-11-23 09:15:10', '2024-11-27', '280', 'D123', 'OP000000002'),
('EX000000003', '231', '2024-11-27 15:17:26', '0000-00-00', '130', 'D123', 'OP000000003'),
('EX000000004', 'sick', '2024-11-27 20:43:35', '0000-00-00', '110', 'D123', 'OP000000001');

-- --------------------------------------------------------

--
-- Table structure for table `exam_use`
--

CREATE TABLE `exam_use` (
  `ExamCode` varchar(50) NOT NULL,
  `MCode` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_use`
--

INSERT INTO `exam_use` (`ExamCode`, `MCode`, `quantity`, `price`) VALUES
('EX000000001', 'MED1', 6, 10),
('EX000000001', 'MED2', 6, 20),
('EX000000001', 'MED3', 6, 5),
('EX000000002', 'MED1', 5, 10),
('EX000000002', 'MED2', 5, 20),
('EX000000002', 'MED4', 5, 6),
('EX000000003', 'MED1', 2, 10),
('EX000000003', 'MED3', 2, 5),
('EX000000004', 'MED1', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `imported_medication`
--

CREATE TABLE `imported_medication` (
  `IMCode` varchar(50) NOT NULL,
  `ImportedDate` date NOT NULL,
  `Pnumber` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inpatient`
--

CREATE TABLE `inpatient` (
  `IPCode` varchar(50) NOT NULL,
  `PCode` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inpatient`
--

INSERT INTO `inpatient` (`IPCode`, `PCode`) VALUES
('IP000000001', 9),
('IP000000002', 11);

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

CREATE TABLE `medication` (
  `MCode` varchar(50) NOT NULL,
  `Price` int(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `ExpirationDate` date NOT NULL,
  `Effect` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication`
--

INSERT INTO `medication` (`MCode`, `Price`, `Name`, `ExpirationDate`, `Effect`) VALUES
('MED1', 10, 'ABC', '2024-11-22', 'pain relief'),
('MED2', 20, 'DEF', '2024-11-30', 'cough relief'),
('MED3', 5, 'GIH', '2024-11-22', 'pain relief'),
('MED4', 6, 'JKL', '2024-11-30', 'antibiotic');

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `ECode` varchar(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `StartDate` date NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL,
  `DoB` date NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Year` int(11) NOT NULL,
  `DCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse`
--

INSERT INTO `nurse` (`ECode`, `Gender`, `Address`, `StartDate`, `Fname`, `Lname`, `DoB`, `Phone`, `Name`, `Year`, `DCode`) VALUES
('N0001', 'Female', '123 Thanh Thai', '2024-11-06', 'Nguyen', 'A', '2024-11-01', '0909930828', 'OOOO', 3, '2');

-- --------------------------------------------------------

--
-- Table structure for table `outpatient`
--

CREATE TABLE `outpatient` (
  `OPCode` varchar(50) NOT NULL,
  `PCode` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outpatient`
--

INSERT INTO `outpatient` (`OPCode`, `PCode`) VALUES
('OP000000001', 8),
('OP000000002', 10),
('OP000000003', 11);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `PCode` int(50) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `DoB` date NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Fname` varchar(50) NOT NULL,
  `Lname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`PCode`, `Gender`, `DoB`, `Address`, `Phone`, `Fname`, `Lname`) VALUES
(8, 'Male', '2004-01-11', '115 An Duong Vuong', '0000000000', 'Tran', 'Dien'),
(9, 'Male', '2004-02-22', '123 Cong Hoa', '11111111111', 'Ngo', 'Anh'),
(10, 'Male', '2004-09-04', '102/6 Hoa Hung', '0909930828', 'Nguyen', 'Vinh'),
(11, 'Male', '2004-03-31', '333 Truong Chinh', '5555555555', 'Hiep', 'Le'),
(12, 'Male', '2004-12-12', '999 Ly Tu Trong', '8888888888', 'Trinh', 'Phat');

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE `provider` (
  `Pnumber` varchar(50) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ImportedDate` date NOT NULL,
  `Price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `TreatCode` varchar(50) NOT NULL,
  `Diagnosis` varchar(50) NOT NULL,
  `DateDischarge` date DEFAULT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date DEFAULT NULL,
  `Result` varchar(50) DEFAULT NULL,
  `SickRoom` varchar(50) NOT NULL,
  `Fee` varchar(50) NOT NULL,
  `DateAdmission` datetime NOT NULL,
  `IPCode` varchar(50) NOT NULL,
  `DECode` varchar(50) DEFAULT NULL,
  `NECode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`TreatCode`, `Diagnosis`, `DateDischarge`, `StartDate`, `EndDate`, `Result`, `SickRoom`, `Fee`, `DateAdmission`, `IPCode`, `DECode`, `NECode`) VALUES
('T000000001', 'Broken arm', '2024-11-29', '2024-11-24', '2024-11-27', 'Recovered', 'R115', '548', '2024-11-23 09:17:12', 'IP000000001', 'D123', 'N0001'),
('T000000002', 'Burn', '2024-11-26', '2024-11-23', '2024-11-23', 'Have not recovered', 'R188', '640', '2024-11-23 09:18:49', 'IP000000002', 'D567', 'N0001');

-- --------------------------------------------------------

--
-- Table structure for table `treat_use`
--

CREATE TABLE `treat_use` (
  `TreatCode` varchar(50) NOT NULL,
  `MCode` varchar(50) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treat_use`
--

INSERT INTO `treat_use` (`TreatCode`, `MCode`, `quantity`, `price`) VALUES
('T000000001', 'MED1', 3, 10),
('T000000001', 'MED4', 3, 6),
('T000000002', 'MED1', 4, 10),
('T000000002', 'MED2', 4, 20),
('T000000002', 'MED3', 4, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cure`
--
ALTER TABLE `cure`
  ADD PRIMARY KEY (`TreatCode`,`DECode`),
  ADD KEY `TreatCode` (`TreatCode`),
  ADD KEY `DECode` (`DECode`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DCode`),
  ADD KEY `DECode` (`DECode`);

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`IMCode`,`MCode`),
  ADD UNIQUE KEY `IMCode` (`IMCode`,`MCode`),
  ADD KEY `MCode` (`MCode`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`ECode`),
  ADD KEY `DCode` (`DCode`),
  ADD KEY `DCode_2` (`DCode`);

--
-- Indexes for table `examination`
--
ALTER TABLE `examination`
  ADD PRIMARY KEY (`ExamCode`),
  ADD KEY `DECode` (`DECode`),
  ADD KEY `OPCode` (`OPCode`);

--
-- Indexes for table `exam_use`
--
ALTER TABLE `exam_use`
  ADD PRIMARY KEY (`ExamCode`,`MCode`),
  ADD KEY `ExamCode` (`ExamCode`),
  ADD KEY `MCode` (`MCode`);

--
-- Indexes for table `imported_medication`
--
ALTER TABLE `imported_medication`
  ADD PRIMARY KEY (`IMCode`),
  ADD KEY `Pnumber` (`Pnumber`);

--
-- Indexes for table `inpatient`
--
ALTER TABLE `inpatient`
  ADD PRIMARY KEY (`IPCode`),
  ADD KEY `PCode` (`PCode`);

--
-- Indexes for table `medication`
--
ALTER TABLE `medication`
  ADD PRIMARY KEY (`MCode`);

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD PRIMARY KEY (`ECode`),
  ADD KEY `DCode` (`DCode`);

--
-- Indexes for table `outpatient`
--
ALTER TABLE `outpatient`
  ADD PRIMARY KEY (`OPCode`),
  ADD KEY `PCode` (`PCode`),
  ADD KEY `PCode_2` (`PCode`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`PCode`),
  ADD KEY `Phone` (`Phone`),
  ADD KEY `Fname` (`Fname`),
  ADD KEY `Lname` (`Lname`);

--
-- Indexes for table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`Pnumber`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`TreatCode`),
  ADD KEY `IPCode` (`IPCode`),
  ADD KEY `NECode` (`NECode`),
  ADD KEY `DECode` (`DECode`);

--
-- Indexes for table `treat_use`
--
ALTER TABLE `treat_use`
  ADD PRIMARY KEY (`TreatCode`,`MCode`),
  ADD KEY `TreatCode` (`TreatCode`),
  ADD KEY `MCode` (`MCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `PCode` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cure`
--
ALTER TABLE `cure`
  ADD CONSTRAINT `cure_ibfk_1` FOREIGN KEY (`TreatCode`) REFERENCES `treatment` (`TreatCode`),
  ADD CONSTRAINT `cure_ibfk_2` FOREIGN KEY (`DECode`) REFERENCES `doctor` (`ECode`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`DECode`) REFERENCES `doctor` (`ECode`);

--
-- Constraints for table `details`
--
ALTER TABLE `details`
  ADD CONSTRAINT `details_ibfk_1` FOREIGN KEY (`IMCode`) REFERENCES `imported_medication` (`IMCode`),
  ADD CONSTRAINT `details_ibfk_2` FOREIGN KEY (`MCode`) REFERENCES `medication` (`MCode`);

--
-- Constraints for table `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`DCode`) REFERENCES `department` (`DCode`);

--
-- Constraints for table `examination`
--
ALTER TABLE `examination`
  ADD CONSTRAINT `examination_ibfk_1` FOREIGN KEY (`DECode`) REFERENCES `doctor` (`ECode`),
  ADD CONSTRAINT `examination_ibfk_2` FOREIGN KEY (`OPCode`) REFERENCES `outpatient` (`OPCode`);

--
-- Constraints for table `exam_use`
--
ALTER TABLE `exam_use`
  ADD CONSTRAINT `exam_use_ibfk_1` FOREIGN KEY (`MCode`) REFERENCES `medication` (`MCode`),
  ADD CONSTRAINT `exam_use_ibfk_2` FOREIGN KEY (`ExamCode`) REFERENCES `examination` (`ExamCode`);

--
-- Constraints for table `imported_medication`
--
ALTER TABLE `imported_medication`
  ADD CONSTRAINT `imported_medication_ibfk_1` FOREIGN KEY (`Pnumber`) REFERENCES `provider` (`Pnumber`);

--
-- Constraints for table `inpatient`
--
ALTER TABLE `inpatient`
  ADD CONSTRAINT `inpatient_ibfk_1` FOREIGN KEY (`PCode`) REFERENCES `patient` (`PCode`);

--
-- Constraints for table `nurse`
--
ALTER TABLE `nurse`
  ADD CONSTRAINT `nurse_ibfk_1` FOREIGN KEY (`DCode`) REFERENCES `department` (`DCode`);

--
-- Constraints for table `outpatient`
--
ALTER TABLE `outpatient`
  ADD CONSTRAINT `outpatient_ibfk_1` FOREIGN KEY (`PCode`) REFERENCES `patient` (`PCode`);

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`IPCode`) REFERENCES `inpatient` (`IPCode`),
  ADD CONSTRAINT `treatment_ibfk_2` FOREIGN KEY (`DECode`) REFERENCES `doctor` (`ECode`),
  ADD CONSTRAINT `treatment_ibfk_3` FOREIGN KEY (`NECode`) REFERENCES `nurse` (`ECode`);

--
-- Constraints for table `treat_use`
--
ALTER TABLE `treat_use`
  ADD CONSTRAINT `treat_use_ibfk_1` FOREIGN KEY (`TreatCode`) REFERENCES `treatment` (`TreatCode`),
  ADD CONSTRAINT `treat_use_ibfk_2` FOREIGN KEY (`MCode`) REFERENCES `medication` (`MCode`);

create user 'dean'@'localhost'
identified by 'mypassword';
create user 'doctor'@'localhost'
identified by 'mypassword';

grant select, insert, update, delete
on hospital.*
to 'dean'@'localhost';
grant select , insert
on hospital.patient
to 'doctor'@'localhost';

grant select 
on hospital.*
to 'doctor'@'localhost';




COMMIT; 

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
