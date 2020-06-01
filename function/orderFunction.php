<?
    require_once"../connection.php";

    if($_POST['status'] == 'accept'){
        $id = $_POST['orderId'];
        $update_order = mysqli_query($db, "UPDATE orders SET status = 'в процессе' WHERE id = '$id'");

        if($update_order){
            $data = array('status' => '200');
            die( json_encode( $data ));
        }else{
            $data = array('error' => mysqli_error($db));
            die( json_encode( $data ));
        }

    }elseif($_POST['status'] == 'success'){
        $id = $_POST['orderId'];
        $update_order = mysqli_query($db, "UPDATE orders SET status = 'завершено' WHERE id = '$id'");

        if($update_order){
            $data = array('status' => '200');
            die( json_encode( $data ));
        }
        else{
            $data = array('error' => mysqli_error($db));
            die( json_encode( $data ));
        }
    }elseif($_POST['status'] == 'getCategory'){

        $categories = array();
        $razdel = $_POST['razdel'];
        $get_category = mysqli_query($db, "SELECT * FROM categories WHERE razdel = '$razdel'");
        while($category = mysqli_fetch_assoc($get_category)){
            $categories[] = $category;
        }

        $data = array('status' => 'Ok', 'categories' => $categories);
        die( json_encode( $data ) );

    }
?>