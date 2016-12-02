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

      function __construct($ServerName, $UserName, $Password, $DbName) {
               $this->serverName = $ServerName;
               $this->userName = $UserName;
               $this->password = $Password;
               $this->dbName = $DbName;
      }
      
      function __destruct() {
               if ($this->isConnected) {
                  $this->close();
               }
               
      }

      function start() {
               $this->conn = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);

               if ($this->conn->connect_error) {
                  die("Connection failed: " . $this->conn->connect_error);
               }

               $this->isConnected = True;

               //turn on autocommitting
               $this->conn->autocommit(True);
      }
      
      function close() {
               $this->conn->close();
               $this->isConnected = False;
      }

      function performQuery($sqlQuery) {
               if(!$this->isConnected) {
                        return;
               }

               return $this->conn->query($sqlQuery);
      }

} // End of db class
?>
