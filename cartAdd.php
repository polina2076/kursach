<?php
    require_once "connection.php";
    session_start();

    if(empty($_SESSION['login'])){

        $data = array('error' => 'Вы не авторизованы.');
        die(json_encode($data));

    }elseif($_SESSION['login'] == 'adminn'){
        $data = array('error' => 'Администратор не может добавить товар в корзину.');
        die(json_encode($data));
    }

    if(isset($_POST['id'])){
        $product_id = (int)$_POST['id'];
    }

    $user_id = $_SESSION['id_user'];

    if($user_id == ''){
        $data = array('error' => 'Вы не авторизированы.'); 
	    die( json_encode( $data ));
    }

    $get_product = mysqli_query($db, "SELECT * FROM product WHERE id = '$product_id'");

    $get_cart_user = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user_id'");
    $cart = mysqli_fetch_array($get_cart_user);

    while($products = mysqli_fetch_array($get_product)){
        if($cart['id'] != ''){
            $product = (string)$cart['products']."|".(string)$products['id'];
        }else{
            $product = (string)$products['id'];
        }
    }

    if($product == ''){ 
        $data = array('error' => 'продукт не получен'); 
	    die( json_encode( $data ));
    }

    if($cart['id'] != ''){
        $query = mysqli_query($db,"UPDATE cart SET products = '$product'");
    }else{
        $query = mysqli_query($db,"INSERT INTO cart(products, user_id) VALUES('$product','$user_id')");
    }

    $data = $query ? array('status' => 'ok' ) : array('error' => mysqli_error($db)); 

	die( json_encode( $data ) );
?>