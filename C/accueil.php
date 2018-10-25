<?php

function home()
{
	if (isset($_SESSION['profil']))
	{
		$user =  $_SESSION['profil']['pseudo'];
	}
	require 'V/accueil.html';
}


?>
