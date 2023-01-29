<!DOCTYPE html>

<html>
  <head>
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
		<title>pampelguess</title>
  </head>
	<body>


<?php
include "./randomPhrase.php";

//: start new SESSION - get random phrase
if (!isset($_SESSION['randPhrase'])) {
	$smt = $pdo->query("SELECT * FROM hangman ORDER BY RAND() LIMIT 2");
	getPhrase($smt);
}

//: create arrays for better comparabiliy
$alpha   = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
$letters = str_split($_SESSION['randPhrase']);

//: declare string variables
$guess   = '';
$result  = '';

//: outsourced check engine
include('./checkMatches.php');

//: your score
echo "
	<div class='count'>
		<div class='value'>🍺 $right</div>
		<div class='value'> Total: $total</div>
		<div class='value'>💀 $wrong</div>
 </div>";


?>
			<div>	
				<form method="POST">
				<div class="form">	
					<div>
						<input id="guess" type="text" name="guess"  autocomplete="off" size="1" 
							minlength="1" maxlength="1" placeholder="🤔" autofocus><br>
					</div>
					<div>
				 		<input id="solution" type="text" name="solution" autocomplete="off" placeholder="ich weiss es">
					</div>
					<button type="submit" hidden></button> 
				</div>
				</form>
			</div>
		</div>
	</body>
</html>

