<?php

   if(!isset($_POST['guitar_to_basket'])){
        // header("Location: ../SickRiffs/index.php");
        // exit();
   }else{
        session_start();
        require("db.conn.php");

        if(isset($_SESSION['userId'])){
            $guitar_id = json_decode($_POST['guitar_to_basket']);
            $sql="INSERT INTO baskets (basket_item_id,user_id) VALUES(?,?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt,$sql)){
                mysqli_stmt_bind_param($stmt,"ss",$guitar_id,$_SESSION['userId']);
                mysqli_stmt_execute($stmt);


                $sql = "SELECT * FROM baskets WHERE user_id=?";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt,$sql)){
                    mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    echo $resultCheck;
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
                
            }
        }else{
            if(isset($_COOKIE['guitars_to_basket'])){
                $guitars_to_add = json_decode($_COOKIE['guitars_to_basket']);
                $new_guitar_to_add = json_decode($_POST['guitar_to_basket']);
                array_push($guitars_to_add,$new_guitar_to_add);
                setcookie("guitars_to_basket",'',time() -360,'/');
                setcookie("guitars_to_basket",json_encode((array)$guitars_to_add),time() +86400,'/');
                echo sizeof($guitars_to_add);

            }else{
                $guitar_id = json_decode($_POST['guitar_to_basket']);
                $guitars_to_add= array($guitar_id);
                setcookie("guitars_to_basket",json_encode((array)$guitars_to_add),time() +86400,'/');
                echo '1';
            }
        }
   }
?>