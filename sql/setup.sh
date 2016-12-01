#!/bin/bash

# Login to MYSQL and run script
dbName="battleShips"
mysql --user="user" --password="password" --database="$dbName" --execute="DROP DATABASE $dbName; CREATE DATABASE $dbName;"
mysql --user="user" --password="password" --database="$dbName" < setup.sql
