<?php
	require_once"connection.php";
	
	if(isset($_POST['name'])){
		$Name = $_POST['name'];
	}

	if(isset($_POST['surname'])){
		$Surname = $_POST['surname'];
	}

	if(isset($_POST['phone'])){
		$phone = $_POST['phone'];
	}

	if(isset($_POST['login'])){
		$login = $_POST['login'];
	}

	if(isset($_POST['password']))
	{
		$password = $_POST['password'];
	}

	if (empty($login) or empty($password))
	{
		$data = array('error' => 'Вы не ввели логин или пароль.');
		die( json_encode( $data ) );
	}

	$login = stripslashes($login);
	$login = htmlspecialchars($login);
	$password = stripslashes($password);
	$password =htmlspecialchars($password);

	$result = mysqli_query($db,"SELECT id FROM user WHERE login='$login'");
	$myrow = mysqli_fetch_array($result);
	if(!empty($myrow['id'])){
		$data = array('error' => 'Введеный вами логин уже зарегистрирован.');
		die( json_encode( $data ) );
	}

	$result2 = mysqli_query($db,"INSERT INTO user(Name,Surname,telephone,login,password) 
	values('$Name','$Surname','$phone','$login','$password')");
	if($result2){
		$data = array('success' => 'Ok');
		die( json_encode( $data ) );
	}
	else{
		$data = array('error' => 'Ошибка регистрации, попробуйте снова.');
		die( json_encode( $data ) );
	}
?>