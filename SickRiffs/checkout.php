<?php
    if(isset($_POST["checkout_form_submit"])){
        require 'db.conn.php';
        session_start();

        $email = $_POST['email'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $city = $_POST['city'];
        $streetname = $_POST['streetname'];
        $homenumber = $_POST['homenumber'];
        $phonenumber = $_POST['phonenumber'];
        $paymentoption = $_POST['paymentradio'];
        $deliverymethod = $_POST['deliveryradio'];

        $empty_fields_message = "Location: ../SickRiffs/basket.php?error=emptyfields";

        if(!empty($email)){
            $empty_fields_message = $empty_fields_message."&email=".$email;
        }
        if(!empty($name)){
            $empty_fields_message = $empty_fields_message."&name=".$name;
        }
        if(!empty($surname)){
            $empty_fields_message = $empty_fields_message."&surname=".$surname;
        }
        if(!empty($city)){
            $empty_fields_message = $empty_fields_message."&city=".$city;
        }
        if(!empty($streetname)){
            $empty_fields_message = $empty_fields_message."&streetname=".$streetname;
        }
        if(!empty($homenumber)){
            $empty_fields_message = $empty_fields_message."&homenumber=".$homenumber;
        }
        if(!empty($phonenumber)){
            $empty_fields_message = $empty_fields_message."&phonenumber=".$phonenumber;
        }
        if(!empty($paymentoption)){
            $empty_fields_message = $empty_fields_message."&paymentoption=".$paymentoption;
        }
        if(!empty($deliverymethod)){
            $empty_fields_message = $empty_fields_message."&deliverymethod=".$deliverymethod;
        }

        if(empty($email) || empty($name) || empty($surname) || empty($city) || empty($streetname) || empty($homenumber) || empty($phonenumber) || empty($deliverymethod) || empty($paymentoption)){
            header($empty_fields_message);
            exit();
        }

        $incorrect_fields = "Location: ../SickRiffs/basket.php?error=incorrect_fields";
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $incorrect_fields = $incorrect_fields."&email".$email;
        }
        if(preg_match("/^[a-zA-Z]*$/",$name)){
            $incorrect_fields = $incorrect_fields."&name".$name;
        }
        if(preg_match("/^[a-zA-Z]*$/",$surname)){
            $incorrect_fields = $incorrect_fields."&surname".$surname;
        }
        if(preg_match("/^[a-zA-Z0-9]*$/",$streetname)){
            $incorrect_fields = $incorrect_fields."&streetname".$streetname;
        }
        if(preg_match("/^[a-zA-Z]*$/",$city)){
            $incorrect_fields = $incorrect_fields."&city".$city;
        }
        if(preg_match("/^[0-9\.\/]*$/",$homenumber)){
            $incorrect_fields = $incorrect_fields."&homenumber".$homenumber;  
        }
        if(preg_match("/^[0-9]*$/",$phonenumber)){
            $incorrect_fields = $incorrect_fields."&phonenumber".$phonenumber;
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL) || !preg_match("/^[a-zA-Z]*$/",$name) || !preg_match("/^[a-zA-Z]*$/",$surname) || !preg_match("/^[a-zA-Z0-9]*$/",$streetname) || !preg_match("/^[a-zA-Z]*$/",$city) || !preg_match("/^[0-9\.\/]*$/",$homenumber) || !preg_match("/^[0-9]*$/",$phonenumber)){
            header($incorrect_fields);
            exit();
        }

        $order_status="pending";
        $guitars_from_basket ="";
        $userstatus="";

        if(isset($_COOKIE['guitars_to_basket'])){
            $userstatus = "guest";
            $guitars_from_basket = json_decode($_COOKIE['guitars_to_basket']);
            setcookie("guitars_to_basket",'',time() -360,'/');


        }else if(isset($_SESSION['userId'])){
            $sql ="SELECT basket_item_id FROM baskets WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/basket.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $guitars_from_basket = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($guitars_from_basket,$row['basket_item_id']);
            }

            $sql = "SELECT user_status FROM users WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/basket.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $userstatus= $row['user_status'];



            $sql = "DELETE FROM baskets WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/basket.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
            mysqli_stmt_execute($stmt);




            $sql = "SELECT user_status FROM users WHERE user_id=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/basket.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $userstatus= $row['user_status'];


            mysqli_stmt_close($stmt);
        }

        $json_guitars = json_encode($guitars_from_basket);


        $sql="INSERT INTO orders (email,name,surname,city,street_name,home_number,phone_number,payment_method,delivery_method,order_status,user_status,user_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/basket.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"ssssssssssss",$email,$name,$surname,$city,$streetname,$homenumber,$phonenumber,$paymentoption,$deliverymethod,$order_status,$userstatus,$json_guitars);
        mysqli_stmt_execute($stmt);
         header("Location: ../SickRiffs/basket.php?order=success");
        exit();


    }