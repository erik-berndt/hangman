<?php
//: set variables for database connection data
$host     = 'localhost';
$db       = 'games';
$user     = 'erik';
$password = '321null';

function connect($host, $db, $user, $password)
	{
		$con = "mysql:host=$host; dbname=$db; charset=UTF8";

		//: establish db-connection - catsh error at fail
		try {
			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			];
			return new PDO($con, $user, $password, $options);
	} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
	return connect($host, $db, $user, $password);

?>
