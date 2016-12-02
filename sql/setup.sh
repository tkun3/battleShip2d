#!/bin/bash

# Add verbosity
set -x

# Login to MYSQL and run script
dbName="battleships"
mysql --user="user" --password="password" --database="$dbName" --execute="DROP DATABASE $dbName; CREATE DATABASE $dbName;"
mysql --user="user" --password="password" --database="$dbName" < setup.sql
