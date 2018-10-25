<?php
//@author : Moussia MOTTAL
session_start();

$controle = isset($_GET['controle'])?$_GET['controle']:'accueil';
$action = isset($_GET['action'])?$_GET['action']:'home';

$forget_psw = isset($_GET['controle'])?$_GET['controle']:'forget_psw';
$valid = isset($_GET['r'])?$_GET['r']:'';

if ($valid != "")
{
	require ('./C/confirmation.php');
	confirmation();
}
if (count($_GET) == 0)
{
	require 'C/accueil.php';
	home();
	return ;
}
if ((count($_GET) != 0) && (isset($_GET['controle']) && isset ($_GET['action'])))
{
	if ((count($_GET) != 0) && (file_exists('./C/' . $controle . '.php')))
	{
		require ('./C/' . $controle . '.php');
		if ((count($_GET) != 0) && (function_exists($action)))
		{
			$action();
			return ;
		}
	}
}
require ('./V/erreur404.html'); //cas d'un appel à index.php avec des paramètres incorrects
?>
