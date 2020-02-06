<?php
require 'database.php';
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=camagru;charset=utf8', 'my_name', 'my_password');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET NAMES 'UTF8'");
	$bdd->query("DROP DATABASE IF EXISTS camagru");
	$bdd->query("CREATE DATABASE camagru");
	$bdd->query("use camagru");

	//users
	$bdd->query("CREATE TABLE utilisateur(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				pseudo TEXT NOT NULL,
				mail TEXT NOT NULL,
				password TEXT NOT NULL,
				validation BOOLEAN NOT NULL DEFAULT FALSE,
				notification BOOLEAN NOT NULL)");

	//images
	$bdd->query("CREATE TABLE images(
				img_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				data LONGBLOB NOT NULL,
				titre varchar(255) COLLATE utf8_bin NOT NULL,
				creator_id int(10) UNSIGNED NOT NULL,
				date_creation datetime NOT NULL)");

	//comments
	$bdd->query("CREATE TABLE commantaire(
				id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				creator INT UNSIGNED NOT NULL,
				creation datetime  NOT NULL,
				image INT UNSIGNED NOT NULL,
				comment TEXT NOT NULL)");

	//likes
	$bdd->query("CREATE TABLE likes(
				likes_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
				creator_id INT UNSIGNED NOT NULL,
				img_id INT UNSIGNED NOT NULL)");
}
catch (Exception $error)
{
	print "Error while connecting to the new database !: " . $error->getMessage() . "<br/>";
	die();
}
?>
