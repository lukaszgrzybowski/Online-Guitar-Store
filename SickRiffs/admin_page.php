<?php
    require("db.conn.php");
    session_start();
    
    if(isset($_SESSION)){
        if(isset($_SESSION['userId'])){
            $sql="SELECT user_status FROM users";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                exit();
            }
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($result->num_rows==0){
                header("Location: ../SickRiffs/login_register.php?");
                exit();
            }
            $row = mysqli_fetch_assoc($result);
            if($row['user_status']!='admin'){
                header("Location: ../SickRiffs/login_register.php");
                exit();
            }
        }else{
            header("Location: ../SickRiffs/login_register.php");
            exit(); 
        }
    }else{
        header("Location: ../SickRiffs/login_register.php");
        exit(); 
    }
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

        <!-- Login/Register part of site -->
        <div class="admin_windows">
            <div class="admin_guitars_container">
                <div class="add_guitar_container">
                    <div class="add_guitar_form">
                        <form action="add_guitar_handler.php" id="guitar_add_form_id" method="POST" enctype="multipart/form-data">
                            <h1>Add guitar to store</h1>
                            <?php
                            if(isset($_GET['error'])){
                            ?>
                            <p class="errormessage">You have incorrect <?php echo htmlspecialchars($_GET['error']); ?>, please correct it before moving forward!</p>
                            <?php
                            }
                            ?>

                            <label for="image">Image:</label>
                            <input type="file" name="image">

                            <label for="guitarname">Guitar Name:</label>
                            <input type="text" name="guitarname">

                            <label for="description">Description:</label>
                            <input type="text" name="description">

                            <label for="category">Category:</label>
                            <select name="category" id="categoryformid">
                            
                            <?php
                                $sql="SELECT category_name FROM categories";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['category_name']);?>"><?php echo htmlspecialchars($row['category_name']);?></option>
                                    <?php
                                }
                            ?>
                            </select>

                            <label for="brand">Brand:</label>
                            <input type="text" name="brand" list="brandlist">
                                <datalist id="brandlist">
                                <?php
                                $sql="SELECT brand_name FROM brands";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['brand_name']);?>">
                                    <?php
                                }
                            ?>

                                </datalist>
                            

                            <label for="stringsnumber">Strings number:</label>
                            <input type="text" name="stringsnumber" list="stringsnumberlist">
                                <datalist id="stringsnumberlist">
                                <?php
                                $sql="SELECT number FROM strings_number";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['number']);?>">
                                    <?php
                                }
                            ?>

                                </datalist>
                            

                            <label for="bodystyle">Body style:</label>
                            <input type="text" name="bodystyle" list="bodystylelist">
                                <datalist id="bodystylelist">
                                <?php
                                $sql="SELECT body_style_name FROM body_styles";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['body_style_name']);?>">
                                    <?php
                                }
                            ?>

                                </datalist>
                            

                            <label for="bridgetype">Bridge type:</label>
                            <input type="text" name="bridgetype" list="bridgetypelist">
                                <datalist id="bridgetypelist">
                                <?php
                                $sql="SELECT bridge_type_name FROM bridge_types";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['bridge_type_name']);?>">
                                    <?php
                                }
                            ?>

                                </datalist>
                            

                            <label for="pickupselection">Pickup selection:</label>
                            <input type="text" name="pickupselection" list="pickupselectionlist">
                                <datalist id="pickupselectionlist">
                                <?php
                                $sql="SELECT pickup_selection_name FROM pickup_selections";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['pickup_selection_name']);?>">
                                    <?php
                                }
                            ?>

                                </datalist>


                            <label for="production">Production</label>
                            <input type="text" name="production" list="productionlist">
                                <datalist id="productionlist">
                                <?php
                                $sql="SELECT production_name FROM productions";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['production_name']);?>">
                                    <?php
                                }
                            ?>

                                </datalist>
                            

                            <label for="price">Price:</label>
                            <input type="number" name="price" min="0">
                           
                            <button class="submit-add-admin-button" type="submit" name="submit-add-admin-button" id="submit-add-admin-button_id">Show customer view / add to store</button>
                        </form>
                    </div>
                    <div class="add_guitar_future_view">
                        <h1>Customer view of new guitar</h1>
                        <div class="future_view_of_new_guitar_dynamic" id="future_view_of_new_guitar_dynamic_id">
                                <?php
                                    if(isset($_GET['success'])){
                                        $sql="SELECT guitar_id,guitar_name,category_name,brand_name,number,body_style_name,bridge_type_name,pickup_selection_name,price,production_name,img_dir_guitars
                                        FROM
                                        guitars INNER JOIN categories ON guitars.guitar_category=categories.category_id
                                        INNER JOIN brands ON guitars.brand=brands.brand_id
                                        INNER JOIN strings_number ON guitars.strings_number=strings_number.strings_number_id
                                        INNER JOIN body_styles ON guitars.body_style=body_styles.body_styles_id
                                        INNER JOIN bridge_types ON guitars.bridge_type=bridge_types.bridge_type_id
                                        INNER JOIN pickup_selections ON guitars.pickup_selection=pickup_selections.pickup_selections_id
                                        INNER JOIN productions ON guitars.production=productions.productions_id 
                                        WHERE guitar_id=(SELECT MAX(guitar_id) FROM guitars)";
                                    

                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt,$sql)){
                                        header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                        exit();
                                    }

                                    mysqli_stmt_execute($stmt);
                                    $result=mysqli_stmt_get_result($stmt);
                                    $selected=mysqli_fetch_assoc($result);

                                    ?>
                                    <button class="selected_guitar_button"  id="<?php echo $selected['guitar_name']?>">
                                    <a href="">
                                    <div class="selected_guitar">
                                        <img src="<?php echo htmlspecialchars($selected['img_dir_guitars']);?>">
                                        <p class="selected_guitar_title"><?php echo htmlspecialchars($selected['guitar_name']);?> - <?php echo htmlspecialchars($selected['price']);?>$</p>
                                        <p class="description">brand: <?php echo htmlspecialchars($selected['brand_name']);?></p>
                                        <p class="description">bridge: <?php echo htmlspecialchars($selected['bridge_type_name']);?></p>
                                        <p class="description">pickups: <?php echo htmlspecialchars($selected['pickup_selection_name']);?></p>
                                        <p class="description">production: <?php echo htmlspecialchars($selected['production_name']);?></p>
                                        <div class="buy_now">Buy Now</div>
                                    </div>
                                    </a>
                                    </button>
                                    <?php

                                }
                                ?>
                                
                        </div>
                    </div>
                </div>
                <div class="delete_guitar_container">
                        <form class="guitar_search_for_delete_form" id="guitar_search_for_delete_form_id" method="POST">
                        <h1>Delete guitar form store</h1>

                            <label for="category">Category:</label>
                            <select name="category" id="categoryformdeleteid">
                                <option value="None">None</option>
                                <?php
                                    $sql="SELECT category_name FROM categories";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt,$sql)){
                                        header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                        exit();
                                    }
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    while($row=mysqli_fetch_assoc($result)){
                                        ?>
                                        <option value="<?php echo($row['category_name']);?>"><?php echo($row['category_name']);?></option>
                                        <?php
                                    }
                                ?>
                            </select>

                            <label for="brand">Brand:</label>
                            <select name="brand" id="brandformdeleteid">
                                <option value="None">None</option>
                                <?php
                                $sql="SELECT brand_name FROM brands";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo($row['brand_name']);?>"><?php echo($row['brand_name']);?></option>
                                    <?php
                                }
                            ?>
                            </select>

                            <label for="bodystyle">Body style:</label>
                            <select name="bodystyle" id="bodystyledeleteformid">
                                <option value="None">None</option>
                                <?php
                                $sql="SELECT body_style_name FROM body_styles";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo($row['body_style_name']);?>"><?php echo($row['body_style_name']);?></option>
                                    <?php
                                }
                            ?>
                            </select>

                            <label for="production">Production</label>
                            <select name="production" id="productiondelformid">
                                <option value="None">None</option>
                                <?php
                                $sql="SELECT production_name FROM productions";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt,$sql)){
                                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                    exit();
                                }
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                while($row=mysqli_fetch_assoc($result)){
                                    ?>
                                    <option value="<?php echo($row['production_name']);?>"><?php echo($row['production_name']);?></option>
                                    <?php
                                }
                            ?>
                            </select>

                            <button class="submit-add-admin-button" type="submit" id="submit_filter_for_delete_id">Filter</button>
                            </form>
                        <div class="scroll-guitars-container" id="scroll-guitars-container_id">

                        </div>
                        <!-- show confirmation delete after clicking delete -->
                        <div class="confirmation_delete" id="confirmation_delete_id">
                            <p>Confirm if you want to delete this position</p>
                            <div class="confirmation_delete_buttons">
                            <button class="delete_yes" id="">Yes</button>
                            <button class="delete_no" id="delete_no_id">No</button>
                            </div>
                        </div>
                        
                </div>
                <div class="admin_orders_container">
                    <div class="info_orders_container">
                        <h1>Customer orders</h1>
                        <form class="number_of_orders_delete_form" id="number_of_orders_delete_form_id" method="POST">
                            <label for="number_of_orders">Number of orders to load:</label>
                            <input type="number" name="number_of_orders" id="number_of_orders_id" min="0" value="40">
                            <button class="submit-add-admin-button" type="submit" id="submit_filter_number_of_orders_id">Filter</button>
                        </form>       
                    </div>
                    <div class="scroll_orders_container" id="scroll_orders_container_id">
                        
                    </div>
                    <!-- show ordered items after clicking oreder view -->
                    <div class="show_orders_window" id="view_orders_id">
                        <div class="close_icon_order_view">
                            <i class="fa-solid fa-xmark" id="close_order_view"></i>
                            <button hidden class="view_order" id=""></button>
                        </div>
                        <div class="oreders_in_order_view" id="oreders_in_order_view_id">

                        </div>
                        </div>
                    </div>
                    <!-- show confirmation delete after clicing delete on order -->
                    <div class="confirmation_delete" id="confirmation_delete_order_id">
                        <p>Confirm if you want to delete this order</p>
                        <div class="confirmation_delete_buttons">
                        <button class="delete_yes_order" id="">Yes</button>
                        <button class="delete_no_order" id="delete_no_id">No</button>
                        </div>
                    </div>
                    <!-- change order status confirmation window -->
                    <div class="confirmation_delete" id="confirmation_change_order_status_id">
                        <p>Confirm if you want to change this order status</p>
                        <div class="confirmation_delete_buttons">
                        <button class="change_yes_order" id="">Yes</button>
                        <button class="change_no_order" id="delete_no_id">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testtrack">

        </div>
    
        <?php include('footer.php');?>
        <script src="admin.js"></script>
    </body>
</html>
<?php
?>