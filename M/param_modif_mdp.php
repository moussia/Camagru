<?php

function verif_psw($mail, $psw)
{
	require('config/database.php');
	$req = $bdd->prepare('SELECT * FROM utilisateur WHERE mail= :mail');
	$req->execute(array(
				'mail' => $mail));
	$resultat = $req->fetch();
	// Comparaison du pass envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify($psw, $resultat['password']);
	if ($resultat)
	{
		if ($isPasswordCorrect)
			return 1;
	}
	else
		return 0;
}

function modif_mdp($psw, $mail)
{
	require('config/database.php');
	$pass_hach = password_hash($psw, PASSWORD_DEFAULT);
	$req = $bdd->prepare('UPDATE utilisateur SET password= :psw WHERE mail= :mail');
	$res = $req->execute(array(
				'psw' => $pass_hach,
				'mail' => $mail
				));
	if ($res)
	{
	?>
		<script type="text/javascript">
			alert('La modification à été correctement effectuée') ;
		</script>
	<?php
		return 1;
	}
	else{
	?>
		<script type="text/javascript">
			alert('Nous sommes désolés, nous ne pouvons pas mettre à jour votre mot de passe. Veuillez réessayer.');
		</script>
	<?php
		return 0;
	}
}

?>
