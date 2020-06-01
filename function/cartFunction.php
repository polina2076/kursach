<?
    session_start();
    require_once"../connection.php";
    $user = $_SESSION['id_user'];

    if(!empty($_POST['delId'])){

        $get_cart = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user'");
        $cart = mysqli_fetch_array($get_cart);
        $products_array = explode("|", $cart['products']);
        for($i = 0; $i < count($products_array); $i++){
            if($products_array[$i] == $_POST['delId']){
                unset($products_array[$i]);
            }
        }

        $idproduct = $_POST['delId'];
        $get_product = mysqli_query($db, "SELECT Price FROM product WHERE id = '$idproduct'");
        $product = mysqli_fetch_array($get_product);

        $products_string = implode('|', $products_array);

        $delete = mysqli_query($db, "UPDATE cart SET products = '$products_string'");

        if($delete){
            $data = $delete ? array('productId' => $_POST['delId'], 'priceproduct' => $product['Price'] ) : array('error' => mysqli_error($db)); 
	        die( json_encode( $data ));
        }

    }elseif(!empty($_POST['acceptOrder'])){
        $date = $_POST['orderDate'];
        $pay = $_POST['orderPay'];
        $sum = (int)$_POST['orderSum'];

        $get_cart = mysqli_query($db, "SELECT * FROM cart WHERE user_id = '$user'");
        $cart = mysqli_fetch_array($get_cart);
        $products = $cart['products'];

        $get_user = mysqli_query($db, "SELECT * FROM user WHERE id = '$user'");
        $userArray = mysqli_fetch_array($get_user);

        $user_name = $userArray['Name'].' '.$userArray['Surname'];
        $phone = $userArray['telephone'];

        $query = mysqli_query($db, "INSERT INTO orders(user,products,sum,date,pay,phone,status) 
        values ('$user_name','$products','$sum','$date', '$pay', '$phone', 'ожидается')");

        if($query){
            $cart_id = $cart['id'];
            $del_cart = mysqli_query($db, "DELETE FROM cart WHERE id = '$cart_id'");
            if($del_cart){
                $data = array('status' => 'Ok');
                die( json_encode( $data ) );
            }else{
                $data = array('error' => mysqli_error($db));
                die( json_encode( $data ));
            }
        }else{
            $data = array('error' => mysqli_error($db));
            die( json_encode( $data ) );
        }
    }
?>