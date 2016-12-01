<?php
$serverName = "192.168.1.121";
$dbConnection = new db(serverName, "root", "password", "battleShip");

//start DB connection
$dbConnection->start();

function sendShipLocations($player_name, $array_of_ships) {

         global $dbConnection;         

         $player_id = getPid($player_name);

         //split string into array
         foreach ($array_of_ships as $location) {
                 $sqlString3 = "INSERT INTO shipLocations ";
                 $sqlString3 += "(gridLocation, pid) ";
                 $sqlString3 += "VALUES ('$location', '$player_id')";

                 dbConnection->performQuery($sqlString3);
         }

         //TODO: add error checking of some kind for each transaction
}

/** Adds player to the database
*   Returns the pid of the player
*/
function addPlayer($player_name) {
         $sqlQuery = "INSERT INTO players (name) VALUES ('$player_name')";
         $dbConnection->performQuery($sqlQuery);

         //TODO: dont assume
         // Assume it is successful, return the PID number         
         return getPid($player_name);
}

/** Gets players PID from the database
*   Doesnt deal with duplicate names
*   TODO: get single vcalue from array
*/
function getPid($player_name) {
         global $dbConnetion;

         $sqlQuery = "SELECT pid from players where name='$player_name'";
         $arr = $dbConnection->performQuery($sqlQuery)->fetch_array();
         return $arr['pid'];
}

?>