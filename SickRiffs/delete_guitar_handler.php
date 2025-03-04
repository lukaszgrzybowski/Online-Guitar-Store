<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require("db.conn.php");

        $delete_value = json_decode($_POST["id_to_delete"]);
        $sql="DELETE FROM guitars WHERE guitar_id=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_bind_param($stmt,"s",$delete_value);
        mysqli_stmt_execute($stmt);

        // checking integrity of database

        $brands_array = array();
        $strings_number__array = array();
        $body_style_array = array();
        $bridge_type_array = array();
        $pickup_selection_array = array();
        $production_array = array();

        $sql="SELECT brand,strings_number,body_style,bridge_type,pickup_selection,production FROM guitars";
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            array_push($brands_array,$row['brand']);
            array_push($strings_number__array,$row['strings_number']);
            array_push($body_style_array,$row['body_style']);
            array_push($bridge_type_array,$row['bridge_type']);
            array_push($pickup_selection_array,$row['pickup_selection']);
            array_push( $production_array,$row['production']);
        }


        //brands

        $sql="SELECT brand_id FROM brands";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            if(!in_array($row['brand_id'],$brands_array)){
                $sql="DELETE FROM brands WHERE brand_id=?";
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_bind_param($stmt,"s",$row['brand_id']);
                mysqli_stmt_execute($stmt);

            }
        }

        //strings_number

        $sql="SELECT strings_number_id FROM strings_number";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            if(!in_array($row['strings_number_id'],$strings_number__array)){
                $sql="DELETE FROM strings_number WHERE strings_number_id=?";
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_bind_param($stmt,"s",$row['strings_number_id']);
                mysqli_stmt_execute($stmt);

            }
        }

        //body_style

        $sql="SELECT body_styles_id FROM body_styles";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            if(!in_array($row['body_styles_id'],$body_style_array)){
                $sql="DELETE FROM body_styles WHERE body_styles_id=?";
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_bind_param($stmt,"s",$row['body_styles_id']);
                mysqli_stmt_execute($stmt);

            }
        }

        //bridge_type

        $sql="SELECT bridge_type_id FROM bridge_types";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            if(!in_array($row['bridge_type_id'],$bridge_type_array)){
                $sql="DELETE FROM bridge_types WHERE bridge_type_id=?";
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_bind_param($stmt,"s",$row['bridge_type_id']);
                mysqli_stmt_execute($stmt);

            }
        }

        //pickup_selection

        $sql="SELECT pickup_selections_id FROM pickup_selections";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            if(!in_array($row['pickup_selections_id'], $pickup_selection_array)){
                $sql="DELETE FROM pickup_selections WHERE pickup_selections_id=?";
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_bind_param($stmt,"s",$row['pickup_selections_id']);
                mysqli_stmt_execute($stmt);

            }
        }

        //production

        $sql="SELECT productions_id FROM productions";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row=mysqli_fetch_assoc($result)){
            if(!in_array($row['productions_id'],$production_array)){
                $sql="DELETE FROM productions WHERE productions_id=?";
                if(!mysqli_stmt_prepare($stmt,$sql)){
                    header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                    exit();
                }
                mysqli_stmt_bind_param($stmt,"s",$row['productions_id']);
                mysqli_stmt_execute($stmt);

            }
        }
        mysqli_stmt_close($stmt);
         mysqli_close($conn);

    }


?>