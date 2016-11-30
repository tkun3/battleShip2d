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
				include 'class.db.php';

				if(!isset($newConnection)){
					session_start();
					$newConnection = new db;
					$newConnection->construct("localhost","root","ceng356$$!", "battleShip");
					$newConnection->start();
				}

				class shipParameters{

					public $shipLocations = array(10);
					public $shipCount = 0;
					public $shipLive = 10;
					public $shipHitLocation = "checkBox15";

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
				}

				class shipAttack{

					public $shipAttack = array(64);
					public $shipCount = 0;
					public $shipLive = 10;
					public $shipHitLocation = "checkBox13";

					function configureGrid(){
						for($i=1; $i<9; $i++){
							for($j=1; $j<9; $j++){
								if(isset($_POST['checkBox2'.$i.$j]) && $_POST['checkBox2'.$i.$j] == 'Yes'){
									$this->shipAttack[$this->shipCount] = 'checkBox2'.$i.$j;
									$this->shipCount++;
								}
							}
						}
					}
				}

				if(!isset($_SESSION["player1"])){
					$_SESSION["player1"] = new shipParameters;
					$_SESSION["player1"]->configureGrid();
				}
				$_SESSION["player1"]->shipHitLocation="checkBox12";
				$_SESSION["player1"]->configureGrid();

				if(!isset($_SESSION["player2Table"])){
					$_SESSION["player2Table"] = new shipAttack;
					$_SESSION["player2Table"]->configureGrid();
				}
				$_SESSION["player2Table"]->configureGrid();

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
						$_SESSION["player1"]->shipLive = 10;
						$printed = 0;
						for($i=1; $i<9; $i++){
							echo "<tr name='row$i'> \n";
							for($j=1; $j<9; $j++){
								$word = 'checkBox'.$i.$j;
								for($z=0; $z <10; $z++){
									if(isset($_SESSION["player1"]->shipLocations[$z]) && $_SESSION["player1"]->shipLocations[$z] == $word && $_SESSION["player1"]->shipHitLocation !== $_SESSION["player1"]->shipLocations[$z]){
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
							echo "<tr name='row2$i'> \n";
							for($j=1; $j<9; $j++){
								echo "<td id='col2$i$j' name='col2$i$j'> <input type='checkbox' class='cell' name='checkBox2$i$j' onclick='btnClick2($i,$j)'> </td> \n";
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
		<?php

		if($_SESSION["player1"]->shipLive == 0){
			<form>
			</form>
		}

		 ?>
</body>

</html>
