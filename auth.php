<?php
	require_once"connection.php";
header('content-Type: text/html; charset=utf-8');
session_start();
if(isset($_POST['login']))
{
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

$login = trim($login);



$result = mysqli_query($db,"SELECT * FROM user WHERE login='$login'");
if(!$result) echo"error";
$myrow = mysqli_fetch_array($result);
if(empty($myrow['password']))
{
exit ("Извините введеный вами логин или пароль неверный");
}
else{
if($myrow['password']==$password){

$_SESSION['login']=$myrow['login'];
$_SESSION['id']=$myrow['id'];
require_once"index.php";
}

else{
exit("Извините введеный вами логин или пароль неверный");

}

}






?>
