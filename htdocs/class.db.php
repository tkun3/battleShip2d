<?php
/**
* File:         class.db.php
* Author:       Anuraag Sinha, Takuma Pimlott
* Created:      30/11/16
**/

class db {

      //DB connection Member variables
      public $serverName;
      public $userName;
      public $password;
      public $dbName;

      //DB Connection
      public $conn;
      public $isConnected = False;

      function construct($ServerName, $UserName, $Password, $DbName) {
               $this->serverName = $ServerName;
               $this->userName = $UserName;
               $this->password = $Password;
               $this->dbName = $DbName;
      }

      function start() {
               $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);

               if ($this->conn->connect_error) {
                  die("Connection failed: " . $this->conn->connect_error);
               }

               $isConnected = True;
      }

      function performQuery($sqlQuery) {
               if(!$this->isConnected) {
                        return;
               }

               return $this->conn->query($sqlQuery);
      }

} // End of db class
?>
