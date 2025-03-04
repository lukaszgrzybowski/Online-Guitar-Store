<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $order_change = json_decode($_POST["order_change"]);

        $new_order_status="";
        $sql="SELECT delivery_method FROM orders WHERE order_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$order_change);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $row=mysqli_fetch_assoc($result);
        if($row['delivery_method']=="Collect personally"){
            $new_order_status="collected";
        }else{
            $new_order_status="sent";
        }



        $sql="UPDATE orders SET order_status=? WHERE order_id=?";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"ss",$new_order_status,$order_change);
        mysqli_stmt_execute($stmt);


    }