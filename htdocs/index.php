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
				<div class="leftScreen" align="center">
					<form action="/index.php" method="POST">
					<table id="player1Table" class="tablePosition">
						<tbody>

						<script type="text/javascript">
						function btnClick(i, j) {
								var x = document.getElementById("player1Table").getElementsByTagName("td");
								i = (i-1)*8;
								j = j+i-1;
								x[j].style.backgroundColor = "#9999ff";
						}

						</script>
						<?php
						for($i=1; $i<9; $i++){
							echo "<tr name='row$i'> \n";
							for($j=1; $j<9; $j++){
								echo "<td id='col$i$j' onClick='btnClick($i,$j);'  name='col$i$j'> <input type='checkbox' class='cell' name='button$i$j'> </td> \n";
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
				<div class="rightScreen" align="center">
				</div>
				<div class="rightScore" align="center">
					<h2> PLAYER 2 </h2>
				</div>

			</div>
		</div>
</body>

</html>
