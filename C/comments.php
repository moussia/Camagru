<?php

function comments()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	$comment = isset($_POST['com'])?$_POST['com']:'';
	$img_id = isset($_POST['img_id'])?$_POST['img_id']:'';

	if ($img_id != "" && $comment != "")
	{
		require 'M/comments_bd.php';
			save_comments($comment, $img_id);
	}
	require_once 'C/accueil.php';
	home();
	return 1;
}

function delete_com()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	$id_com = isset($_POST['id'])?$_POST['id']:'';
	if ($id_com != "")
	{
		require 'M/comments_bd.php';
		delete_comment($id_com);
	}
	require_once 'C/accueil.php';
	home();
	return 1;

}

?>
