<?php

function delete_account_bd($password)
{
	require('config/database.php');
	$id = $_SESSION['profil']['id'];
	$req = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ?');
	$req->execute(array($id));
	$resultat = $req->fetch();
	// Comparaison du pass envoyé via le formulaire avec la base
	$isPasswordCorrect = password_verify($password, $resultat['password']);
	if ($resultat)
	{
		if ($isPasswordCorrect)
		{
			$req = $bdd->prepare('SELECT img_id FROM images WHERE creator_id = ?');
			$req->execute(array($id));
			while ($el = $req->fetch())
			{
				$reqb = $bdd->prepare('DELETE FROM commantaire WHERE image = ?');
				$reqb->execute(array($el['img_id']));
				$reqb = $bdd->prepare('DELETE FROM likes WHERE img_id = ?');
				$reqb->execute(array($el["img_id"]));
			}
			$reqb = $bdd->prepare('DELETE FROM likes WHERE creator_id = ?');
			$reqb->execute(array($id));
			$reqb = $bdd->prepare('DELETE FROM commantaire WHERE creator = ?');
			$reqb->execute(array($id));
			$reqb = $bdd->prepare('DELETE FROM images WHERE creator_id = ?');
			$reqb->execute(array($id));
			$reqb = $bdd->prepare('DELETE FROM utilisateur WHERE id = ?');
			$reqb->execute(array($id));
			require 'C/logout.php';
			deconnect();
			?>
			<script type="text/javascript">
				alert('Votre compte a été supprimé.');
			</script>
			<?php
			require ('C/accueil.php');
			home();
		}
		else
		{
?>
			<script type="text/javascript">
				alert('Le mot de passe n\'est pas correct.');
			</script>
			<?php
		}
	}
}


?>
