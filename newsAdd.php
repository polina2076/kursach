<?php
    require_once "connection.php";

    if(isset($_POST['name'])){
        $name = $_POST['name'];
    }

    if(isset($_POST['value'])){
        $value = $_POST['value'];
    }
    
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }

    $img = '';
    $uploaddir = './images';
    $files = $_FILES;
    foreach( $files as $file ){
        $img = $file['name'];
        
        if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$img" ) ){
			$done_files[] = realpath( "$uploaddir/$img" );
		}
    }

    $query = mysqli_query($db,"INSERT INTO news(name,value,date,img) 
        values('$name','$value','$date','$uploaddir/$img')");

    $data = $query ? array('files' => $done_files ) : array('error' => mysqli_error($db)); 


	die( json_encode( $data ) );
?>