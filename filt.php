<?php
session_start();
	
	$_SESSION['products'] = "2";
	header('Location: /ochki.php');
?>
