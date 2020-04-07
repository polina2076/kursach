<?php
	session_start();
	
	$_SESSION['products'] = "4";
	header('Location: /ochki.php');
	
?>