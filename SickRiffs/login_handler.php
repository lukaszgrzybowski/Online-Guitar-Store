<?php

    if(isset($_POST["login-submit-button"])){

        require 'db.conn.php';

        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email) || empty($password)){
            header("Location: ../SickRiffs/login_register.php?error=emptyfields");
            exit();
        }
        else{
            $sql = "SELECT * FROM users WHERE email=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/login_register.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"s",$email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $passwordCheck=password_verify($password,$row['password']);
                    if($passwordCheck == false){
                        header("Location: ../SickRiffs/login_register.php?error=wrongpassword");
                        exit(); 
                    }else if($passwordCheck==true){
                        session_start();
                        $_SESSION['userId']=$row['user_id'];
                        $_SESSION['userName']=$row['name'];
                        $_SESSION['userSuranme']=$row['surname'];
                        $_SESSION['userEmail']=$row['email'];

                        if(isset($_COOKIE['guitars_to_basket'])){
                            $sql="INSERT INTO baskets (basket_item_id,user_id) VALUES(?,?)";
                            $guitars_from_cookies = json_decode($_COOKIE['guitars_to_basket']);
                            if(gettype($guitars_from_cookies) !='array'){
                                $guitars_from_cookies = get_object_vars($guitars_from_cookies);
                            }
                            foreach($guitars_from_cookies as $guitar){
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/login_register.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_bind_param($stmt,"ss",$guitar,$row['user_id']);
                                mysqli_stmt_execute($stmt);
                            }

                        }
                        setcookie("guitars_to_basket",'',time() -360,'/');

                        header("Location: ../SickRiffs/login_register.php?login=sucess");
                        exit(); 
                        
                    }
                }else{
                    
                    header("Location: ../SickRiffs/login_register.php?error=nouserwiththisemail");
                    exit();
                }
            }

        }
        


    }else{
        header("Location: ../SickRiffs/login_register.php");
        exit(); 
    }