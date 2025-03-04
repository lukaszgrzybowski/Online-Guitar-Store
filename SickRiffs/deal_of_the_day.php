<?php
    include('db.conn.php');

    $sql="SELECT guitar_id,guitar_name,category_name,brand_name,number,body_style_name,bridge_type_name,pickup_selection_name,price,production_name,img_dir_guitars
        FROM
        guitars INNER JOIN categories ON guitars.guitar_category=categories.category_id
        INNER JOIN brands ON guitars.brand=brands.brand_id
        INNER JOIN strings_number ON guitars.strings_number=strings_number.strings_number_id
        INNER JOIN body_styles ON guitars.body_style=body_styles.body_styles_id
        INNER JOIN bridge_types ON guitars.bridge_type=bridge_types.bridge_type_id
        INNER JOIN pickup_selections ON guitars.pickup_selection=pickup_selections.pickup_selections_id
        INNER JOIN productions ON guitars.production=productions.productions_id 
        WHERE deal_of_the_day=1";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../SickRiffs/basket.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($selected=mysqli_fetch_assoc($result)){
    ?>
        <div class="selected_guitar" style="height:460px; margin: 0px 10px;">
            <img src="<?php echo htmlspecialchars($selected['img_dir_guitars']);?>">
            <p class="selected_guitar_title" style="margin:5px;"><?php echo htmlspecialchars($selected['guitar_name']);?></p>
            <p class="selected_guitar_title" style="color:red; font-size:23px; margin:5px;"><?php echo htmlspecialchars($selected['price']);?>$</p>
            <p class="description">brand: <?php echo htmlspecialchars($selected['brand_name']);?></p>
            <p class="description">bridge: <?php echo htmlspecialchars($selected['bridge_type_name']);?></p>
            <p class="description">pickups: <?php echo htmlspecialchars($selected['pickup_selection_name']);?></p>
            <p class="description">production: <?php echo htmlspecialchars($selected['production_name']);?></p>
            <button class="buy_now" id="<?php echo htmlspecialchars($selected['guitar_id']);?>" onClick="add_to_basket_form(this.id)">Buy Now</button>
        </div>
    <?php
    }

?>