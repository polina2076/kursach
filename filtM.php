<?php
	
session_start();
	
	$_SESSION['products'] = "3";
	header('Location: /ochki.php');
	
?>