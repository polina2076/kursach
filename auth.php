<?php
	require_once"connection.php";
	header('content-Type: text/html; charset=utf-8');
	session_start();

	if(isset($_POST['login']))
	{
		$login = $_POST['login'];
	}
	if(isset($_POST['password']))
	{
		$password = $_POST['password'];
	}
	if (empty($login) or empty($password))
	{
		$data = array('error' => 'Вы ввели не всю информацию.');
		die( json_encode( $data ) );
	}

	$login = stripslashes($login);
	$login = htmlspecialchars($login);
	$password = stripslashes($password);
	$password =htmlspecialchars($password);
	$login = trim($login);

	$result = mysqli_query($db,"SELECT * FROM user WHERE login = '$login'");
	$myrow = mysqli_fetch_array($result);
	if(empty($myrow['password']))
	{
		$data = array('error' => 'Извините введеный вами логин или пароль неверный.');
		die( json_encode( $data ) );
	}
	else{
		if($myrow['password']==$password){
			$_SESSION['login']=$myrow['login'];
			$_SESSION['id_user']=$myrow['id'];
			$data = array('success' => $myrow['login']);
			die( json_encode( $data ) );
		}
		else{
			$data = array('error' => 'При запросе произошла ошибка, попробуйте снова.');
			die( json_encode( $data ) );
		}
	}
?>