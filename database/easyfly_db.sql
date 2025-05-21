-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: easyfly_db
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booker`
--

DROP TABLE IF EXISTS `booker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booker`
--

LOCK TABLES `booker` WRITE;
/*!40000 ALTER TABLE `booker` DISABLE KEYS */;
/*!40000 ALTER TABLE `booker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `BookingID` int NOT NULL,
  `PassportNumber` varchar(16) NOT NULL,
  `BookingDate` date DEFAULT NULL,
  `ItineraryType` varchar(6) DEFAULT NULL,
  `Class` varchar(15) DEFAULT NULL,
  `DepFlightNumber` char(7) DEFAULT NULL,
  `DepDate` date DEFAULT NULL,
  `ArrFlightNumber` char(7) DEFAULT NULL,
  `ArrDate` date DEFAULT NULL,
  PRIMARY KEY (`BookingID`),
  KEY `PassportNumber` (`PassportNumber`),
  KEY `DepFlightNumber` (`DepFlightNumber`,`DepDate`),
  KEY `ArrFlightNumber` (`ArrFlightNumber`,`ArrDate`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`DepFlightNumber`, `DepDate`) REFERENCES `flight_history` (`FlightNumber`, `FlightDate`),
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`ArrFlightNumber`, `ArrDate`) REFERENCES `flight_history` (`FlightNumber`, `FlightDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flight_history`
--

DROP TABLE IF EXISTS `flight_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flight_history` (
  `FlightNumber` char(11) NOT NULL,
  `FlightDate` date NOT NULL,
  `FlightTime` time DEFAULT NULL,
  `FlightFrom` varchar(64) DEFAULT NULL,
  `FlightTo` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`FlightNumber`,`FlightDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flight_history`
--

LOCK TABLES `flight_history` WRITE;
/*!40000 ALTER TABLE `flight_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `flight_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passenger`
--

DROP TABLE IF EXISTS `passenger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passenger` (
  `PassportNumber` varchar(16) NOT NULL,
  `PassengerNumber` int NOT NULL,
  KEY `PassportNumber` (`PassportNumber`),
  CONSTRAINT `passenger_ibfk_1` FOREIGN KEY (`PassportNumber`) REFERENCES `passport` (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passenger`
--

LOCK TABLES `passenger` WRITE;
/*!40000 ALTER TABLE `passenger` DISABLE KEYS */;
/*!40000 ALTER TABLE `passenger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passport`
--

DROP TABLE IF EXISTS `passport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `passport` (
  `PassportNumber` varchar(16) NOT NULL,
  `PassportExpiry` date NOT NULL,
  `FirstName` varchar(64) DEFAULT NULL,
  `LastName` varchar(64) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  PRIMARY KEY (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passport`
--

LOCK TABLES `passport` WRITE;
/*!40000 ALTER TABLE `passport` DISABLE KEYS */;
/*!40000 ALTER TABLE `passport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket` (
  `TicketID` char(4) NOT NULL,
  `BookingID` int NOT NULL,
  `PassengerPassportNumber` varchar(16) NOT NULL,
  PRIMARY KEY (`TicketID`),
  KEY `BookingID` (`BookingID`),
  KEY `PassengerPassportNumber` (`PassengerPassportNumber`),
  CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `bookings` (`BookingID`),
  CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`PassengerPassportNumber`) REFERENCES `passenger` (`PassportNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-21 21:35:59
