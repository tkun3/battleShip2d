<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/battleship.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<title>Super Ships 2D</title>
</head>

<body>
		<div class="container" align="center">
			<div class="gameScreen" align="center">
				<div class="title" align="center">
					<h1>SUPER BATTLE SHIPS 2D</h1>
				</div>

				<?php
				include_once 'sqlscripts.php';

			//	if(!isset($newConnection)){
					if(!session_start()){
						session_start();
					}
			//		$newConnection = new db("localhost","root","ceng356$$!", "battleShip");
			//		$newConnection->start();
			//	}

				class shipParameters{

					public $shipLocations = array(10);
					public $shipCount = 0;
					public $shipLive = 10;
					public $shipHitLocation = 99;
					public $shipHits = 0;
					public $playerName = 0;
					public $pid = 0;
					public $opp_pid = 0;


					function configureGrid(){
						for($i=1; $i<9; $i++){
							for($j=1; $j<9; $j++){
								if(isset($_POST['checkBox'.$i.$j]) && $_POST['checkBox'.$i.$j] == 'Yes'){
									$this->shipLocations[$this->shipCount] = 'checkBox'.$i.$j;
									$this->shipCount++;
								}
							}
						}
					}
					function checkHit(){
							for($z=1; $z<9; $z++){
								if($this->shipLocations[$z] == $this->shipHitLocation){
									$this->shipHits= $this->shipHits + 1;
								}
							}
					}

					function checkLose(){
						if($this->shipHits == 10){
							echo "YOU LOSE BUHAHAHAHAHAHAHAHAHAHAHAHAHAHAHAHAHAHAHAH";
						//	deletePlayer();
						}
					}
				}

				class shipAttack{

					public $shipLocations = array(64);
					public $shipCount = 0;
					public $shipLive = 10;
					public $shipHitLocation = "checkBox213";

					function configureGrid(){
						for($i=1; $i<9; $i++){
							for($j=1; $j<9; $j++){
								if(isset($_POST['checkBox2'.$i.$j]) && $_POST['checkBox2'.$i.$j] == 'Yes'){
									$this->shipLocations[$this->shipCount] = 'checkBox2'.$i.$j;
									$this->shipCount++;
								}
							}
						}
					}
				}

				if(!isset($_SESSION["player1"])){
					$_SESSION["player1"] = new shipParameters;
					$_SESSION["player1"]->configureGrid();
					$_SESSION["player1"]->playerName = $_POST['playerName'];
					$_SESSION["player1"]->pid = ($_SESSION["player1"]->playerName);
					addPlayer($_SESSION["player1"]->playerName);
					sendShipLocations($_SESSION["player1"]->playerName, $_SESSION["player1"]->shipLocations);
					echo  $_SESSION["player1"]->pid;
					$opp_id = checkForOpponents($_SESSION["player1"]->pid);
				}
				//	check what the PLAYER 2 MOVE WAS THAT CAUSED A HIT
				if($_SESSION["player1"]->opp_pid != 0){
					$_SESSION["player1"]->shipHitLocation = hitlocation($_SESSION["player1"]->opp_pid);
				}
				$_SESSION["player1"]->checkHit();
				$_SESSION["player1"]->configureGrid();
				$_SESSION["player1"]->checkLose();




				if(!isset($_SESSION["player2"])){
					$_SESSION["player2"] = new shipAttack;
					$_SESSION["player2"]->configureGrid();
				}
				//CHECK THE PLAYER 1S MOVE HERE HERE HERE HERE HERE HERE HERE HERER HER ERH EHR EHR LID FKLDFKRIJF DJFI6 7F DJF9R 2LDFJRI
				$_SESSION["player2"]->shipHitLocation="checkBox214";
				$_SESSION["player2"]->configureGrid();

				function get_client_ip() {
    		$ipaddress = '';
    		if (getenv('HTTP_CLIENT_IP'))
        	$ipaddress = getenv('HTTP_CLIENT_IP');
    		else if(getenv('HTTP_X_FORWARDED_FOR'))
        	$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    		else if(getenv('HTTP_X_FORWARDED'))
        	$ipaddress = getenv('HTTP_X_FORWARDED');
    		else if(getenv('HTTP_FORWARDED_FOR'))
        	$ipaddress = getenv('HTTP_FORWARDED_FOR');
    		else if(getenv('HTTP_FORWARDED'))
       	$ipaddress = getenv('HTTP_FORWARDED');
    		else if(getenv('REMOTE_ADDR'))
        	$ipaddress = getenv('REMOTE_ADDR');
    		else
        	$ipaddress = 'UNKNOWN';
    		return $ipaddress;
				}

				echo get_client_ip();

				?>
					<div class='leftScreen' align='center'>
					<form action='gameReady.php' method='POST'>
					<table id='player1Table' class='tablePosition'>
						<tbody>
						<?php
						$_SESSION["player1"]->shipLive = 0;
						$printed = 0;
						for($i=1; $i<9; $i++){
							echo "<tr name='row$i'> \n";
							for($j=1; $j<9; $j++){
								$word = 'checkBox'.$i.$j;
								for($z=0; $z <10; $z++){
									if(isset($_SESSION["player1"]->shipLocations[$z]) && $_SESSION["player1"]->shipLocations[$z] == $word && $_SESSION["player1"]->shipHitLocation !== $_SESSION["player1"]->shipLocations[$z] && $printed == 0){
										$printed = 1;
										echo "<td id='col$i$j' name='col$i$j' class='gameReadyTd'> </td> \n";
									}
									if(isset($_SESSION["player1"]->shipLocations[$z]) && $_SESSION["player1"]->shipLocations[$z] == $word && $_SESSION["player1"]->shipHitLocation == $_SESSION["player1"]->shipLocations[$z] && $printed == 0){
										$_SESSION["player1"]->shipLocations[$z] = $_SESSION["player1"]->shipLocations[$z].'0';
										$printed = 1;
										$_SESSION["player1"]->shipLive = $_SESSION["player1"]->shipLive - 1;
										echo "<td id='col$i$j' name='col$i$j' class='shipHitTd'> </td> \n";
									}
									else if(isset($_SESSION["player1"]->shipLocations[$z]) && $_SESSION["player1"]->shipLocations[$z] == $word.'0' && $printed == 0){
										$printed = 1;
										$_SESSION["player1"]->shipLive = $_SESSION["player1"]->shipLive - 1;
										echo "<td id='col$i$j' name='col$i$j' class='shipHitTd'> </td> \n";
									}
								}
								if($printed == 0){
									echo "<td id='col$i$j' name='col$i$j'> </td> \n";
								}
								$printed = 0;
					 		}
						}
						?>
						</tr>
					</tbody>
					</table>
					</form>
				</div>
				<div class="leftScore" align="center">
					<h2> PLAYER 1 </h2>
				</div>
				<script type="text/javascript">
				function btnClick2(i, j) {
						var x = document.getElementById("player2Table").getElementsByTagName("td");
						i = (i-1)*8;
						j =
						j+i-1;
						// default background color onClick is blue
						var bgColor = "#ff0000";
						// unless background color is already blue, then set it to white
						if (x[j].style.backgroundColor == "rgb(255, 0, 0)")
						{
							bgColor = "#ffffff";
						}
						x[j].style.backgroundColor = bgColor;
				}
				</script>
				<div class="rightScreen" align="center">
					<form action="gameReady.php" method="POST">
					<table id="player2Table" class="tablePosition">
						<tbody>
						<?php
						for($i=1; $i<9; $i++){
							echo "<tr name='row$i'> \n";
							for($j=1; $j<9; $j++){
								$word = 'checkBox2'.$i.$j;
								for($z=0; $z <64; $z++){
									if(isset($_SESSION["player2"]->shipLocations[$z]) && $_SESSION["player2"]->shipLocations[$z] == $word && $_SESSION["player2"]->shipHitLocation !== $_SESSION["player2"]->shipLocations[$z] && $printed == 0){
										$printed = 1;
										echo "<td id='col$i$j' name='col$i$j' class='shipHitTd'><input onClick='btnClick2($i,$j);' type='checkbox' class='cell' name='checkBox2$i$j' value='Yes'> </td> \n";
									}
									if(isset($_SESSION["player2"]->shipLocations[$z]) && $_SESSION["player2"]->shipLocations[$z] == $word && $_SESSION["player2"]->shipHitLocation == $_SESSION["player2"]->shipLocations[$z] && $printed == 0){
										$printed = 1;
										echo "<td id='col$i$j' name='col$i$j' class='shipGreenTd'><input onClick='btnClick2($i,$j);' type='checkbox' class='cell' name='checkBox2$i$j' value='Yes'> </td> \n";
									}
								}
								if($printed == 0){
									echo "<td id='col$i$j' name='col$i$j'> <input onClick='btnClick2($i,$j);' type='checkbox' class='cell' name='checkBox2$i$j' value='Yes'></td> \n";

								}
								$printed = 0;
					 		}
						}
						?>
						</tr>
					</tbody>
					</table>
					<input type="submit" value="Submit">
					</form>
				</div>
				<div class="rightScore" align="center">
					<h2> PLAYER 2 </h2>
				</div>
			</div>
		</div>
</body>

</html>
