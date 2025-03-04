<?php
        if(isset($_POST['delete_from_basket'])){
            session_start();
            require('db.conn.php');
            if(isset($_SESSION['userId'])){
                $guitar_id=json_decode($_POST['delete_from_basket']);
                $guitar_to_delete = json_decode($_POST['delete_from_basket']);
                print_r($_POST['delete_from_basket']);
                print_r($_SESSION['userId']);
                $sql="DELETE FROM baskets WHERE basket_item_id=? AND user_id=?";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt,$sql)){
                    mysqli_stmt_bind_param($stmt,"ss",$guitar_id,$_SESSION['userId']);
                    if(mysqli_stmt_execute($stmt)){
                        print_r("done");
                    }else{
                        print_r("failed");
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }

            }
            elseif(isset($_COOKIE['guitars_to_basket'])){
                $guitar_to_delete = json_decode($_POST['delete_from_basket']);
                $guitars_in_basket = json_decode($_COOKIE['guitars_to_basket']);
                if(gettype($guitars_in_basket) !='array'){
                    $guitars_in_basket = get_object_vars($guitars_in_basket);
                }
                if(($key=array_search($guitar_to_delete,$guitars_in_basket))!==false){
                    unset($guitars_in_basket[$key]);
                    if(sizeof($guitars_in_basket)==0){
                        setcookie("guitars_to_basket",'',time() -360,'/');
                    }else{
                        setcookie("guitars_to_basket",'',time() -360,'/');
                        setcookie("guitars_to_basket",json_encode((array)$guitars_in_basket),time() +86400,'/');
                    }
                }
            }
        }