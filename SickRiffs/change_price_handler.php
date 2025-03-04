<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $guitar = json_decode($_POST["guitar"]);

        $sql="UPDATE guitars SET price=? WHERE guitar_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"ss",$guitar[1],$guitar[0]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
    }