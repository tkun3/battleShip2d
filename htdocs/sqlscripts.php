<?php
require_once('class.db.php');
$dbConnection = new db("localhost", "root", "ceng356$$!", "battleships");


//start DB connection
$dbConnection->start();

function sendShipLocations($pid, $array_of_ships) {
         global $dbConnection;

         //split string into array
         foreach ($array_of_ships as $location) {

                 $sqlString = "INSERT INTO ship_locations (location, pid) ";
                 $sqlString .= "VALUES ('$location', '$pid')";

                 // Add this point
                 $dbConnection->performQuery($sqlString);
         }

         //TODO: add error checking of some kind for each transaction
}

function hitLocation($otherplayer_pid) {
         global $dbConnection;

         //Get the largest guess_id for a player (who just made a move)
         $lastHitQuery = "SELECT MAX(guess_id) as guess_id from player_guesses where pid = $otherplayer_pid" ;
         $guess_id = $dbConnection->performQuery($lastHitQuery)->fetch_array()['guess_id'];

         if($guess_id == null){
           return null;
         }


         // Now find that corresponding location
         $lastHitQuery = "select location from player_guesses where guess_id = $guess_id";

         return $dbConnection->performQuery($lastHitQuery)->fetch_array()['location'];

         // TODO: Join queries into one query with sub-queries
}

/** Adds a player guess to the player_guesses table
*   Does not check for range or even string form
*   Use at your own risk
*/
function makeGuess($pid, $opp_pid, $location) {
         global $dbConnection;

         $guessQuery = "INSERT INTO player_guesses (pid, opp_id, location) ";
         $guessQuery .= "VALUES ($pid, $opp_pid, '$location')";
         $dbConnection->performQuery($guessQuery);
}

/** Adds player to the database
*   Returns the pid of the player
*/
function addPlayer($player_name) {
         global $dbConnection;

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
         global $dbConnection;

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
         //var_dump($result_arr);
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
           $opp_array['name'] = $opp_name;
           $opp_array['id'] = $opp_pid;
         }

         return $opp_array;
}

function deletePlayer($pid) {
         global $dbConnnection;

         $deleteQuery = "delete from players where pid = $pid";
         $dbConnection->performQuery($deleteQuery);
}
?>
