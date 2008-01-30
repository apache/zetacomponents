-- phpMyAdmin SQL Dump
-- version 2.11.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2008 at 05:12 PM
-- Server version: 5.0.54
-- PHP Version: 5.2.5RC2-dev

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `PO_database_type_test`
--

CREATE TABLE IF NOT EXISTS `PO_database_type_test` (
  `id` int(11) NOT NULL auto_increment,
  `bool` tinyint(1) NOT NULL,
  `int` int(11) NOT NULL,
  `str` varchar(100) NOT NULL,
  `lob` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
