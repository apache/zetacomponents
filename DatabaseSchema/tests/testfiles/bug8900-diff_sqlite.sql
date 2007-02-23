ALTER TABLE 'table1' CHANGE 'id' 'id' integer NOT NULL PRIMARY KEY AUTOINCREMENT;
CREATE UNIQUE INDEX 'table2_pri' ON 'table2' ( 'id' );
