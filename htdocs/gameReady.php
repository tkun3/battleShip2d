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
				$ship = array(10);
				$shipCount = 0;

				for($i=1; $i<9; $i++){
					for($j=1; $j<9; $j++){
						if(isset($_POST['checkBox'.$i.$j]) && $_POST['checkBox'.$i.$j] == 'Yes'){
							$ship[$shipCount] = 'checkBox'.$i.$j;
							echo $ship[$shipCount];
							$shipCount++;
						}
					}
				}
				?>
					<div class='leftScreen' align='center'>

						<!-- Dynamic Ship Selection Table -->	<!-- Dynamic Ship Selection Table -->	<!-- Dynamic Ship Selection Table -->
					<form action='gameReady.php' method='POST'>
					<table id='player1Table' class='tablePosition'>
						<tbody>
						<?php
						$printed = 0;
						for($i=1; $i<9; $i++){
							echo "<tr name='row$i'> \n";
							for($j=1; $j<9; $j++){
								$word = 'checkBox'.$i.$j;
								for($z=0; $z <10; $z++){
									if(isset($ship[$z]) && $ship[$z] == $word){
										$printed = 1;
										echo "<td id='col$i$j' name='col$i$j' class='gameReadyTd'> </td> \n";
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
					<input type="submit" value="Submit">
					</form>
					<!-- Dynamic Ship Selection Table -->	<!-- Dynamic Ship Selection Table -->	<!-- Dynamic Ship Selection Table -->
				</div>
				<div class="leftScore" align="center">
					<h2> PLAYER 1 </h2>
				</div>
				<div class="rightScreen" align="center">
					<table id="player2Table" class="tablePosition">
						<tbody>
						<?php
						for($i=1; $i<9; $i++){
							echo "<tr name='row2$i'> \n";
							for($j=1; $j<9; $j++){
								echo "<td id='col2$i$j' name='col2$i$j'> <input type='checkbox' class='cell' name='button2$i$j'> </td> \n";
					 		}
						}
						?>
						</tr>
					</tbody>
					</table>
				</div>
				<div class="rightScore" align="center">
					<h2> PLAYER 2 </h2>
				</div>

			</div>
		</div>
</body>

</html>
