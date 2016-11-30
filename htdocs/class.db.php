<?php
/**
* File:         class.db.php
* Author:       Anuraag Sinha, Takuma Pimlott
* Created:      30/11/16
**/

class db {

      //DB connection Member variables
      var $serverName;
      var $userName;
      var $password;
      var $dbName;

      //DB Connection
      $conn;
      $isConnected      = False;
      
      function __construct($ServerName, $UserName, $Password, $DbName) {
               $this->serverName = $UserName;
               $this->userName = $UserName;
               $this->password = $Password;
               $this->dbName; = $DbName;
      }      
      
      function start() {
               $conn = new mysqli($servername, $username, $password, $dbname);

               if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
               }               
               
               $isConnected = True;  
      }

      function performQuery($sqlQuery) {
               if(!isConnected) {
                        return;
               }

               return $conn->query($sqlQuery);
      }

} // End of db class
?>