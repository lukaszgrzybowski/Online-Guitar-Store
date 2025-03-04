<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        include("db.conn.php");

        $sql="SELECT guitar_id,guitar_name,category_name,brand_name,number,body_style_name,bridge_type_name,pickup_selection_name,price,production_name,img_dir_guitars
            FROM
            guitars INNER JOIN categories ON guitars.guitar_category=categories.category_id
            INNER JOIN brands ON guitars.brand=brands.brand_id
            INNER JOIN strings_number ON guitars.strings_number=strings_number.strings_number_id
            INNER JOIN body_styles ON guitars.body_style=body_styles.body_styles_id
            INNER JOIN bridge_types ON guitars.bridge_type=bridge_types.bridge_type_id
            INNER JOIN pickup_selections ON guitars.pickup_selection=pickup_selections.pickup_selections_id
            INNER JOIN productions ON guitars.production=productions.productions_id";

        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected=mysqli_fetch_assoc($result)){

                $checked_conditions=0;
                if(strpos(strtolower($selected['guitar_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['category_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['production_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['pickup_selection_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['bridge_type_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['body_style_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['number']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                if(strpos(strtolower($selected['brand_name']),strtolower($_POST['message']))){
                    $checked_conditions+=1;
                }
                 
                if($checked_conditions>0){
                    ?>
                        <button class="selected_guitar_button"  id="<?php echo htmlspecialchars($selected['guitar_name']);?>">
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
            }
        }
        mysqli_stmt_close($stmt);        
        $conn->close();

    }
?>