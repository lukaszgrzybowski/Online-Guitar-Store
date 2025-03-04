<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $guitar_id = json_decode($_POST["guitar_id"]);

        $sql="SELECT deal_of_the_day FROM guitars WHERE guitar_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$guitar_id);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if($result->num_rows!=1){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        $row=mysqli_fetch_assoc($result);

        if($row['deal_of_the_day']==1){
            $new_dotd_value = 0;
            $sql="UPDATE guitars SET deal_of_the_day=? WHERE guitar_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"ss",$new_dotd_value,$guitar_id);
            mysqli_stmt_execute($stmt);
        }else{
            $new_dotd_value = 1;
            $sql="UPDATE guitars SET deal_of_the_day=? WHERE guitar_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"ss",$new_dotd_value,$guitar_id);
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }