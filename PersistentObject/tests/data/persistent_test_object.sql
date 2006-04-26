-- 
-- Table structure for table `PO_test`
-- 

CREATE TABLE PO_test (
  id bigint(20) NOT NULL,
  type_decimal double default NULL,
  type_integer bigint(20) default NULL,
  type_text varchar(255) default NULL,
  type_varchar varchar(20) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;
