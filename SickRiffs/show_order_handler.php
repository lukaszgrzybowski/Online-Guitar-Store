<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $order_value = json_decode($_POST["order_value"]);

        $sql="SELECT user_order FROM orders WHERE order_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$order_value);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        $order_row = mysqli_fetch_assoc($result);
        $orderarray= json_decode($order_row['user_order']);
        // print_r($orderarray);
        



        $sql="SELECT guitar_id,guitar_name,category_name,brand_name,number,body_style_name,bridge_type_name,pickup_selection_name,price,production_name,img_dir_guitars
            FROM
            guitars INNER JOIN categories ON guitars.guitar_category=categories.category_id
            INNER JOIN brands ON guitars.brand=brands.brand_id
            INNER JOIN strings_number ON guitars.strings_number=strings_number.strings_number_id
            INNER JOIN body_styles ON guitars.body_style=body_styles.body_styles_id
            INNER JOIN bridge_types ON guitars.bridge_type=bridge_types.bridge_type_id
            INNER JOIN pickup_selections ON guitars.pickup_selection=pickup_selections.pickup_selections_id
            INNER JOIN productions ON guitars.production=productions.productions_id";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        while($selected=mysqli_fetch_assoc($result)){
            if(in_array($selected['guitar_id'],$orderarray)){
                ?>
                    <div class="selected_guitar" id="<?php echo htmlspecialchars($selected['guitar_name']);?>" style="display:inline-block;">
                        <div style="display:flex; flex-direction:column; align-items:center;">
                        <img src="<?php echo htmlspecialchars($selected['img_dir_guitars']);?>">
                        <p class="selected_guitar_title"><?php echo htmlspecialchars($selected['guitar_name']);?> - <?php echo htmlspecialchars($selected['price']);?>$</p>
                        <p class="description">brand: <?php echo htmlspecialchars($selected['brand_name']);?></p>
                        <p class="description">bridge: <?php echo htmlspecialchars($selected['bridge_type_name']);?></p>
                        <p class="description">pickups: <?php echo htmlspecialchars($selected['pickup_selection_name']);?></p>
                        <p class="description">production: <?php echo htmlspecialchars($selected['production_name']);?></p>
                        <p class="description">guitar id: <?php echo htmlspecialchars($selected['guitar_id']);?></p>
                        </div>
                    </div>
                <?php
            }
        }
    }
?>