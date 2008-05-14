DROP TABLE 'table1';
CREATE TABLE 'table1' (
	'id' integer NOT NULL PRIMARY KEY AUTOINCREMENT
);
DROP TABLE 'table2';
CREATE TABLE 'table2' (
	'id' integer NOT NULL DEFAULT 0
);
CREATE UNIQUE INDEX 'table2_pri' ON 'table2' ( 'id' );
