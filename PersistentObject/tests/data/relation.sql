-- phpMyAdmin SQL Dump
-- version 2.11.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2007 at 08:12 PM
-- Server version: 5.0.44
-- PHP Version: 5.2.5RC2-dev

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `PO_addresses`
--

CREATE TABLE IF NOT EXISTS `PO_addresses` (
  `city` varchar(100) NOT NULL,
  `id` bigint(20) NOT NULL auto_increment,
  `street` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `zip` varchar(5) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PO_birthdays`
--

CREATE TABLE IF NOT EXISTS `PO_birthdays` (
  `birthday` bigint(20) NOT NULL,
  `person_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PO_employers`
--

CREATE TABLE IF NOT EXISTS `PO_employers` (
  `id` bigint(20) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PO_friends`
--

CREATE TABLE IF NOT EXISTS `PO_friends` (
  `firiend_id` bigint(20) NOT NULL,
  `id` bigint(20) NOT NULL,
  PRIMARY KEY  (`firiend_id`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PO_persons`
--

CREATE TABLE IF NOT EXISTS `PO_persons` (
  `employer` bigint(20) default NULL,
  `firstname` varchar(100) NOT NULL,
  `id` bigint(20) NOT NULL auto_increment,
  `surname` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PO_persons_addresses`
--

CREATE TABLE IF NOT EXISTS `PO_persons_addresses` (
  `address_id` bigint(20) NOT NULL,
  `person_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`address_id`,`person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PO_secondpersons_addresses`
--

CREATE TABLE IF NOT EXISTS `PO_secondpersons_addresses` (
  `address_id` bigint(20) NOT NULL,
  `person_firstname` varchar(100) NOT NULL,
  `person_surname` varchar(100) NOT NULL,
  PRIMARY KEY  (`address_id`,`person_firstname`,`person_surname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
