-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 22, 2016 at 01:04 AM
-- Server version: 5.5.42
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sop`
--

-- --------------------------------------------------------

--
-- Table structure for table `ConsumptionElement`
--

CREATE TABLE `ConsumptionElement` (
  `ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `ResourceID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ConsumptionElement`
--

INSERT INTO `ConsumptionElement` (`ID`, `Quantity`, `ProductID`, `ResourceID`) VALUES
(1, 1000, 1, 2),
(2, 1360, 2, 3),
(3, 1360, 3, 1),
(4, 2587, 4, 5),
(5, 1200, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `LoadingPlanRow`
--

CREATE TABLE `LoadingPlanRow` (
  `ID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `_Year` int(11) NOT NULL,
  `_Month` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `LoadingPlanRow`
--

INSERT INTO `LoadingPlanRow` (`ID`, `Quantity`, `_Year`, `_Month`, `ProductID`) VALUES
(1, 1350, 2015, 3, 3),
(2, 1500, 2016, 5, 2),
(3, 2500, 2015, 11, 1),
(4, 1300, 2010, 10, 4),
(5, 1259, 2008, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Production`
--

CREATE TABLE `Production` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Production`
--

INSERT INTO `Production` (`ID`, `Name`) VALUES
(1, 'Lights'),
(2, 'Windshield'),
(3, 'Carcase'),
(4, 'Cloth'),
(5, 'Wheel');

-- --------------------------------------------------------

--
-- Table structure for table `ResourceDictionary`
--

CREATE TABLE `ResourceDictionary` (
  `ID` int(11) NOT NULL,
  `Name` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ResourceDictionary`
--

INSERT INTO `ResourceDictionary` (`ID`, `Name`) VALUES
(1, 'Metal'),
(2, 'Plastic'),
(3, 'Glass'),
(4, 'Gum'),
(5, 'Cloth');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ConsumptionElement`
--
ALTER TABLE `ConsumptionElement`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `ResourceID` (`ResourceID`);

--
-- Indexes for table `LoadingPlanRow`
--
ALTER TABLE `LoadingPlanRow`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `Production`
--
ALTER TABLE `Production`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ResourceDictionary`
--
ALTER TABLE `ResourceDictionary`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ConsumptionElement`
--
ALTER TABLE `ConsumptionElement`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `LoadingPlanRow`
--
ALTER TABLE `LoadingPlanRow`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Production`
--
ALTER TABLE `Production`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ResourceDictionary`
--
ALTER TABLE `ResourceDictionary`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ConsumptionElement`
--
ALTER TABLE `ConsumptionElement`
  ADD CONSTRAINT `consumptionelement_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Production` (`ID`),
  ADD CONSTRAINT `consumptionelement_ibfk_2` FOREIGN KEY (`ResourceID`) REFERENCES `ResourceDictionary` (`ID`);

--
-- Constraints for table `LoadingPlanRow`
--
ALTER TABLE `LoadingPlanRow`
  ADD CONSTRAINT `loadingplanrow_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Production` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
