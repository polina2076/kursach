<?php
    require_once"connection.php";


    if(isset($_POST['name'])){
        $name = $_POST['name'];
    }

    if(isset($_POST['description'])){
        $description = $_POST['description'];
    }
    
    if(isset($_POST['price'])){
        $price = $_POST['price'];
    }

    if(isset($_POST['razdel'])){
        $razdel = $_POST['razdel'];    
    }

    if(isset($_POST['category'])){
        $category = $_POST['category'];    
    }

    $img = '';
    $uploaddir = './images';
    $files = $_FILES;
    foreach( $files as $file ){
        $img = $file['name'];
        
        if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$img")){
			$done_files[] = realpath( "$uploaddir/$img" );
		}
    }

    $query = mysqli_query($db,"INSERT INTO product(Name,Description,Price,img,razdel,category)
        values('$name','$description','$price','$uploaddir/$img', '$razdel', '$category')");

    $data = $query ? array('status' => '200' ) : array('error' => mysqli_error($db)); 

	die( json_encode( $data ) );
?>