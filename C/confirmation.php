<?php

function confirmation()
{
	require 'config/database.php';
	$var = isset($_GET['r'])?$_GET['r']:'';
	$req = $bdd->prepare('SELECT id FROM utilisateur WHERE id = ? AND validation = 0');
	$req->execute(array($_GET['r']));
	if($req->rowCount() == 1)
	{
		$req = $bdd->prepare('UPDATE utilisateur SET validation = 1 WHERE id = ?');
		$req->execute(array($_GET['r']));
?>
		<script type="text/javascript">
		alert('Your account is now confirmed, you may now sign in.');
		</script>
<?php
	}
	else
	{
?>
		<script type="text/javascript">
		alert('This account could not be confirmed.');
		</script>
<?php
		require 'V/connect.html';
	}
}

function notif()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	require 'config/database.php';
	$var = isset($_POST['notif'])?$_POST['notif']:'0';
	$mail = $_SESSION['profil']['mail'];

	$req = $bdd->prepare('UPDATE utilisateur SET notification = ? WHERE mail = ?');
	$req->execute(array($var, $mail ));

	$_SESSION['profil']['notification'] = $var;
?>
		<script type="text/javascript">
		alert('Mis a jour des notifications');
		</script>
<?php
	require 'V/param.html';
}


?>
