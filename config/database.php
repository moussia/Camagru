<?php

$DB_DSN = "localhost";
$DB_USER = "my_name";
$DB_PASSWORD = "my_password";
$DB_NAME = "camagru";

try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
}
catch (Exception $error)
{
	print "Error while connecting to the new database !: " . $error->getMessage() . "<br/>";
	die();
}

?>
