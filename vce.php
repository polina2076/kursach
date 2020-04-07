<?php
	session_start();
	
	unset($_SESSION['products']);
	header('Location: /ochki.php');
	
?>