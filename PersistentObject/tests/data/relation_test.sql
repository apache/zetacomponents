-- phpMyAdmin SQL Dump
-- version 2.6.3-rc1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 16, 2006 at 07:10 PM
-- Server version: 5.0.24
-- PHP Version: 5.1.6-pl6-gentoo
-- 
-- Database: `test`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_addresses`
-- 

CREATE TABLE `PO_addresses` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `street` varchar(100) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `city` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `PO_addresses`
-- 

INSERT INTO `PO_addresses` (`id`, `street`, `zip`, `city`, `type`) VALUES (1, 'Httproad 23', '12345', 'Internettown', 'work');
INSERT INTO `PO_addresses` (`id`, `street`, `zip`, `city`, `type`) VALUES (2, 'Ftpstreet 42', '12345', 'Internettown', 'work');
INSERT INTO `PO_addresses` (`id`, `street`, `zip`, `city`, `type`) VALUES (3, 'Phpavenue 21', '12345', 'Internettown', 'private');
INSERT INTO `PO_addresses` (`id`, `street`, `zip`, `city`, `type`) VALUES (4, 'Pythonstreet 13', '12345', 'Internettown', 'private');

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_birthdays`
-- 

CREATE TABLE `PO_birthdays` (
  `person_id` tinyint(4) NOT NULL,
  `birthday` int(11) NOT NULL,
  PRIMARY KEY  (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `PO_birthdays`
-- 

INSERT INTO `PO_birthdays` (`person_id`, `birthday`) VALUES (1, 327535201);
INSERT INTO `PO_birthdays` (`person_id`, `birthday`) VALUES (2, -138243599);

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_employers`
-- 

CREATE TABLE `PO_employers` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `PO_employers`
-- 

INSERT INTO `PO_employers` (`id`, `name`) VALUES (1, 'Great Web 2.0 company');
INSERT INTO `PO_employers` (`id`, `name`) VALUES (2, 'Oldschool Web 1.x company');

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_persons`
-- 

CREATE TABLE `PO_persons` (
  `id` tinyint(4) NOT NULL auto_increment,
  `firstname` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `employer` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Dumping data for table `PO_persons`
-- 

INSERT INTO `PO_persons` (`id`, `firstname`, `surname`, `employer`) VALUES (1, 'Derick', 'Gopher', 2);
INSERT INTO `PO_persons` (`id`, `firstname`, `surname`, `employer`) VALUES (2, 'Frederick', 'Ajax', 1);
INSERT INTO `PO_persons` (`id`, `firstname`, `surname`, `employer`) VALUES (3, 'Raymond', 'Socialweb', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_persons_addresses`
-- 

CREATE TABLE `PO_persons_addresses` (
  `person_id` tinyint(4) NOT NULL,
  `address_id` tinyint(4) NOT NULL,
  PRIMARY KEY  (`person_id`,`address_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `PO_persons_addresses`
-- 

INSERT INTO `PO_persons_addresses` (`person_id`, `address_id`) VALUES (1, 1);
INSERT INTO `PO_persons_addresses` (`person_id`, `address_id`) VALUES (1, 2);
INSERT INTO `PO_persons_addresses` (`person_id`, `address_id`) VALUES (1, 4);
INSERT INTO `PO_persons_addresses` (`person_id`, `address_id`) VALUES (2, 1);
INSERT INTO `PO_persons_addresses` (`person_id`, `address_id`) VALUES (2, 3);
INSERT INTO `PO_persons_addresses` (`person_id`, `address_id`) VALUES (2, 4);
