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
                 $sqlString3 += "(gridLocation, pid)";
                 $sqlString3 += "VALUES ($location, $player_id)";

                 dbConnection->performQuery($sqlString3);
         }
}


?>