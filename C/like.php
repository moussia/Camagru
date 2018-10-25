<?php

function like()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	$img_id = isset($_POST['img_id'])?$_POST['img_id']:'';
	if (isset($_POST['img_id']) && $_POST['img_id'] != "")
	{
		require 'M/like_bd.php';
		save_like2($img_id);
	}
	require_once 'C/accueil.php';
	home();
	return 1;
}


?>
