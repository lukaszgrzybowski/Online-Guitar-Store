<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $filter_values = json_decode($_POST["filter_value"]);

        $sql="SELECT * FROM orders ORDER BY order_id DESC LIMIT ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$filter_values);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        while($selected=mysqli_fetch_assoc($result)){
            ?>
            <div style="display:inline-block;">
                <div class="selected_order">
                    <p class="user_info_order"><?php echo htmlspecialchars($selected['name']);?> <?php echo htmlspecialchars($selected['surname']);?></p>
                    <p class="order_description"><?php echo htmlspecialchars($selected['email']);?></p>
                    <p class="order_description">phone:  <?php echo htmlspecialchars($selected['phone_number']);?></p>
                    <p class="order_description">address:  <?php echo htmlspecialchars($selected['street_name']);?> <?php echo htmlspecialchars($selected['home_number']);?></p>
                    <p class="order_description">city:  <?php echo htmlspecialchars($selected['city']);?></p>
                    <p class="order_description"><?php echo htmlspecialchars($selected['delivery_method']);?></p>
                    <p class="order_description" <?php
                        if($selected['order_status']=="collected" || $selected['order_status']=="sent"){
                            ?>
                            style="color:green; font-weight:600;">
                            <?php
                        }else{
                            ?>
                            style="color:red; font-weight:600;">
                            <?php 
                        }
                             echo htmlspecialchars($selected['order_status']);?></p>
                    <?php
                        if($selected['delivery_method']=="Collect personally"){
                            ?>
                                <button class="change_status" id="<?php echo htmlspecialchars($selected['order_id']);?>"onClick="change_status(this.id)">Order collected</button>
                            <?php
                        }else{
                            ?>
                            <button class="change_status" id="<?php echo htmlspecialchars($selected['order_id']);?>"onClick="change_status(this.id)">Order sent</button>
                            <?php
                        }
                    ?>
                    <button class="show_order_button" id="<?php echo htmlspecialchars($selected['order_id']);?>"onClick="show_order(this.id)">Order view</button>
                    <button class="delete_guitar_button" id="<?php echo htmlspecialchars($selected['order_id']);?>"onClick="confirmation_delete_order(this.id)">Delete</button>
                </div>
            </div>
            <?php
        }
    }
?>