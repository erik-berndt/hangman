<?php
include "./randomPhrase.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./public/css/style.css">
    <title>Document</title>
</head>
<body>


<?php

//: start new SESSION - get random phrase
if (!isset($_SESSION['randPhrase'])) {
	$smt = $pdo->query("SELECT * FROM hangman ORDER BY RAND() LIMIT 2");
	getPhrase($smt);
}

//: create arrays for better comparabiliy
$alpha = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
$letters = str_split($_SESSION['randPhrase']);

//: declare string variables
$guess = '';
$result = '';

//: outsourced check engine
include('./checkMatches.php');

//: your score
echo "
	<div class='count'>
		<div class='value'>$wrong 💀</div>
		<div class='value'> Total: $total</div>
		<div class='value'>🍺 $right</div>
	</div>";


?>
<div>
    <form method="POST">
        <div class="form">
            <div>
                <input id="guess" type="text" name="guess" autocomplete="off" size="1"
                       minlength="1" maxlength="1" placeholder="🤔" autofocus><br>
            </div>
            <div>
                <input id="solution" type="text" name="solution" autocomplete="off" placeholder="ich weiss es">
            </div>
            <button type="submit" hidden></button>
        </div>
    </form>
</div>
</body>
</html>

