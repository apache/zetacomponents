#! /bin/sh
mysql -u test test < schema_mysql.sql
php create_schema.php
