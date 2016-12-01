
<?php
$serverName = "192.168.1.121";
$dbConnection = new db(serverName, "root", "password", "battleShip");

//start DB connection
$dbConnection->start();

function sendShipLocations($player_name, $array_of_ships) {

         //add player to 'players' table
         $sqlString1 = "INSERT INTO players (name) VALUES ({$player_name});"
         
         $sqlString2 = "select pid from players where name = '{$player_name}'";
         $sqlResult2 = dbConnection->performQuery($sqlString2);

         //         $player_id = $sqlResult2->pid;
         var_dump($sqlResult2->fetch_all());

         //split string into array
         foreach ($array_of_ships as $location) {
                 $sqlString3 = "INSERT INTO shipLocations ";
                 $sqlString3 += "(gridLocation, pid) ";
                 $sqlString3 += "VALUES ('$location', '$player_id')";

                 dbConnection->performQuery($sqlString3);
         }
}

/** Adds player to the database
*   Returns the pid of the player
*/
function addPlayer($player_name) {
         $sqlQuery = "INSERT INTO players VALUES ('$player_name')";
         $dbConnection->performQuery($sqlQuery);
         
}

/** Gets players PID from the database
*   Doesnt deal with duplicate names
*   TODO: get single vcalue from array
*/
function getPid($player_name) {
         $sqlQuery = "SELECT pid from players where name='$player_name'";
         $arr = $dbConnection->performQuery($$sqlQuery)->fetch_array();
         var_dump($arr);
         return $arr;
}

?>