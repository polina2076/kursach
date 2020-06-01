<?php
session_start();
if (isset($_SESSION['login']))
{
	unset ($_SESSION['login']);
	unset ($_SESSION['id_user']);
	$data = array('success' => 'logout success');
    die( json_encode( $data ) );
}
?>