<?php
	require_once"header.php";
	require_once"connection.php";
	
?>
 
<div id="content">
<div class="ochki">
<div class="container">
        <div class="row ver">
            <h1 class="col-12"></h1>
            <ul class="col-12 nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="vce.php">Все очки</a>
                </li>
			   <li class="nav-item">
                    <a class="nav-link active" href="filtM.php">Мужские</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="filt.php">Женские</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="filtD.php">Детские</a>
                </li>
            </ul>
        </div>
    </div>
<?


if(isset($_SESSION['products'])){
	$status = $_SESSION['products'];
   $query = mysqli_query($db,"SELECT * FROM product where category_id='$status'");
	
}else{
	$query = mysqli_query($db,"SELECT * FROM product");
    
}

?>
<div id="content" class="container">
<div class="row" style="min-height: 100vh; margin-top:30px;">
<div class="col-12 row">
<?
while($result = mysqli_fetch_array($query)){?>
<div class='col-3 proguct'>
<img src='<? echo($result['img'])?>' class='productImg'>
<div class='productDes'>
<h3><? echo($result['Price'])?> руб.</h3>

<hr>
<input type='submit' class="btn btn-info" value='добавить в корзину'>
</div>
</div>
<?}?>
</div>
</div>
</div> 
	
	</div>
</div>

<?php
	require_once"footer.php";
?>