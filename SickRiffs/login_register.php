<?php
    include("db.conn.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sick Riffs</title> 
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/9a5cb69b47.js" crossorigin="anonymous"></script>
    </head>
    <body class="login-register-body">

        <!-- Header/NAV -->
        <?php include('header.php');?>

        <!-- Login/Register part of site -->
    
        <div class="login-register-containaer">
            <?php 
                if(isset($_SESSION['userId'])){
            ?>
                    <div class="user_info_after_login">
                        <h1>Hello <?php echo(htmlspecialchars($_SESSION['userName']))?> !!!</h1>
                        <p>If you want to logout just click button below, see you soon!</p>
                        <div class="after-login-buttons">
                            <?php 
                             if($_SESSION['userId']==5){
                                ?>
                                <button class="login-register-submit-button" id="admin-page-id" onclick="GoAdmin()">Admin page</button>
                                <?php
                             }
                             ?>
                                <button class="login-register-submit-button" id="logout-button-id" onclick="LogOut()">Logout</button>
                        </div>
                    </div>
            <?php
                }else{
            ?>
                    <div class="register-container" id="register-container-id" onmouseover="opacityChange()">
                <form action="register_handler.php" id="register-form-id" method="POST">
                    <h1>Register</h1>
                    <h2>If you haven't done it already</h2>

                    <?php require('error_messages.php');?>

                    <label for="email">Email address:</label>
                    <input type="text" id="email_register" name="email" value="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="">
                    <label for="surname">Surname:</label>
                    <input type="text" id="surname" name="surname" value="">
                    <label for="password">Password:</label>
                    <input type="password" id="password_register" name="password" >
                    <button class="login-register-submit-button" type="submit" name="register-submit-button" id="register-submit-button-id">Register</button>
                </form>
            </div>
            <div class="login-container" id="login-container-id" onmouseover="opacityChange()">
                <form action="login_handler.php" id="login-form-id" method="POST">
                    <h1>Login</h1>
                    <h2>If you have an existing account</h2>
                    <label for="email">Email address:</label>
                    <input type="text" id="email_login" name="email">
                    <label for="password">Password:</label>
                    <input type="password" id="password_login" name="password" >
                    <button class="login-register-submit-button" type="submit" name="login-submit-button" id="login-submit-button-id">Login</button>
                </form>
            </div> 
            <?php
                }
            ?>
        </div>
    
        


        <?php include('footer.php');?>
        <script src="login-register.js"></script>
    </body>
</html>