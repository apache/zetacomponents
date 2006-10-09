-- phpMyAdmin SQL Dump
-- version 2.6.3-rc1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 29, 2006 at 07:21 PM
-- Server version: 5.0.24
-- PHP Version: 5.1.6-pl4-gentoo
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Dumping data for table `PO_addresses`
-- 

INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Httproad 23', '12345', 'Internettown', 'work');
INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Ftpstreet 42', '12345', 'Internettown', 'work');
INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Phpavenue 21', '12345', 'Internettown', 'private');
INSERT INTO `PO_addresses` (`street`, `zip`, `city`, `type`) VALUES ('Pythonstreet 13', '12345', 'Internettown', 'private');

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_employers`
-- 

CREATE TABLE `PO_employers` (
  `id` tinyint(4) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- 
-- Dumping data for table `PO_employers`
-- 

INSERT INTO `PO_employers` (`name`) VALUES ('Great Web 2.0 company');
INSERT INTO `PO_employers` (`name`) VALUES ('Oldschool Web 1.x company');

-- --------------------------------------------------------

-- 
-- Table structure for table `PO_persons`
-- 

CREATE TABLE `PO_persons` (
  `id` tinyint(4) NOT NULL auto_increment,
  `firstname` varchar(100) NOT NULL,
  `surename` varchar(100) NOT NULL,
  `employer` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

-- 
-- Dumping data for table `PO_persons`
-- 

INSERT INTO `PO_persons` (`firstname`, `surename`, `employer`) VALUES ('Derick', 'Gopher', 2);
INSERT INTO `PO_persons` (`firstname`, `surename`, `employer`) VALUES ('Frederick', 'Ajax', 1);
INSERT INTO `PO_persons` (`firstname`, `surename`, `employer`) VALUES ('Raymond', 'Socialweb', 1);

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
