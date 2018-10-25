<?php

function deconnect()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	$_SESSION['profil']['mail'] = NULL;
	session_destroy();
	header("location: ./");
}

?>
