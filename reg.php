<?php

require_once"connection.php";
	header('content-type:text/html; charset=utf-8');
	if(isset($_POST['Name'])){
$Name = $_POST['Name'];
 if ( $Name=='')
{ unset($Name);
}}
if(isset($_POST['Surname'])){
$Surname = $_POST['Surname'];
 if ( $Surname=='')
{ unset($Surname);
}}

if(isset($_POST['telephone'])){
$telephone = $_POST['telephone'];
 if ( $telephone=='')
{ unset($telephone);
}}
	if(isset($_POST['login'])){
$login = $_POST['login'];
 if ( $login=='')
{ unset($login);
}}
if(isset($_POST['password']))
{
$password = $_POST['password'];
 if ( $password=='')
{ unset($password);
}}
if (empty($login) or empty($password))
{
exit("Вы ввели не всю информацию!");
}

$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password =htmlspecialchars($password);

$name = trim($Name);
$surname = trim($Surname);

$telephon = trim($telephone);
$login = trim($login);

$result = mysqli_query($db,"select id from user where login='$login'");
$myrow = mysqli_fetch_array($result);
if(!empty($myrow['id'])){
	
	exit("Введеный вами логин уже зарегистрирован.");
	
	
}

$result2 = mysqli_query($db,"INSERT INTO user(Name,Surname,telephone,login,password) 
values ('$Name','$Surname','$telephone','$login','$password')");
if($result2=='true'){
	require_once"index.php";
}


else{
	echo"Ошибка регистрации";
}
?>