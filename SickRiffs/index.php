<?php
    include("db.conn.php");
    session_start();
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
     

        <!-- HERO/SLIDER -->
        <div class="slider">
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1">
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                <div class="slide first" id="slide1">
                    <div class="col-2">
                        <h1>Give Yourself The Power!</h1>
                        <p>Check out new Ibanez Axion Label. Tame the mighty CHUG!<br>And let the slaughter begin...</p>
                        <a href="" class="slider-btn">SHRED NOW!</a>
                    </div>
                    <div class="col-3">
                        <img src="website_resources/rg.jpg">
                    </div>
                </div>
                <div class="slide" id="slide2">
                    <div class="img1">
                        <img src="website_resources/background1.jpg">
                    <div class="slider2-text">
                        <h1>Subscribe to Newsletter for HUGE discount !!!</h1>
                        <p>After you subscribe to newsletter you get 10% discount for your first purtchase and we will notify you on all amazing news!</p>
                    </div>
                    </div>
                </div>
                <div class="slide" id="slide3">
                    <div class="img1">
                        <img src="website_resources/background2.jpg">
                        <div class="slider3-text">
                            <h1>New RGD Models are coming!</h1>
                            <h3>Winter, This Year, Brace Yoursef!</h3>
                        </div>   
                    </div>
                </div>
                <div class="navigation-auto">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                </div>
            </div>
            <div class="navigation-manual">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
            </div>
        </div>


        <!---Categories-->

        <div class="categories" id="categories">
            <h1 class="catTitle">Categories</h1>
            <div class="categories_available">
                <?php
                    $sql = "SELECT * FROM categories;";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)>0){
                        while($selected_category=mysqli_fetch_assoc($result)){
                ?>          
                            <button class="selected_category_button"  id="selected_cat_<?php echo htmlspecialchars($selected_category['category_id']);?>">
                            <a href="#ShowAllGuitarsContainerID">
                            <div class="selected_category">
                                <img src="<?php echo htmlspecialchars($selected_category['img_dir']);?>">
                                <p class="selected_cat_title"><?php echo htmlspecialchars($selected_category['category_name']);?></p>
                            </div>
                            </a>
                            </button>
                <?php
                        }
                    }else{
                        ?>
                        <p class="no_cat_available">No categories available</p>
                        <?php
                    }
                
                ?>
            </div>
            <div class="filters_buttons">
                <button class="showAllGuitarsButton" id="showAllGuitarsButtonId">Show All Guitars</button>
                <button class="additional_filters_button" id="additional_filters_button_id">Additional Filters<i class="fa-solid fa-arrow-down"></i></button>
            </div>
            <div class="additional_filters">
                
            </div>
        </div>

        <!-- Show All Guitars -->

        <div class="ShowAllGuitarsContainer" id="ShowAllGuitarsContainerID">
            <div class="go_back">
            <a href="#categories" style="text-decoration: none;"><button class="go_back_button" id="go_back_button_id"><i class="fa-solid fa-xmark"></i>Close</button></a>
            </div>
            <div class="filtration_and_guitars">
                <div class="filtration" id="filtrationID">
                    <p>What do you like ?</p>
                    <form id="formID" method="POST">
                        <!-- <label for="Price">Price:</label>
                        <input type="range" id="price_input" name="price" min="0" max="4000"/></br> -->

                        <label class="labels_in_filtration" for="Guitar Type">Category</lablel></br>

                            <?php
                            $sql = "SELECT * FROM categories;";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0){
                                while($selected_category=mysqli_fetch_assoc($result)){
                            ?>          

                                    <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['category_name']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['category_name']));?>" value="<?php echo htmlspecialchars($selected_category['category_name']);?>">
                                    <label for="<?php echo htmlspecialchars($selected_category['category_name']);?>"><?php echo htmlspecialchars($selected_category['category_name']);?></lablel></br>

                                    
                            <?php
                                    }
                                }else{
                                    ?>
                                    <p class="no_cat_available_filtration">No categories available</p>
                                    <?php
                                }
                        
                            ?>

                        <label class="labels_in_filtration" for="Brand">Brand</lablel></br>

                            <?php
                            $sql = "SELECT * FROM brands;";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0){
                                while($selected_category=mysqli_fetch_assoc($result)){
                            ?>          

                                    <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['brand_name']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['brand_name']));?>" value="<?php echo htmlspecialchars($selected_category['brand_name']);?>">
                                    <label for="<?php echo htmlspecialchars($selected_category['brand_name']);?>"><?php echo htmlspecialchars($selected_category['brand_name']);?></lablel></br>

                                    
                            <?php
                                    }
                                }else{
                                    ?>
                                    <p class="no_car_available_filtration">No categories available</p>
                                    <?php
                                }
                        
                            ?>

                        <label class="labels_in_filtration" for="Strings number">Strings number</lablel></br>

                            <?php
                            $sql = "SELECT * FROM strings_number;";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0){
                                while($selected_category=mysqli_fetch_assoc($result)){
                            ?>          

                                    <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['number']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['number']));?>" value="<?php echo htmlspecialchars($selected_category['number']);?>">
                                    <label for="<?php echo htmlspecialchars($selected_category['number']);?>"><?php echo htmlspecialchars($selected_category['number']);?></lablel></br>

                                    
                            <?php
                                    }
                                }else{
                                    ?>
                                    <p class="no_car_available_filtration">No categories available</p>
                                    <?php
                                }
                        
                            ?>

                        <label class="labels_in_filtration" for="Body style">Body style</lablel></br>

                            <?php
                            $sql = "SELECT * FROM body_styles;";
                            $result = mysqli_query($conn,$sql);
                            if(mysqli_num_rows($result)>0){
                                while($selected_category=mysqli_fetch_assoc($result)){
                            ?>          

                                    <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['body_style_name']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['body_style_name']));?>" value="<?php echo htmlspecialchars($selected_category['body_style_name']);?>">
                                    <label for="<?php echo htmlspecialchars($selected_category['body_style_name']);?>"><?php echo htmlspecialchars($selected_category['body_style_name']);?></lablel></br>

                                    
                            <?php
                                    }
                                }else{
                                    ?>
                                    <p class="no_car_available_filtration">No categories available</p>
                                    <?php
                                }
                        
                            ?>

                        <label class="labels_in_filtration" for="Bridge type">Bridge type</lablel></br>

                            <?php
                                $sql = "SELECT * FROM bridge_types;";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0){
                                    while($selected_category=mysqli_fetch_assoc($result)){
                                ?>          

                                        <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['bridge_type_name']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['bridge_type_name']));?>" value="<?php echo htmlspecialchars($selected_category['bridge_type_name']);?>">
                                        <label for="<?php echo htmlspecialchars($selected_category['bridge_type_name']);?>"><?php echo htmlspecialchars($selected_category['bridge_type_name']);?></lablel></br>

                                        
                                <?php
                                        }
                                    }else{
                                        ?>
                                        <p class="no_car_available_filtration">No categories available</p>
                                        <?php
                                    }
                            
                                ?>

                        <label class="labels_in_filtration" for="Pickup selection">Pickup selection</lablel></br>

                            <?php
                                $sql = "SELECT * FROM pickup_selections;";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0){
                                    while($selected_category=mysqli_fetch_assoc($result)){
                                ?>          

                                        <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['pickup_selection_name']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['pickup_selection_name']));?>" value="<?php echo htmlspecialchars($selected_category['pickup_selection_name']);?>">
                                        <label for="<?php echo htmlspecialchars($selected_category['pickup_selection_name']);?>"><?php echo htmlspecialchars($selected_category['pickup_selection_name']);?></lablel></br>

                                        
                                <?php
                                        }
                                    }else{
                                        ?>
                                        <p class="no_car_available_filtration">No categories available</p>
                                        <?php
                                    }
                            
                                ?>

                        <label class="labels_in_filtration" for="Production">Production</lablel></br>

                            <?php
                                $sql = "SELECT * FROM productions;";
                                $result = mysqli_query($conn,$sql);
                                if(mysqli_num_rows($result)>0){
                                    while($selected_category=mysqli_fetch_assoc($result)){
                                ?>          

                                        <input type="radio" id="<?php echo str_replace(' ','',htmlspecialchars($selected_category['production_name']));?>Radio" name="<?php echo str_replace(' ','',htmlspecialchars($selected_category['production_name']));?>" value="<?php echo htmlspecialchars($selected_category['production_name']);?>">
                                        <label for="<?php echo htmlspecialchars($selected_category['production_name']);?>"><?php echo htmlspecialchars($selected_category['production_name']);?></lablel></br>

                                        
                                <?php
                                        }
                                    }else{
                                        ?>
                                        <p class="no_car_available_filtration">No categories available</p>
                                        <?php
                                    }
                            
                                ?>

                        <button class="filtration_submit_button" type="submit" id="submit_buttonID">Filter</button>
                    </form>   
                </div>
                <div class=guitars_container>
                    <div class="guitars_we_have_chosen" id="guitarsWeHaveChosenId">
                    </div>
                </div>
                <form id="hidden_one" method="POST" style="display:none;">
                    <input type="hidden" id="hidden_id" name="hidden_id" required>
                </form>
            </div>

        </div>


        
        <!-- Deal Of The Day -->

        <div class="deal-of-the-day">
            <h1>Deal Of The Day</h1>
            <div class="guitars_in_sale">
                <?php include('deal_of_the_day.php');?>
            </div>
        </div>
        <!--Hot-Deals-->
        <!--Comments/Reviews-->
        <!--Footer-->

        <?php include('footer.php');?>
        <script src="index.js"></script>
    </body>
</html>
<?php
?>