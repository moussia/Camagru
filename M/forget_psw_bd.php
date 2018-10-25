<?php

function forget_psw_bd($mail)
{
	require_once('config/database.php');
	if(isset($_POST) & !empty($_POST)){
		$username = mysqli_real_escape_string($connection, $_POST['mail']);
		$sql = "SELECT * FROM `pseudo` WHERE mail = '$username'";
		$res = mysqli_query($connection, $sql);
		$count = mysqli_num_rows($res);
		if($count == 1){
			echo "Send email to user with password";
		}else{
			echo "User name does not exist in database";
		}
	}
}
?>
