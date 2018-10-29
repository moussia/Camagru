<?php require_once('config/database.php'); ?>
<?php

function ident()
{
	$pseudo = isset($_POST['pseudo'])?$_POST['pseudo']:'';
	$mail = isset($_POST['mail'])?$_POST['mail']:'';
	$password1 = isset($_POST['psw'])?$_POST['psw']:'';
	$password2 = isset($_POST['psw1'])?$_POST['psw1']:'';

	if (count($_POST) != 4)
		require 'V/inscription.html';
	else if ($password1 != $password2){
		?>
			<script type="text/javascript">
			alert('Les Mots de passe ne sont pas identiques');
		</script>
			<?php
			require 'V/inscription.html';
	}
	else if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL) || (!preg_match("/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/", $mail))){
		?>
			<script type="text/javascript">
			alert('Le mail n\'est pas valide');
		</script>
			<?php
			require 'V/inscription.html';
	}
	else if ((strlen($password1) < 8) || (!preg_match("#[0-9]+#", $password1) || (!preg_match("#[a-zA-Z]+#", $password1)))){
		?>
			<script type="text/javascript">
			alert('Votre mot de passe doit contenir au moins 8 caractères et inclure un chiffre');
		</script>
			<?php
			require 'V/inscription.html';
	}
	else{
		require 'M/inscription_bd.php';
		if (inscription($pseudo, $mail, $password1) == 1)
		{
			send_mail($pseudo, $mail);
		}
		else{
			?>
				<script type="text/javascript">
				alert('Cette adresse e-mail ou pseudo est déjà attribuée à un autre client');
			</script>
				<?php
				require 'V/inscription.html';
			return (1);
		}
	}
}

function send_mail($pseudo, $mail)
{
	require 'config/database.php';
	$req = $bdd->prepare('select id from utilisateur where pseudo = ?');
	$req->execute(array($_POST['pseudo']));
	$data = $req->fetch();
	
	$subject = 'Confirmation du compte -Camagru-!';
	$message = 'Bonjour, ' . $pseudo  . ' Pour valider votre compte, veuillez cliquer sur le lien ci dessous : http://localhost:8080/supprimer/index.php?r='.$data['id']. '&controle=accueil&action=home';
	mail($mail, $subject, $message); //, implode("\r\n", $headers));
	require 'V/Confirmation.php';

}

?>
