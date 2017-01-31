-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 31, 2017 at 08:39 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laboratory_classes`
--
CREATE DATABASE IF NOT EXISTS `laboratory_classes` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `laboratory_classes`;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `idDepartment` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `acronym` varchar(10) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`idDepartment`, `title`, `acronym`, `description`) VALUES
(1, 'Electronics And Telecommunications', 'ET', '...'),
(2, 'New Energy Technologies', 'NET', '...'),
(3, 'Computer Science', 'РТ', '...'),
(4, 'Automation And Control Systems For Vehicles', 'ACSV', '...'),
(5, 'New Computer Technology', 'NCT', '...'),
(6, 'Management Of Electrical Engineering', 'MEE', '...'),
(7, 'Audio And Video Technology', 'AVT', '...'),
(8, 'E-Business', 'ЕB', '...');

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `idExercise` int(11) UNSIGNED NOT NULL,
  `idSubject` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `number` int(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `laboratory`
--

CREATE TABLE `laboratory` (
  `idLaboratory` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `number` int(11) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `laboratory`
--

INSERT INTO `laboratory` (`idLaboratory`, `title`, `number`, `description`) VALUES
(1, 'Laboratory 103', 103, '...'),
(2, 'Laboratory 209', 209, '...'),
(3, 'Laboratory 304', 304, '...'),
(4, 'Laboratory 402', 402, '...'),
(5, 'Laboratory 403', 403, '...'),
(6, 'Laboratory 409', 409, '...'),
(7, 'Laboratory 506', 506, '...');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `idMaterial` int(11) UNSIGNED NOT NULL,
  `idExercise` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `file` text NOT NULL,
  `location` text NOT NULL,
  `extension` varchar(10) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `idSubject` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`idSubject`, `title`, `description`) VALUES
(1, 'Programming Web Applications', '...'),
(2, 'Object-oriented Design', '...');

-- --------------------------------------------------------

--
-- Table structure for table `subject_assistant`
--

CREATE TABLE `subject_assistant` (
  `idUser` int(11) UNSIGNED NOT NULL,
  `idSubject` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_assistant`
--

INSERT INTO `subject_assistant` (`idUser`, `idSubject`) VALUES
(2, 1),
(3, 2),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject_department`
--

CREATE TABLE `subject_department` (
  `idSubject` int(11) UNSIGNED NOT NULL,
  `idDepartment` int(11) UNSIGNED NOT NULL,
  `year` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_department`
--

INSERT INTO `subject_department` (`idSubject`, `idDepartment`, `year`, `semester`) VALUES
(1, 1, NULL, NULL),
(1, 2, NULL, NULL),
(2, 3, NULL, NULL),
(2, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `term`
--

CREATE TABLE `term` (
  `idTerm` int(11) UNSIGNED NOT NULL,
  `idExercise` int(11) UNSIGNED NOT NULL,
  `idLaboratory` int(11) UNSIGNED NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `term_assistant`
--

CREATE TABLE `term_assistant` (
  `idUser` int(11) UNSIGNED NOT NULL,
  `idTerm` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) UNSIGNED NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `idType` int(11) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL,
  `fname` varchar(60) NOT NULL,
  `lname` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `picture` text,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `username`, `password`, `idType`, `status`, `fname`, `lname`, `email`, `picture`, `description`) VALUES
(1, 'nino', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', 1, 1, 'Nino', 'Belov', 'nino.belov@lc.edu.org', NULL, '...'),
(2, 'serbo', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 1, 'Serbo', 'Makeridov', 'serbo.makeridov@lc.edu.org', NULL, '......'),
(3, 'aleksandar', '6b0d31c0d563223024da45691584643ac78c96e8', 2, 1, 'Aleksandar', 'Karanovic', 'aleksandar.karanovic@lc.edu.org', NULL, '...'),
(4, 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 1, 'Admin', 'Admin', 'admin@lc.edu.org', NULL, ''),
(5, 'marko', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 1, 'Marko', 'Kostic', 'marko.kostic@lc.edu.org', NULL, '...');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `idType` int(11) UNSIGNED NOT NULL,
  `type` varchar(30) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`idType`, `type`, `description`) VALUES
(1, 'Администратор', 'Има сва права'),
(2, 'Сарадник', 'Има права уређивања'),
(3, 'Демонстратор', 'Нема права');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`idDepartment`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`idExercise`),
  ADD KEY `idSubject_idx` (`idSubject`);

--
-- Indexes for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD PRIMARY KEY (`idLaboratory`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`idMaterial`),
  ADD KEY `idMaterial_idx` (`idMaterial`),
  ADD KEY `idExercise_idx` (`idExercise`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`idSubject`);

--
-- Indexes for table `subject_assistant`
--
ALTER TABLE `subject_assistant`
  ADD PRIMARY KEY (`idUser`,`idSubject`),
  ADD KEY `idSubject_idx` (`idSubject`),
  ADD KEY `idUser_idx` (`idUser`);

--
-- Indexes for table `subject_department`
--
ALTER TABLE `subject_department`
  ADD PRIMARY KEY (`idSubject`,`idDepartment`),
  ADD KEY `idSubject_idx` (`idSubject`),
  ADD KEY `idDepartment_idx` (`idDepartment`);

--
-- Indexes for table `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`idTerm`),
  ADD KEY `idExercise_idx` (`idExercise`),
  ADD KEY `idLaboratory_idx` (`idLaboratory`);

--
-- Indexes for table `term_assistant`
--
ALTER TABLE `term_assistant`
  ADD PRIMARY KEY (`idUser`,`idTerm`),
  ADD KEY `idUser_idx` (`idUser`),
  ADD KEY `idTerm_idx` (`idTerm`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD KEY `idType_idx` (`idType`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`idType`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `idDepartment` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `idExercise` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `laboratory`
--
ALTER TABLE `laboratory`
  MODIFY `idLaboratory` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `idMaterial` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `idSubject` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `term`
--
ALTER TABLE `term`
  MODIFY `idTerm` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `idType` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `exercise`
--
ALTER TABLE `exercise`
  ADD CONSTRAINT `SubjectExercise` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `idExercise` FOREIGN KEY (`idExercise`) REFERENCES `exercise` (`idExercise`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_assistant`
--
ALTER TABLE `subject_assistant`
  ADD CONSTRAINT `SubjectUser` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserSubject` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_department`
--
ALTER TABLE `subject_department`
  ADD CONSTRAINT `DepartmentSubject` FOREIGN KEY (`idDepartment`) REFERENCES `department` (`idDepartment`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SubjectDepartment` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `term`
--
ALTER TABLE `term`
  ADD CONSTRAINT `ExerciseTerm` FOREIGN KEY (`idExercise`) REFERENCES `exercise` (`idExercise`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LaboratoryTerm` FOREIGN KEY (`idLaboratory`) REFERENCES `laboratory` (`idLaboratory`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `term_assistant`
--
ALTER TABLE `term_assistant`
  ADD CONSTRAINT `TermAssistant` FOREIGN KEY (`idTerm`) REFERENCES `term` (`idTerm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `UserAssistant` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `TypeUser` FOREIGN KEY (`idType`) REFERENCES `user_type` (`idType`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
