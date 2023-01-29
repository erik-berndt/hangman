<?php
ob_start();
session_start();

//: connect to db 
$pdo = require('./connect.php');

//: prepare queries
$smt = $pdo->query("SELECT * FROM hangman ORDER BY RAND() LIMIT 2");
$cnt = $pdo->query("SELECT COUNT(*) FROM hangman");


//: deliver random phrase - set SESSION variables
function getPhrase($smt) {
	$randPhrase = $smt->fetch(PDO::FETCH_ASSOC);
	$_SESSION['round']      = 0;
	$_SESSION['randPhrase'] = strtoupper(trim($randPhrase["phrase"]));
	$_SESSION['right']      = [];
	$_SESSION['wrong']      = [];
}

//: build up db content and table
function createTable($pdo) {
	$phrases = fopen('./appdata/hangPhrases.txt','r');
	$pdo->query(
		"DROP TABLE IF EXISTS hangman;
		CREATE TABLE hangman (
		id INT AUTO_INCREMENT PRIMARY KEY,
		phrase VARCHAR(150)
		)");
	while ($phrase = fgets($phrases)) {
		$pdo->query("INSERT INTO hangman VALUES(NULL, '$phrase')");
	}

	fclose($phrases);
}

//: check for new/removed phrases in .txt file (boolean)
function checkContent ($cnt) {
	$dblines = $cnt->fetch(PDO::FETCH_ASSOC);
	$dblines = $dblines["count(*)"];
	$lines = count(file("./appdata/hangPhrases.txt"));
	return $dblines == $lines;
}

//: build db-table if empty or changes made in .txt file
if (!$smt->fetch(PDO::FETCH_ASSOC) || !checkContent($cnt)) {
	createTable($pdo);
} else {
	if (isset($_SESSION['randPhrase'])) {
		$_SESSION['randPhrase'] = $_SESSION['randPhrase'];
	} else {
		getPhrase($smt);
	}
}

?>
