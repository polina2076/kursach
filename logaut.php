<?php
session_start();
if (isset($_SESSION['login']))
{
	unset ($_SESSION['login']);
	unset ($_SESSION['id_user']);
	require_once"index.php";
}
exit;
?>