--
-- Table structure for table `PO_person`
--

CREATE TABLE `PO_person` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `mother` int(11),
  `father` int(11),
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `PO_sibling`
--

CREATE TABLE `PO_sibling` (
  `person` int(11) NOT NULL,
  `sibling` int(11) NOT NULL,
  PRIMARY KEY  (`person`,`sibling`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
