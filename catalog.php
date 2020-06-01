<?
session_start();
    require_once"connection.php";

    $categories = array();
    $razdels = array();
    $products = array();
    
    $get_razdel = mysqli_query($db, "SELECT * FROM razdel");
    while($razdel = mysqli_fetch_assoc($get_razdel)){
        $razdels[] = $razdel;
    }

    $get_categories = mysqli_query($db, "SELECT * FROM categories");
    while($category = mysqli_fetch_assoc($get_categories)){
        $categories[] = $category;
    }

    $get_product = mysqli_query($db, "SELECT * FROM product");
    while($product = mysqli_fetch_assoc($get_product)){
        $products[] = $product;
    }

    $data = array('status' => '200', 'product' => $products, 'category' => $categories, 'razdel' => $razdels); 
    die( json_encode( $data ));
    
?>