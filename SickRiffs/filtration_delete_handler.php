<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $filter_values = json_decode($_POST["filter_values"]);
        // print_r($filter_values);


        $sql="SELECT guitar_id,guitar_name,category_name,brand_name,number,body_style_name,bridge_type_name,pickup_selection_name,price,production_name,img_dir_guitars,deal_of_the_day
        FROM
        guitars INNER JOIN categories ON guitars.guitar_category=categories.category_id
        INNER JOIN brands ON guitars.brand=brands.brand_id
        INNER JOIN strings_number ON guitars.strings_number=strings_number.strings_number_id
        INNER JOIN body_styles ON guitars.body_style=body_styles.body_styles_id
        INNER JOIN bridge_types ON guitars.bridge_type=bridge_types.bridge_type_id
        INNER JOIN pickup_selections ON guitars.pickup_selection=pickup_selections.pickup_selections_id
        INNER JOIN productions ON guitars.production=productions.productions_id ";

        $previousstatementscheck=0;
        if($filter_values[0]!="None"){
            $previousstatementscheck=1;
            $newsql="WHERE category_name=?";
            $sql=$sql." ".$newsql;
        }
        if($filter_values[1]!="None"){
            if($previousstatementscheck!=1){
                $previousstatementscheck=1;
                $newsql="WHERE brand_name=?";
                $sql=$sql." ".$newsql;
            }else{
                $newsql="AND brand_name=?";
                $sql=$sql." ".$newsql;
            }
        }
        if($filter_values[2]!="None"){
            if($previousstatementscheck!=1){
                $previousstatementscheck=1;
                $newsql="WHERE body_style_name=?";
                $sql=$sql." ".$newsql;
            }else{
                $newsql="AND body_style_name=?";
                $sql=$sql." ".$newsql;
            }
           
        }
        if($filter_values[3]!="None"){
            if($previousstatementscheck!=1){
                $previousstatementscheck=1;
                $newsql="WHERE production_name=?";
                $sql=$sql." ".$newsql;
            }else{
                $newsql="AND production_name=?";
                $sql=$sql." ".$newsql;
            }
            
        }

        $counter = count($filter_values);
        for($i=0;$i<$counter;$i++){
                if(($key = array_search("None",$filter_values))!==false){
                    unset($filter_values[$key]);
                }
        }
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }

        if(count($filter_values)!=0){
            $keys = array_keys($filter_values);
            if(count($filter_values)==1){
                mysqli_stmt_bind_param($stmt,"s",$filter_values[$keys[0]]);
            }else if(count($filter_values)==2){
                mysqli_stmt_bind_param($stmt,"ss",$filter_values[$keys[0]],$filter_values[$keys[1]]);
            }else if(count($filter_values)==3){
                mysqli_stmt_bind_param($stmt,"sss",$filter_values[$keys[0]],$filter_values[$keys[1]],$filter_values[$keys[2]]);
            }else if(count($filter_values)==4){
                mysqli_stmt_bind_param($stmt,"ssss",$filter_values[$keys[0]],$filter_values[$keys[1]],$filter_values[$keys[2]],$filter_values[$keys[3]]);
            }
        }



        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        while($selected=mysqli_fetch_assoc($result)){
        ?>
        <div style="display:inline-block;">
            <div class="selected_guitar" style="height:500px;">
                <img src="<?php echo htmlspecialchars($selected['img_dir_guitars']);?>">
                <p class="selected_guitar_title"><?php echo htmlspecialchars($selected['guitar_name']);?> - <?php echo htmlspecialchars($selected['price']);?>$</p>
                <p class="description">brand: <?php echo htmlspecialchars($selected['brand_name']);?></p>
                <p class="description">bridge: <?php echo htmlspecialchars($selected['bridge_type_name']);?></p>
                <p class="description">pickups: <?php echo htmlspecialchars($selected['pickup_selection_name']);?></p>
                <p class="description">production: <?php echo htmlspecialchars($selected['production_name']);?></p>
                <div>
                <input type="number" name="new_price_for_dotd" id="new_price_for_dotd_id" min="1" style="width:100px; text-align:center;">
                <button class="delete_guitar_button" id="<?php echo htmlspecialchars($selected['guitar_id']);?>"onClick="confirmation_change_price(this.id)" style="background-color:green;">Change price</button>
                </div>

                <?php
                     if($selected['deal_of_the_day']==0){
                        ?>
                            <button class="delete_guitar_button" id="<?php echo htmlspecialchars($selected['guitar_id']);?>"onClick="confirmation_deal_of_the_day(this.id)" style="background-color:purple;">Deal of the day</button>
                        <?php
                    }else{
                        ?>
                            <button class="delete_guitar_button" id="<?php echo htmlspecialchars($selected['guitar_id']);?>"onClick="confirmation_deal_of_the_day(this.id)" style="background-color:purple;">Delete deal of the day</button>
                        <?php 
                    }
                ?>
                <button class="delete_guitar_button" id="<?php echo htmlspecialchars($selected['guitar_id']);?>"onClick="confirmation_delete_guitar(this.id)">Delete</button>
            </div>
        </div>
        
        <?php
        }
    }
?>