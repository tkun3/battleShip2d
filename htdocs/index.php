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

				$ship1;

				$shipCount = 1;

				for($i=1; $i<9; $i++){
					for($j=1; $j<9; $j++){
						if(isset($_POST['checkBox15']) && $_POST['checkBox15'] == 'Yes'){
							$ship1 = 'checkBox'.'$i$j';
							$shipCount++;
						}
					}
				}

				if(isset($ship1)){
					echo asdfasdfdsfasfdsfasfasdfasdfasdfasdfa;
				}
				 ?>

				<div class="leftScreen" align="center">
						<!-- Dynamic Ship Selection Table -->	<!-- Dynamic Ship Selection Table -->	<!-- Dynamic Ship Selection Table -->
					<form action="index.php" method="POST">
					<table id="player1Table" class="tablePosition">
						<tbody>

						<script type="text/javascript">
						function btnClick(i, j) {
								var x = document.getElementById("player1Table").getElementsByTagName("td");
								i = (i-1)*8;
								j =
								j+i-1;
								
								// default background color onClick is blue
								var bgColor = "#9999ff";
								
								// unless background color is already blue, then set it to white
								if (x[j].style.backgroundColor == "rgb(153, 153, 255)")
								{
									bgColor = "#ffffff";
								}
									
								x[j].style.backgroundColor = bgColor;
								
						}
						</script>

						<?php
						for($i=1; $i<9; $i++){
							echo "<tr name='row$i'> \n";
							for($j=1; $j<9; $j++){
								echo "<td id='col$i$j' onClick='btnClick($i,$j);'  name='col$i$j'> <input type='checkbox' class='cell' value='Yes' name='checkBox$i$j'> </td> \n";
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
