#!/bin/bash

# Add verbosity
set -x

# Login to MYSQL and run script
dbName="battleships"
/usr/local/mysql/bin/mysql --user="root" --password="ceng356\$\$!" --database="$dbName" --execute="DROP DATABASE $dbName; CREATE DATABASE $dbName;"
/usr/local/mysql/bin/mysql --user="root" --password="ceng356\$\$!" --database="$dbName" < setup.sql
