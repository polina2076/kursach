<?php
	session_start();
?>
<html>
   	<head>
	   	<title> в Кузьминках </title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- icon -->
		<link rel="shortcut icon" href="images/favicon.png" type="image/png">
		
		<!-- css -->
		<link href ="css/style.css" rel="stylesheet" type="text/css">

		<!-- Fonts -->
		<script src="https://use.fontawesome.com/306ada9451.js"></script>

		<!-- lodash js -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.3.0/lodash.js"></script>

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/themes/sunny/jquery-ui.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js"></script>

		<!-- Bootstrap -->
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		
		<style>
			.ui-widget-content {
				background: #FFE4ED !important;
			}
		</style>
	</head>
<body id="app">
    <div class="container">
        <div id="head-site">
			<a href="index.php"><img src="images/favicon.png"style="width:160px; "   title="вКузьминках" id="logo" /></a>
		
			<div class="mainmenu" style= "width: 500px;margin-right: 10px;margin-left: 0px;right: 0px;left: 100px;margin-bottom: 0px;margin-top: 0px;"> 
				<ul>
					<li><a href="index.php">О нас</a></li>
					<li><a href="lenta.php">Лента</a></li>
					<li><a href="ochki.php">Каталог</a></li>
					<li><a href="yslugi.php">Услуги</a></li>
				</ul>
			</div>
			<? if(!empty($_SESSION['login'])){ ?>
				<div class="form_header">

					<input class='logaut' name="submit" onclick="logout()" type="submit" value='Выход'>
					
					<? if($_SESSION['login'] != 'adminn'){ ?>
						<a class="btn_cart" id="btn_cart" href="./cart.php"><img src="./images/cart.svg"></a>
					<? }else{ ?>
						<a class="btn_cart" id="btn_cart" href="./cart.php"><img src="./images/admin_icon.svg"></a>
					<? } ?>
				</div>
			<? 	}else{ 	?>	
				<form class="reg">
					<p class="reg2">
						<input name ="login" type="text" id="user_login_auth" size="15" maxlength="15">
						<i class="icon-lock icon-large fa fa-user-circle-o fa-2x" aria-hidden="true"></i>
					</p>
					<p>
					<p class="reg2">
						<input name="password" type="password" id="user_password_auth" size="15" maxlength="15">
						<i class="icon-lock icon-large fa fa-unlock-alt fa-2x"></i>
					</p>
					<p>
					<p class="submit">
						<button class="btn" id="btn_auth" onclick="auth()"><i class="fa fa-home"></i></button>
						<br><br>
					</p>
					<a data-toggle="modal" data-target="#myModalAuth" href="#">Зарегестрироваться</a>
				</form>
			<?	}	?>

			<br>
			<span id="titlehead">вКузьминках</span>
        </div>
		<div class="modal fade" id="myModalAuth" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class= "modal-dialog" >
				<div class= "modal-content" >
					<div class= "modal-header"  id="headModal" >
						<span style="margin: 0 auto;">Регистрация</span>
					</div>
					<div class= "modal-body" >
						<form class="modalForm" id="formReg" v-else-if="formStatus==false">
							<input type="text" name="Name" id="user_name" required placeholder="Имя"><br>
							<input type="text" name="Surname" id="user_surname" required placeholder="Фамилия"><br>	
							<input type="text" name="telephone" id="user_phone" required placeholder="Телефон"><br>
							<input type="text" name="login" id="user_login_reg" required placeholder="Логин"><br>
							<input type="password" name="password" id="user_password_reg" required placeholder="Пароль"><br>
							<input id="btn_reg" onclick="reg()" type="submit" name="submit" value="Зарегистрироваться"> 
						</form>
 					</div>
 				</div>
 			</div>
		 </div>
		 <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="errorModalLabel">Ошибка</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modal_error_body">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
					<button type="button" class="btn btn-primary" data-dismiss="modal">ок</button>
				</div>
				</div>
			</div>
		</div>
<script>
	function reg(){

		event.stopPropagation(); 
		event.preventDefault(); 

		// создадим объект данных формы
		var data = new FormData();

		// добавим переменную для идентификации запроса
		var name = $('#user_name').val();
		var surname = $('#user_surname').val();
		var phone = $('#user_phone').val();
		var login = $('#user_login_reg').val();
		var password = $('#user_password_reg').val();
		data.append('name', name);
		data.append('surname', surname);
		data.append('phone', phone);
		data.append('login', login);
		data.append('password', password);

		// AJAX запрос
		$.ajax({
			url         : './reg.php',
			type        : 'POST',
			data        : data,
			cache       : false,
			dataType    : 'json',
			// отключаем обработку передаваемых данных, пусть передаются как есть
			processData : false,
			// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
			contentType : false, 
			// функция успешного ответа сервера
			success     : function( respond, status, jqXHR ){
				// ОК - файлы загружены
				if( typeof respond.error === 'undefined' ){
					$('#myModalAuth').modal('hide');
				}
				// ошибка
				else {
					document.getElementById('modal_error_body').innerText = respond.error; 
					$('#errorModal').modal('show');
					console.log(respond.error);
				}
			},
			// функция ошибки ответа сервера
			error: function( jqXHR, status, errorThrown ){
				console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
			}
		});
	};

	function auth(){

		event.stopPropagation(); 
		event.preventDefault(); 

		// создадим объект данных формы
		var data = new FormData();

		// добавим переменную для идентификации запроса
		
		var login = $('#user_login_auth').val();
		var password = $('#user_password_auth').val();
		
		data.append('login', login);
		data.append('password', password);

		// AJAX запрос
		$.ajax({
			url         : './auth.php',
			type        : 'POST',
			data        : data,
			cache       : false,
			dataType    : 'json',
			// отключаем обработку передаваемых данных, пусть передаются как есть
			processData : false,
			// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
			contentType : false, 
			// функция успешного ответа сервера
			success     : function( respond, status, jqXHR ){
				// ОК - файлы загружены
				if( typeof respond.error === 'undefined' ){
					
					console.log('Auth success');
					location.reload();
				}
				// ошибка
				else {
					document.getElementById('modal_error_body').innerText = respond.error; 
					$('#errorModal').modal('show');
					console.log(respond.error);
				}
			},
			// функция ошибки ответа сервера
			error: function( jqXHR, status, errorThrown ){
				console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
			}
		});
	};

	function logout(){
		event.stopPropagation(); 
		event.preventDefault(); 

		var data = new FormData();

		data.append('status', 'logaut');

		// AJAX запрос
		$.ajax({
			url         : './logaut.php',
			type        : 'POST',
			data		: data,
			cache       : false,
			dataType    : 'json',
			// отключаем обработку передаваемых данных, пусть передаются как есть
			processData : false,
			// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
			contentType : false, 
			// функция успешного ответа сервера
			success     : function( respond, status, jqXHR ){
				// ОК - файлы загружены
				if( typeof respond.error === 'undefined' ){
					
					console.log('success');
					location.reload();
					
				}
				// ошибка
				else {
					document.getElementById('modal_error_body').innerText = respond.error; 
					$('#errorModal').modal('show');
					console.log(respond.error);
				}
			},
			// функция ошибки ответа сервера
			error: function( jqXHR, status, errorThrown ){
				console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
			}
		});
	}
</script>
