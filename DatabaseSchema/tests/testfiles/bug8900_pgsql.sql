DROP TABLE "table1";
CREATE TABLE "table1" (
	"id" serial PRIMARY KEY NOT NULL
);
DROP TABLE "table2";
CREATE TABLE "table2" (
	"id" bigint NOT NULL DEFAULT 0
);
ALTER TABLE "table2" ADD CONSTRAINT "table2_pkey" PRIMARY KEY ( "id" );
