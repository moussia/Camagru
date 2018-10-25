<!DOCTYPE html>
<?php

if (isset($_SESSION['profil']))
{
?>
<div id="menu">
	<ul>
		<li><a href="index.php?controle=accueil&action=home">Camagru</a></li>
		<li><a href="index.php?controle=connect&action=webcam">Webcam</a></li>
		<li><a href="#">Mon compte</a>
			<ul>
				<li><a href="index.php?controle=param&action=modif_pseudo">Modifier le profil</a></li>
				<li><a href="index.php?controle=param&action=modif_psw">Changer le Mot de passe</a></li>
			</ul>
		</li>
		<li><a href="index.php?controle=logout&action=deconnect">Déconnexion</a></li>
	</ul>
</div>
<?php
}
else
{
?>
<div id="menu">
	<ul>
		<li><a href="index.php?controle=accueil&action=home">Camagru</a></li>
		<li><a href="#" class="try">Mon compte</a>
			<ul>
				<li><a href="index.php?controle=connect&action=ident">Connexion</a></li>
				<li><a href="index.php?controle=inscription&action=ident">Créer un compte</a></li>
			</ul>
		</li>
	</ul>
</div>
<?php
}
?>
