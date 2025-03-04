<?php
    require("db.conn.php");
    session_start();
    $empty_basket=0;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sick Riffs</title> 
        <link rel="stylesheet" href="style.css?v=<?php echo time();?>">
        <script src="https://kit.fontawesome.com/9a5cb69b47.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <!-- Header/NAV -->
        <?php include('header.php');?>
        <div class="basket_container">
            <div class="basket_window" id="basket_window_id">
            <div class="checkout_title">
                        <h1>Shopping Card</h1>
                    </div>
                <?php

                if(isset($_GET['order'])){
                    if($_GET['order']=='success'){
                        $empty_basket=1;
                        ?>
                            <div class="empty_basket_message">
                                <p>Congrats on your new purchase</p>
                            </div>
                        <?php
                    }
                }else{
                    if(isset($_SESSION['userId'])){
                        $sql = "SELECT guitar_id,guitar_name,brand_name,img_dir_guitars,price,basket_item_id,user_id,basket_position FROM
                        guitars INNER JOIN baskets ON guitars.guitar_id=baskets.basket_item_id 
                        INNER JOIN brands ON guitars.brand=brands.brand_id WHERE user_id=?";

                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/basket.php?error=sqlerror");
                            exit();
                        }
                        mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $num_check=0;
                        $price=0;
                        while($row=mysqli_fetch_assoc($result)){
                            $num_check+=1;
                            $price+=$row["price"];
                            ?>
                            <div class="basket_item">
                                <img src="<?php echo htmlspecialchars($row["img_dir_guitars"]);?>">
                                <p class="basket_item_brand"><?php echo htmlspecialchars($row["brand_name"]);?></p>
                                <p class="basket_item_name"><?php echo htmlspecialchars($row["guitar_name"]);?></p>
                                <p class="basket_item_price"><?php echo htmlspecialchars($row["price"]);?>$</p>
                                <div class="delete_basket_button">
                                <button class="delete_guitar_button" id="<?php echo htmlspecialchars($row["guitar_id"]);?>" onClick="delete_guitar_form(this.id)">Delete</button>
                                </div>
                            </div>
                            <?php
                        }
                        if($num_check!=0){
                            ?>
                                <div class="total_price_container">
                                    <p>Total price: <?php echo htmlspecialchars($price);?>$</p>
                                </div>
                            <?php
                        }else{
                            $empty_basket=1;
                            ?>
                            <div class="empty_basket_message">
                                <p>Your shopping card is empty</p>
                            </div>
                        <?php 
                        }

                    }
                    else{
                        if(isset($_COOKIE['guitars_to_basket'])){
                            $guitars_to_basket=json_decode($_COOKIE['guitars_to_basket']);
                            $price=0;
                            foreach($guitars_to_basket as $guitar){
                                $sql = "SELECT guitar_id,guitar_name,brand_name,img_dir_guitars,price FROM
                                guitars INNER JOIN brands ON guitars.brand=brands.brand_id WHERE guitar_id=?";

                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/basket.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_bind_param($stmt,"s",$guitar);
                                mysqli_stmt_execute($stmt);
                                $result_cookie = mysqli_stmt_get_result($stmt);
                                if($result_cookie){
                                    $row=mysqli_fetch_assoc($result_cookie);
                                    $price+=$row["price"];
                                    ?>
                                        <div class="basket_item">
                                            <img src="<?php echo htmlspecialchars($row["img_dir_guitars"]);?>">
                                            <p class="basket_item_brand"><?php echo htmlspecialchars($row["brand_name"]);?></p>
                                            <p class="basket_item_name"><?php echo htmlspecialchars($row["guitar_name"]);?></p>
                                            <p class="basket_item_price"><?php echo htmlspecialchars($row["price"]);?>$</p>
                                            <div class="delete_basket_button">
                                            <button class="delete_guitar_button" id="<?php echo htmlspecialchars($row["guitar_id"]);?>" onClick="delete_guitar_form(this.id)">Delete</button>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="total_price_container">
                                <p>Total price: <?php echo htmlspecialchars($price);?>$</p>
                            </div>
                            <?php
                            
                        }else{
                            $empty_basket=1;
                            ?>
                            <div class="empty_basket_message">
                                <p>Your shopping card is empty</p>
                            </div>
                        <?php 
                        }
                    }
                }
                    


                ?>
            </div>

            <?php
            if($empty_basket==0){
            ?>
                <form id="hidden_one" method="POST" style="display:none;">
                    <input type="hidden" id="hidden_id" name="hidden_id" required>
                </form>
                <form action="checkout.php" class="purchasing_form" id="purchasing_form_id" method="POST">
                    <div class="checkout_title">
                        <h1>Checkout</h1>
                    </div>
                    <div class="form_containers">
                        <div class="purchasing_container1">
                            <h2>Fill in checkout informations</h2>
                            <?php
                            if(isset($_GET['error'])){
                            ?>
                            <p class="errormessage">You have incorrect <?php echo htmlspecialchars($_GET['error']); ?>, please correct it before moving forward!</p>
                            <?php
                            }
                            ?>
                            <label for="email">Email address:</label>
                            <input type="text" id="email" name="email" value="<?php if(isset($_GET['email'])){ echo htmlspecialchars($_GET['email']); }?>">

                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name" value="<?php if(isset($_GET['name'])){ echo htmlspecialchars($_GET['name']); }?>">

                            <label for="surname">Surname:</label>
                            <input type="text" id="surname" name="surname" value="<?php if(isset($_GET['surname'])){ echo htmlspecialchars($_GET['surname']); }?>">

                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" value="<?php if(isset($_GET['city'])){ echo htmlspecialchars($_GET['city']); }?>">

                            <label for="streetname">Street name:</label>
                            <input type="text" id="streetname" name="streetname" value="<?php if(isset($_GET['streetname'])){ echo htmlspecialchars($_GET['streetname']); }?>">

                            <label for="homenumber">Home number:</label>
                            <input type="text" id="homenumber" name="homenumber" value="<?php if(isset($_GET['homenumber'])){ echo htmlspecialchars($_GET['homenumber']); }?>">

                            <label for="phonenumber">Phone number:</label>
                            <input type="text" id="phonenumber" name="phonenumber" value="<?php if(isset($_GET['phonenumber'])){ echo htmlspecialchars($_GET['phonenumber']); }?>">

                        </div>
                        <div class="purchasing_container2">
                            <h2>Payment option</h2>
                            <div class="radio_form">
                                <input type="radio" id="" name="paymentradio" value="Blik"><label for="paymentoption1">BLIK</label></br>
                                <input type="radio" id="" name="paymentradio" value="Payment while delivered"><label for="paymentoption2">Payment while delivered</label></br>
                                <input type="radio" id="" name="paymentradio" value="PayU"><label for="paymentoption3">PayU</label>
                            </div>
                            <h2>Delivery method</h2>
                            <div class="radio_form">
                                <input type="radio" id="" name="deliveryradio" value="Collect personally"><label for="deliveryoption1">Collect personally +0$</label></br>
                                <input type="radio" id="" name="deliveryradio" value="UPS"><label for="deliveryoption2">UPS +5$</label></br>
                                <input type="radio" id="" name="deliveryradio" value="Sending by post"><label for="deliveryoption3">Sending by post +3$</label>
                            </div>
                        </div>
                    </div>
                    <button class="purchase_button" type="submit" name="checkout_form_submit" id="checkout_form_submit_id">Purchase</button>
                </form>
            <?php
            }
            ?>
        </div>

        <!-- Footer -->
        <?php include('footer.php');?>
        <script src="basket.js"></script>
    </body>
</html>