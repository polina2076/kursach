<?php
	session_start();
?>
<html>
   <head>
   <script src="https://use.fontawesome.com/306ada9451.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
 <title> в Кузьминках </title>

	<link href ="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/new.css">
    <link rel="shortcut icon" href="images/izi.jpg" type="image/jpg">
	  <link rel="stylesheet" href="http://htmlbook.ru/mysite.css">
  <link rel="stylesheet" href="http://www.htmlbook.ru/main.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   </head>
   
<body>
    <div class="container" >


        <div id="head-site">
		<a href="index.php"><img src="images/izi.jpg"style="width:160px; "   title="вКузьминках" id="logo" /></a>
		
			<div class="mainmenu" style= "width: 500px;margin-right: 10px;margin-left: 0px;right: 0px;left: 100px;margin-bottom: 0px;margin-top: 0px;"> 
				<ul>
				<li><a href="index.php">О нас</a></li>
				<li><a href="lenta.php">Лента</a></li>
				<li><a href="ochki.php">Очки</a></li>
				<li><a href="yslugi.php">Услуги</a></li>
				</ul>
			</div>
			
		
		
            
			
		<?php
			if(!empty($_SESSION['login'])){
				
				?>
				<div>
				<form action="logaut.php">
				<input class='logaut' name="submit" type="submit" value='Выход'>
				</form>
				<form action="drop.php">
				<input class='logaut' name="submit" type="submit" value='Удалить учетную запись'>
				</form>
				</div>
			<?php
			}
			else{
			
		?>	
<form class="reg" action = "auth.php" method="post" >


 <p class="reg2">
<input name ="login" type="text"  size="15" maxlength="15">
<i class="icon-lock icon-large fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
</p>
<p>

<p class="reg2">
<input name="password" type="password" size="15" maxlength="15">
 <i class="icon-lock icon-large fa fa-unlock-alt fa-2x"></i>
</p>
<p>
<p class="submit">
 

 <button class="btn"><i class="fa fa-home"></i></button>
<br>

<br>
</p><a data-toggle="modal" data-target="#myModalAuth" href="#">Зарегестрироваться</a></form>
<?php
			}
?>

<br>
	<h1 id="titlehead">вКузьминках</h1>
        </div>
	  
	
    <div class="modal fade" id="myModalAuth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class= "modal-dialog" >
 <div class= "modal-content" >
 <div class= "modal-header"  id= "headModal" >
                
                  <type="submit" name="regBtn" class="modalBtn" value="Регистрация">
 </div>
 <div class= "modal-body" >
                  

                  <form action="reg.php" method="post" class="modalForm" id="formReg" v-else-if="formStatus==false">
						<input type="text" name="Name" placeholder="Имя"><br>
						<input type="text" name="Surname" placeholder="Фамилия"><br>
						
                      <input type="text" name="telephone" placeholder="Телефон"><br>
                      <input type="text" name="login" placeholder="Логин"><br>
                      <input type="password" name="password" placeholder="Пароль"><br>
 <input type="submit" name="submit" value="Зарегистрироваться"> 
 </form>
 </div>
 </div>
 </div>
 </div>
