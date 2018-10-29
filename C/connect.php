<?php

function ident()
{
	$mail = isset($_POST['mail'])?$_POST['mail']:'';
	$password = isset($_POST['psw'])?$_POST['psw']:'';

	if (count($_POST) != 2)
		require 'V/connect.html';
	else
	{
		require 'M/confirmation.php';
		if (valid_bd($mail) == 1)
		{
			require 'M/connect_bd.php';
			if (verif_ident($mail, $password) == 1)
			{
				sleep(1); // Une pause de 1 sec
				require 'C/accueil.php';
				home();
			}
			else
			{
?>
				<script type="text/javascript">
				alert('Mauvais mot de passe ou identifiant');
				</script>
<?php
				//echo 'Mauvais mot de passe ou identifiant';
				require 'V/connect.html';
			}
		}
	}
}

function forget()
{
	require 'config/database.php';
	if (isset($_POST['mail']) && $_POST['mail'] != "")
	{
		$req = $bdd->prepare('SELECT id FROM utilisateur WHERE mail = ?');
		$req->execute(array($_POST["mail"]));
		if($req->rowCount() == 1)
		{
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array();
			$alphaLength = strlen($alphabet) - 1;
			for ($i = 0; $i < 18; $i++)
			{
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			$pass = implode($pass);
			$msg = $pass." is your new password, change it as soon as possible !";
			mail($_POST['mail'], 'Password reset', $msg);
			$req = $bdd->prepare('UPDATE utilisateur SET password = ? WHERE mail = ?');
			$hash = password_hash($pass, PASSWORD_DEFAULT);
			$req->execute(array($hash, $_POST["mail"]));
			require 'V/forget_psw.html';
		?>	<script type="text/javascript">
			alert('E-mail envoye !');
			</script>
		<?php
		}
		else
		{
?>
			<script type="text/javascript">
			alert('Le compte n\'existe pas !');
			</script>
<?php
			require 'V/forget_psw.html';
		}
	}
}

function forget_psw()
{
	require 'V/forget_psw.html';
}

function webcam()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	require 'V/webcam.php';
}
?>
