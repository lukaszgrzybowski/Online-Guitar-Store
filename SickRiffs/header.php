
<div class="header">
    <nav class="nav-left">
        <ul class="nav-left-ul">
            <li class="categories-nav"><a href="#categories">Categories</a></li>
            <li class="deal"><a href="">Deal of the Day!</a></li>
            <li class="whoAreWe"><a href="">About Us</a></li>
        </ul>
    </nav>
    <div class="logo">
        <a href="index.php"><img src="website_resources/OIP.png"></a>
    </div>
    <nav class="nav-right">
        <div class="searchbar">
            <input class="searchbar-input" id="searchbar-input-id" type="text" placeholder="Search...">
            <button class="button-search" id="button-search-id"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <ul class="nav-right-ul">
            <li><a href="basket.php"><i class="fa-solid fa-basket-shopping" id="shopping-card"></i></a></li>
            <li><a href="login_register.php"><i class="fa-solid fa-user"></i></a></li>
            <li><i class="fa-solid fa-phone"></i></li>
        </ul>
        <div class="hamburger-menu">
            <span class="bar"></span>
            <span class="bar"></span> 
            <span class="bar"></span>    
       </div>
       <div class="basket_items_number" id="basket_items_number_id">
       <?php
            if(isset($_SESSION['userId'])){
                $sql="SELECT * FROM baskets WHERE user_id=?";
                $stmt = mysqli_stmt_init($conn);
                if(mysqli_stmt_prepare($stmt,$sql)){
                    mysqli_stmt_bind_param($stmt,"s",$_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    echo $resultCheck;
                }
            }else{
                if(isset($_COOKIE['guitars_to_basket'])){
                    $guitars_to_add = json_decode($_COOKIE['guitars_to_basket']);
                    echo sizeof((array)$guitars_to_add);
                    // print_r($guitars_to_add);
                }else{
                    echo '0';
                }
            }
        ?>
        
         </div>
    </nav>
</div>