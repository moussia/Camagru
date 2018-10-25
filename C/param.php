<?php

/*Pour modifier pseudo et mail*/
function modif_pseudo()
{
	$pseudo = isset($_POST['pseudo'])?$_POST['pseudo']:'';
	$mail = isset($_POST['mail'])?$_POST['mail']:'';

	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	if (count($_POST) != 2)
	{
		require 'V/param.html';
	}
	else{
		require('M/param_bd.php');
		if ((modif_pseudo_bd($pseudo, $mail)) == 1)
		{
			$_SESSION['profil']['pseudo'] = $pseudo;
			$_SESSION['profil']['mail'] = $mail;
			require 'V/param.html';
		}
	}
}

/*Pour modifier le mot de passe*/
function modif_psw()
{
	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}

	$old_psw = isset($_POST['old_psw'])?$_POST['old_psw']:'';
	$new_psw = isset($_POST['new_psw'])?$_POST['new_psw']:'';
	$mail = $_SESSION['profil']['mail'];

	require 'M/param_modif_mdp.php';
	if (count($_POST) != 2)
		require 'V/mdp.html';
	//si le old password nest pas egal
	else if ((verif_psw($mail, $old_psw)) == 0){
		?>
			<script type="text/javascript">
			alert('Le mot de passe actuel n\'est pas valide');
		</script>
			<?php
			require 'V/mdp.html';
	}
	else if ($old_psw == $new_psw){
		?>
			<script type="text/javascript">
			alert('Euh, il semble que vous ayez déjà utilisé ce mot de passe auparavant. Veuillez en choisir un nouveau.');
		</script>
			<?php
			require 'V/mdp.html';
	}
	else if ((strlen($new_psw) < 8) || (!preg_match("#[0-9]+#", $new_psw) || (!preg_match("#[a-zA-Z]+#", $new_psw)))){
		?>
			<script type="text/javascript">
			alert('Votre mot de passe doit contenir au moins 7 caractères et inclure un chiffre');
		</script>
			<?php
			require 'V/mdp.html';
	}
	else{
		if ((modif_mdp($new_psw, $mail)) == 1)
			require 'V/mdp.html';
	}
}

function delete_account()
{
	require 'V/delete_account.html';
}

function delete_compte()
{
	$password = isset($_POST['password'])?$_POST['password']:'';

	if (!isset($_SESSION['profil']))
	{
		require 'C/accueil.php';
		home();
		return ;
	}
	if (count($_POST) != 1)
		require 'V/delete_account.html';
	if (isset($password) && $password != "")
	{
		require 'M/delete_account.php';
		delete_account_bd($password);
	}
	require 'C/accueil.php';
	home();
	return 1;
}



?>
