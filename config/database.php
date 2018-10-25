<?php

$DB_DSN = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "000000";
//$DB_USER = "moussia";
//$DB_PASSWORD = "0000";
$DB_NAME = "camagru";

try
{
//	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'moussia', '0000');
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'root', '000000');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
}
catch (Exception $error)
{
	print "Error while connecting to the new database !: " . $error->getMessage() . "<br/>";
	die();
}

?>
