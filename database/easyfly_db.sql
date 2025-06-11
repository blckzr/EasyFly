-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 04:38 AM
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
-- Database: `easyfly_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booker`
--

CREATE TABLE `booker` (
  `PassportNumber` varchar(16) NOT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `Telephone` varchar(13) DEFAULT NULL,
  `Address` varchar(64) DEFAULT NULL,
  `PostalCode` varchar(32) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `Country` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `PassportNumber` varchar(16) NOT NULL,
  `BookingDate` date DEFAULT NULL,
  `ItineraryType` varchar(6) DEFAULT NULL,
  `Class` varchar(15) DEFAULT NULL,
  `DepFlightNumber` char(7) DEFAULT NULL,
  `DepDate` date DEFAULT NULL,
  `ArrFlightNumber` char(7) DEFAULT NULL,
  `ArrDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flight_history`
--

CREATE TABLE `flight_history` (
  `FlightNumber` char(11) NOT NULL,
  `FlightDate` date NOT NULL,
  `FlightTime` time DEFAULT NULL,
  `FlightFrom` varchar(64) DEFAULT NULL,
  `FlightTo` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passenger`
--

CREATE TABLE `passenger` (
  `PassportNumber` varchar(16) NOT NULL,
  `PassengerNumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passport`
--

CREATE TABLE `passport` (
  `PassportNumber` varchar(16) NOT NULL,
  `PassportExpiry` date NOT NULL,
  `FirstName` varchar(64) DEFAULT NULL,
  `LastName` varchar(64) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `passport`
--

INSERT INTO `passport` (`PassportNumber`, `PassportExpiry`, `FirstName`, `LastName`, `Birthdate`) VALUES
('PPPP123456789TTT', '2045-03-30', 'Karl Joseph', 'Logdat', '2005-03-30');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Admin_ID` int(11) NOT NULL,
  `First_Name` varchar(25) NOT NULL,
  `Last_Name` varchar(15) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Admin_ID`, `First_Name`, `Last_Name`, `Username`, `Password`) VALUES
(1, 'Admin', 'Admin', 'Admin', 'Admin'),
(3, 'Jan Kevin', 'Gerona', 'JanKevs', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `TicketID` char(4) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `PassengerPassportNumber` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booker`
--
ALTER TABLE `booker`
  ADD PRIMARY KEY (`PassportNumber`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `PassportNumber` (`PassportNumber`),
  ADD KEY `DepFlightNumber` (`DepFlightNumber`,`DepDate`),
  ADD KEY `ArrFlightNumber` (`ArrFlightNumber`,`ArrDate`);

--
-- Indexes for table `flight_history`
--
ALTER TABLE `flight_history`
  ADD PRIMARY KEY (`FlightNumber`,`FlightDate`);

--
-- Indexes for table `passenger`
--
ALTER TABLE `passenger`
  ADD KEY `PassportNumber` (`PassportNumber`);

--
-- Indexes for table `passport`
--
ALTER TABLE `passport`
  ADD PRIMARY KEY (`PassportNumber`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Admin_ID`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`TicketID`),
  ADD KEY `BookingID` (`BookingID`),
  ADD KEY `PassengerPassportNumber` (`PassengerPassportNumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Admin_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booker`
--
ALTER TABLE `booker`
  ADD CONSTRAINT `booker_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`);

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`DepFlightNumber`,`DepDate`) REFERENCES `flight_history` (`FlightNumber`, `FlightDate`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`ArrFlightNumber`,`ArrDate`) REFERENCES `flight_history` (`FlightNumber`, `FlightDate`);

--
-- Constraints for table `passenger`
--
ALTER TABLE `passenger`
  ADD CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `bookings` (`BookingID`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`PassengerPassportNumber`) REFERENCES `passenger` (`PassportNumber`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
