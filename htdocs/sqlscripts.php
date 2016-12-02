<?php
require('class.db.php');
$dbConnection = new db("localhost", "user", "password", "battleships");

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

                 $dbConnection->performQuery($sqlString3);
         }

         //TODO: add error checking of some kind for each transaction
}

/** Adds player to the database
*   Returns the pid of the player
*/
function addPlayer($player_name) {
         $sqlQuery = "INSERT INTO players (name) VALUES ('$player_name')";
         $result = $dbConnection->performQuery($sqlQuery);

         // mysql indexing starts at 1 AFAIK so we cant get a pid of 0, use that as a false flag
         if (!$result) {
            return 0;
         }

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

function checkForOpponents($your_pid) {
         global $dbConnection;

         // default opp_id to 0
         $opp_array = array();

         //opp_id is defaulted to 0, which means no opponent
         // search for someone without an opponent
         $sqlQuery = "SELECT * from players where pid <> $your_pid AND opp_id=0";

         $result_arr = $dbConnection->performQuery($sqlQuery);
         if ($result_arr->num_rows == 0) {
            // There is currently no one waiting for a game
            // Lets wait till someone else queues for a game
            // And adds us

            // This will return 0 (our opp_id value) until an opponent has matched with us
            $loopQuery = "SELECT opp_id from players where pid = $your_pid";

            $opp_pid;
            while (($opp_pid = $dbConnection->performQuery($loopQuery)->fetch_array()['opp_id']) == "0") {
                  // Cant do anything...
            }

            // We matched, find out who the player is
            $selectQuery = "select name from players where pid = $opp_pid";
            $opp_name = $dbConnection->performQuery($selectQuery)->fetch_array()['name'];

            $opp_array['name'] = $opp_name;
            $opp_array['id'] = $opp_pid;
        
         } else {
           // We found at least one person who is waiting for a game

           // only return the first record
           $opp_arr = $result_arr->fetch_array();
           $opp_pid = $opp_arr['pid'];
           $opp_name = $opp_arr['NAME'];

           // update the records of both players and run query;
           $updateQuery = "UPDATE players SET opp_id = $opp_pid WHERE pid = $your_pid;";
           $dbConnection->performQuery($updateQuery);
           $updateQuery = "UPDATE players SET opp_id = $your_pid WHERE pid = $opp_pid;";
           $dbConnection->performQuery($updateQuery);
           
           // Assume successful
           $opp_arr['name'] = $opp_name;
           $opp_arr['id'] = $opp_pid;
         }

         return $opp_array;
}

?>