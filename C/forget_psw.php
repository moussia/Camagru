<?php

function forget_psw()
{
	$mail = isset($_POST['mail'])?$_POST['mail']:'';
	require 'M/forget_psw_bd.php';
	if (count($_POST) != 1)
		require 'V/forget_psw.html';
	else if (forget_psw_bd($mail) == 1)
	{
		require 'M/forget_psw_bd.php';
	}
		require 'V/connect.html';
}

?>
