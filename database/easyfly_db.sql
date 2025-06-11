CREATE DATABASE IF NOT EXISTS `easyfly_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `easyfly_db`;

-- Table structure for table `passport`
DROP TABLE IF EXISTS `passport`;
CREATE TABLE `passport` (
  `PassportNumber` varchar(16) NOT NULL,
  `PassportExpiry` date NOT NULL,
  `FirstName` varchar(64) DEFAULT NULL,
  `LastName` varchar(64) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  PRIMARY KEY (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `passport`
INSERT INTO `passport` VALUES ('PPPP123456789TTT','2045-03-30','Karl Joseph','Logdat','2005-03-30');

-- Table structure for table `booker`
DROP TABLE IF EXISTS `booker`;
CREATE TABLE `booker` (
  `PassportNumber` varchar(16) NOT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `Telephone` varchar(13) DEFAULT NULL,
  `Address` varchar(64) DEFAULT NULL,
  `PostalCode` varchar(32) DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  `Country` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`PassportNumber`),
  CONSTRAINT `booker_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `flight_history`
DROP TABLE IF EXISTS `flight_history`;
CREATE TABLE `flight_history` (
  `FlightNumber` char(11) NOT NULL,
  `FlightDate` date NOT NULL,
  `FlightTime` time DEFAULT NULL,
  `FlightFrom` varchar(64) DEFAULT NULL,
  `FlightTo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`FlightNumber`, `FlightDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `bookings`
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `BookingID` int NOT NULL,
  `PassportNumber` varchar(16) NOT NULL,
  `BookingDate` date DEFAULT NULL,
  `ItineraryType` varchar(6) DEFAULT NULL,
  `Class` varchar(15) DEFAULT NULL,
  `DepFlightNumber` char(11) DEFAULT NULL,
  `DepDate` date DEFAULT NULL,
  `ArrFlightNumber` char(11) DEFAULT NULL,
  `ArrDate` date DEFAULT NULL,
  PRIMARY KEY (`BookingID`),
  KEY `PassportNumber` (`PassportNumber`),
  KEY `DepFlightNumber` (`DepFlightNumber`, `DepDate`),
  KEY `ArrFlightNumber` (`ArrFlightNumber`, `ArrDate`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`DepFlightNumber`, `DepDate`) REFERENCES `flight_history` (`FlightNumber`, `FlightDate`),
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`ArrFlightNumber`, `ArrDate`) REFERENCES `flight_history` (`FlightNumber`, `FlightDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `passenger`
DROP TABLE IF EXISTS `passenger`;
CREATE TABLE `passenger` (
  `PassportNumber` varchar(16) NOT NULL,
  `PassengerNumber` int NOT NULL,
  KEY `PassportNumber` (`PassportNumber`),
  CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table structure for table `ticket`
DROP TABLE IF EXISTS `ticket`;
CREATE TABLE `ticket` (
  `TicketID` char(4) NOT NULL,
  `BookingID` int NOT NULL,
  `PassengerPassportNumber` varchar(16) NOT NULL,
  PRIMARY KEY (`TicketID`),
  KEY `BookingID` (`BookingID`),
  KEY `PassengerPassportNumber` (`PassengerPassportNumber`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `bookings` (`BookingID`),
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`PassengerPassportNumber`) REFERENCES `passenger` (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
