<?php

    if(isset($_POST["register-submit-button"])){
        
        
        require 'db.conn.php';

        $email = $_POST['email'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $password = $_POST['password'];

        if(empty($email) || empty($name) || empty($surname) || empty($password)){
            header("Location: ../SickRiffs/login_register.php?error=emptyfields&name=".$name."&surname=".$surname."&email=".$email);
            exit();
        }
        else if (!filter_var($email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/",$name) && !preg_match("/^[a-zA-Z]*$/",$surname)){
            header("Location: ../SickRiffs/login_register.php?error=invalidmailnamesurname");
            exit();
        }
        else if (!filter_var($email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/",$name)){
            header("Location: ../SickRiffs/login_register.php?error=invalidmailname&surname=".$surname);
            exit();
        }
        else if (!filter_var($email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z]*$/",$surname)){
            header("Location: ../SickRiffs/login_register.php?error=invalidmailsurname&name=".$name);
            exit();
        }
        else if (!preg_match("/^[a-zA-Z]*$/",$name) && !preg_match("/^[a-zA-Z]*$/",$surname)){
            header("Location: ../SickRiffs/login_register.php?error=invalidnamesurname&email=".$email);
            exit();
        }
        else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            header("Location: ../SickRiffs/login_register.php?error=invalidmail&name=".$name."&surname=".$surname);
            exit();
        }
        else if (!preg_match("/^[a-zA-Z]*$/",$name)){
            header("Location: ../SickRiffs/login_register.php?error=invalidiname&surname=".$surname."&email=".$email);
            exit();
        }
        else if (!preg_match("/^[a-zA-Z]*$/",$surname)){
            header("Location: ../SickRiffs/login_register.php?error=invalidisurname&name=".$name."&email=".$email);
            exit();
        }
        else{
            $sql="SELECT email FROM users WHERE email=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/login_register.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"s",$email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if($resultCheck>0){
                    header("Location: ../SickRiffs/login_register.php?error=useralreadyexists");
                    exit(); 
                }
                else{
                    $sql="INSERT INTO users (name,surname,email,password,user_status) VALUES (?,?,?,?,?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt,$sql)){
                        header("Location: ../SickRiffs/login_register.php?error=sqlerror");
                        exit();
                    }
                    else{
                        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
                        $user_status = "logged_user";

                        mysqli_stmt_bind_param($stmt,"sssss",$name,$surname,$email,$hashedPassword,$user_status);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../SickRiffs/login_register.php?signup=success");
                        exit();
                    }
                }
            }
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

    }
    else{
        header("Location: ../SickRiffs/login_register.php");
        exit(); 
    }