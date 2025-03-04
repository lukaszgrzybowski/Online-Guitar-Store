<?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        require("db.conn.php");

        $checkbox_values = json_decode($_POST["checkbox_values"]);
        $Our_categories_filters = array();
        
        
        //categories
        $sql = "SELECT * FROM categories;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['category_name']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_categories_filters,$array_item);
                    }
            }

        }


        $Our_brands_filters = array();
        //brands
        $sql = "SELECT * FROM brands;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['brand_name']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_brands_filters,$array_item);
                    }
            }

        }

        $Our_strings_filters = array();
        //strings_number
        $sql = "SELECT * FROM strings_number;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['number']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_strings_filters,$array_item);
                    }
            }

        }

        $Our_body_filters = array();
        //body_style
        $sql = "SELECT * FROM body_styles;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['body_style_name']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_body_filters,$array_item);
                    }
            }

        }

        $Our_bridge_filters = array();
        //bridge_type
        $sql = "SELECT * FROM bridge_types;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['bridge_type_name']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_bridge_filters,$array_item);
                    }
            }

        }

        $Our_pickup_filters = array();
        //pickup_selection
        $sql = "SELECT * FROM pickup_selections;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['pickup_selection_name']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_pickup_filters,$array_item);
                    }
            }

        }

        $Our_production_filters = array();
        //production
        $sql = "SELECT * FROM productions;";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected_category=mysqli_fetch_assoc($result)){
                    $newsql = str_replace(' ','',$selected_category['production_name']);
                    if(in_array($newsql,$checkbox_values)){
                        $array_item = $newsql;
                        array_push($Our_production_filters,$array_item);
                    }
            }

        }


        // print_r($Our_categories_filters);
        // print_r($Our_production_filters);
        // print_r($Our_pickup_filters);
        // print_r($Our_bridge_filters);
        // print_r($Our_body_filters);
        // print_r($Our_strings_filters);
        //print_r($Our_brands_filters);

        $sql="SELECT guitar_id,guitar_name,category_name,brand_name,number,body_style_name,bridge_type_name,pickup_selection_name,price,production_name,img_dir_guitars
            FROM
            guitars INNER JOIN categories ON guitars.guitar_category=categories.category_id
            INNER JOIN brands ON guitars.brand=brands.brand_id
            INNER JOIN strings_number ON guitars.strings_number=strings_number.strings_number_id
            INNER JOIN body_styles ON guitars.body_style=body_styles.body_styles_id
            INNER JOIN bridge_types ON guitars.bridge_type=bridge_types.bridge_type_id
            INNER JOIN pickup_selections ON guitars.pickup_selection=pickup_selections.pickup_selections_id
            INNER JOIN productions ON guitars.production=productions.productions_id";


        $Our_final_filters=array();
        array_push($Our_final_filters,$Our_categories_filters);
        array_push($Our_final_filters,$Our_production_filters);
        array_push($Our_final_filters,$Our_pickup_filters);
        array_push($Our_final_filters,$Our_bridge_filters);
        array_push($Our_final_filters,$Our_body_filters);
        array_push($Our_final_filters,$Our_strings_filters);
        array_push($Our_final_filters,$Our_brands_filters);

        // print_r($Our_final_filters);
        // print_r("1111111111111111111111111111");
        
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0){
            while($selected=mysqli_fetch_assoc($result)){

                $checked_conditions=0;
                $expected_number_of_conditions=0;
                $var=0;
                $counter=1;
                if(count($Our_final_filters)>0){
                    foreach($Our_final_filters as $final_filter){
                        if(count($final_filter)>0){
                            $expected_number_of_conditions+=1;
                        }
                        $values_array=array_values($final_filter);
                        // print_r($values_array);
                        // print_r("11");
                        foreach($values_array as $value){
                            //print_r($value);
                            switch($counter){
                                case 1:
                                    if($value==$selected['category_name']){
                                        $var+=1;
                                    }
                                    break;
                                case 2:
                                    if($value==$selected['production_name']){
                                        $var+=1;
                                    }
                                    break;
                                case 3:
                                    if($value==$selected['pickup_selection_name']){
                                        $var+=1;
                                    }
                                    break;
                                case 4:
                                    if($value==$selected['bridge_type_name']){
                                        $var+=1;
                                    }
                                    break;
                                case 5:
                                    if($value==$selected['body_style_name']){
                                        $var+=1;
                                    }
                                    break;
                                case 6:
                                    if($value==$selected['number']){
                                        $var+=1;
                                    }
                                    break;
                                case 7:
                                    if($value==$selected['brand_name']){
                                        $var+=1;
                                    }
                                    break;
                            }
                        }
                        if($var>0){
                            $checked_conditions+=1;
                            $var=0;
                        }
                        $counter+=1;
                    }
                    
                }
                // print_r($checked_conditions);
                // print_r($expected_number_of_conditions);
                // print_r(' ');

                if($checked_conditions==$expected_number_of_conditions){
                    // print_r(" 0 ");
                    //print_r($checked_conditions);
                    ?>
                        <div class="selected_guitar" id="<?php echo htmlspecialchars($selected['guitar_name']);?>">
                            <img src="<?php echo htmlspecialchars($selected['img_dir_guitars']);?>">
                            <p class="selected_guitar_title"><?php echo htmlspecialchars($selected['guitar_name']);?> - <?php echo htmlspecialchars($selected['price']);?>$</p>
                            <p class="description">brand: <?php echo htmlspecialchars($selected['brand_name']);?></p>
                            <p class="description">bridge: <?php echo htmlspecialchars($selected['bridge_type_name']);?></p>
                            <p class="description">pickups: <?php echo htmlspecialchars($selected['pickup_selection_name']);?></p>
                            <p class="description">production: <?php echo htmlspecialchars($selected['production_name']);?></p>
                            <button class="buy_now" id="<?php echo htmlspecialchars($selected['guitar_id']);?>" onClick="add_to_basket_form(this.id)">Buy Now</button>
                        </div>

                    <?php
                }
            }
        }

        $conn->close();
    }


?>