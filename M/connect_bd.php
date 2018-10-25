<?php

function verif_ident($mail, $password)
{
	require('config/database.php');
	$req = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = ?');
	$req->execute(array($mail));
	$resultat = $req->fetch();
	// Comparaison du pass envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify($password, $resultat['password']);
	/*mauvais identifiant*/
	if (!$resultat)
		return 0;
	else
	{
		if ($isPasswordCorrect){
			$_SESSION['profil'] = $resultat;
			return 1;
		}
	}
	return 0;
}

?>

