<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $delete_value = json_decode($_POST["id_to_delete"]);
        $sql="DELETE FROM orders WHERE order_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$delete_value);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
?>