-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2013 at 10:19 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `senior_project_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `spw_experience`
--

CREATE TABLE IF NOT EXISTS `spw_experience` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` bigint(20) unsigned NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `company_industry` varchar(100) DEFAULT NULL,
  `start_date` varchar(25) DEFAULT NULL,
  `end_date` varchar(25) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `summary` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `spw_experience_ibfk_1` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_language`
--

CREATE TABLE IF NOT EXISTS `spw_language` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


-- --------------------------------------------------------

--
-- Table structure for table `spw_language_user`
--

CREATE TABLE IF NOT EXISTS `spw_language_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `language` bigint(20) unsigned NOT NULL,
  `user` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `language` (`language`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_mentor_project`
--

CREATE TABLE IF NOT EXISTS `spw_mentor_project` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mentor` bigint(20) unsigned NOT NULL,
  `project` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `mentor` (`mentor`,`project`),
  KEY `project` (`project`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_notification`
--

CREATE TABLE IF NOT EXISTS `spw_notification` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from` bigint(20) unsigned NOT NULL,
  `to_project` bigint(20) unsigned DEFAULT NULL,
  `to_user` bigint(20) unsigned DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `is_read_flag` bit(1) NOT NULL,
  `type` enum('join','leave','join_approved','join_rejected','member_added','professor_approval','professor_approval_approved','professor_approval_rejected','change_project','invite_project','invite_user') NOT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `spw_notification_ibfk_1` (`from`),
  KEY `spw_notification_ibfk_2` (`to_project`),
  KEY `spw_notification_ibfk_3` (`to_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=166 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_project`
--

CREATE TABLE IF NOT EXISTS `spw_project` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(140) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `max_students` int(11) NOT NULL,
  `proposed_by` bigint(20) unsigned NOT NULL,
  `delivery_term` bigint(20) unsigned NOT NULL,
  `status` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `delivery_term` (`delivery_term`),
  KEY `status` (`status`),
  KEY `proposed_by` (`proposed_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


-- --------------------------------------------------------

--
-- Table structure for table `spw_project_status`
--

CREATE TABLE IF NOT EXISTS `spw_project_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


-- --------------------------------------------------------

--
-- Table structure for table `spw_role`
--

CREATE TABLE IF NOT EXISTS `spw_role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_role_user`
--

CREATE TABLE IF NOT EXISTS `spw_role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` bigint(20) unsigned NOT NULL,
  `user` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `role` (`role`,`user`),
  KEY `user` (`user`),
  KEY `user_2` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_skill`
--

CREATE TABLE IF NOT EXISTS `spw_skill` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `website_active` bit(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_skill_project`
--

CREATE TABLE IF NOT EXISTS `spw_skill_project` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `skill` bigint(20) unsigned NOT NULL,
  `project` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `skill` (`skill`,`project`),
  KEY `project` (`project`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_skill_user`
--

CREATE TABLE IF NOT EXISTS `spw_skill_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `skill` bigint(20) unsigned NOT NULL,
  `user` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `skill` (`skill`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_term`
--

CREATE TABLE IF NOT EXISTS `spw_term` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `closed_requests` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `spw_user`
--

CREATE TABLE IF NOT EXISTS `spw_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `picture` varchar(250) DEFAULT NULL,
  `hash_pwd` varchar(250) DEFAULT NULL,
  `summary_spw` varchar(1000) NOT NULL,
  `headline_linkedIn` varchar(100) NOT NULL,
  `summary_linkedIn` varchar(2000) DEFAULT NULL,
  `positions_linkedIn` text NOT NULL,
  `graduation_term` bigint(20) unsigned DEFAULT NULL,
  `project` bigint(20) unsigned DEFAULT NULL,
  `google_id` decimal(30,0) DEFAULT NULL,
  `linkedin_id` varchar(30) DEFAULT NULL,
  `facebook_id` bigint(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `google_id` (`google_id`),
  UNIQUE KEY `linkedin_id` (`linkedin_id`),
  KEY `graduation_term` (`graduation_term`),
  KEY `graduation_term_2` (`graduation_term`),
  KEY `project` (`project`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `spw_experience`
--
ALTER TABLE `spw_experience`
  ADD CONSTRAINT `spw_experience_ibfk_1` FOREIGN KEY (`user`) REFERENCES `spw_user` (`id`);

--
-- Constraints for table `spw_language_user`
--
ALTER TABLE `spw_language_user`
  ADD CONSTRAINT `spw_language_user_ibfk_1` FOREIGN KEY (`language`) REFERENCES `spw_language` (`id`),
  ADD CONSTRAINT `spw_language_user_ibfk_2` FOREIGN KEY (`user`) REFERENCES `spw_user` (`id`);

--
-- Constraints for table `spw_mentor_project`
--
ALTER TABLE `spw_mentor_project`
  ADD CONSTRAINT `spw_mentor_project_ibfk_1` FOREIGN KEY (`mentor`) REFERENCES `spw_user` (`id`),
  ADD CONSTRAINT `spw_mentor_project_ibfk_2` FOREIGN KEY (`project`) REFERENCES `spw_project` (`id`);

--
-- Constraints for table `spw_notification`
--
ALTER TABLE `spw_notification`
  ADD CONSTRAINT `spw_notification_ibfk_1` FOREIGN KEY (`from`) REFERENCES `spw_user` (`id`),
  ADD CONSTRAINT `spw_notification_ibfk_2` FOREIGN KEY (`to_project`) REFERENCES `spw_project` (`id`),
  ADD CONSTRAINT `spw_notification_ibfk_3` FOREIGN KEY (`to_user`) REFERENCES `spw_user` (`id`);

--
-- Constraints for table `spw_project`
--
ALTER TABLE `spw_project`
  ADD CONSTRAINT `spw_project_ibfk_1` FOREIGN KEY (`status`) REFERENCES `spw_project_status` (`id`),
  ADD CONSTRAINT `spw_project_ibfk_2` FOREIGN KEY (`delivery_term`) REFERENCES `spw_term` (`id`),
  ADD CONSTRAINT `spw_project_ibfk_3` FOREIGN KEY (`proposed_by`) REFERENCES `spw_user` (`id`);

--
-- Constraints for table `spw_role_user`
--
ALTER TABLE `spw_role_user`
  ADD CONSTRAINT `spw_role_user_ibfk_1` FOREIGN KEY (`role`) REFERENCES `spw_role` (`id`),
  ADD CONSTRAINT `spw_role_user_ibfk_2` FOREIGN KEY (`user`) REFERENCES `spw_user` (`id`);

--
-- Constraints for table `spw_skill_project`
--
ALTER TABLE `spw_skill_project`
  ADD CONSTRAINT `spw_skill_project_ibfk_1` FOREIGN KEY (`skill`) REFERENCES `spw_skill` (`id`),
  ADD CONSTRAINT `spw_skill_project_ibfk_2` FOREIGN KEY (`project`) REFERENCES `spw_project` (`id`);

--
-- Constraints for table `spw_skill_user`
--
ALTER TABLE `spw_skill_user`
  ADD CONSTRAINT `spw_skill_user_ibfk_1` FOREIGN KEY (`skill`) REFERENCES `spw_skill` (`id`),
  ADD CONSTRAINT `spw_skill_user_ibfk_2` FOREIGN KEY (`user`) REFERENCES `spw_user` (`id`);

--
-- Constraints for table `spw_user`
--
ALTER TABLE `spw_user`
  ADD CONSTRAINT `spw_user_ibfk_1` FOREIGN KEY (`graduation_term`) REFERENCES `spw_term` (`id`),
  ADD CONSTRAINT `spw_user_ibfk_2` FOREIGN KEY (`project`) REFERENCES `spw_project` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
