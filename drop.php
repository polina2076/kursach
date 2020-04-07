<?php
	session_start();
	require_once"connection.php";
	$query = mysqli_query($db,"DELETE FROM user WHERE login='$_SESSION[login]'");
	
	if($query){
		unset($_SESSION['login']);
		unset($_SESSION['id_user']);
		require_once"index.php";
		
	}
?>