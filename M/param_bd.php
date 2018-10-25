<?php

function modif_pseudo_bd($pseudo, $mail)
{
	require ('config/database.php');
	$old_mail = $_SESSION['profil']['mail'];
	$sql = $bdd->prepare('UPDATE utilisateur SET pseudo = :pseudo, mail = :mail WHERE mail= :old_mail ');
	$res = $sql->execute(array(
				'pseudo' => $pseudo,
				'mail' => $mail,
				'old_mail' => $old_mail
				));
	if($res)
	{
	?>
		<script type="text/javascript">
			alert('La modification à été correctement effectuée');
		</script>
	<?php
		return 1;
	}
	else
	{
	?>
		<script type="text/javascript">
			alert('La modification à échouée');
		</script>
	<?php
		return 0;
	}
	$req->closeCursor();
}

?>
