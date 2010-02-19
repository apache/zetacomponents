DROP TABLE "table1";
CREATE TABLE "table1" (
	"id" number NOT NULL
);
CREATE SEQUENCE "table1_id_seq" start with 1 increment by 1 nomaxvalue;
CREATE OR REPLACE TRIGGER "table1_id_trg" before insert on "table1" for each row begin select "table1_id_seq".nextval into :new."id" from dual; end;;
ALTER TABLE "table1" ADD CONSTRAINT "table1_pkey" PRIMARY KEY ( "id" );
DROP TABLE "table2";
CREATE TABLE "table2" (
	"id" number DEFAULT 0 NOT NULL
);
ALTER TABLE "table2" ADD CONSTRAINT "table2_pkey" PRIMARY KEY ( "id" );
