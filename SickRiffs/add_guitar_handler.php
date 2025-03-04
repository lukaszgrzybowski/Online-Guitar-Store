<?php
    if(isset($_POST['submit-add-admin-button'])){

        require 'db.conn.php';
        
        if(isset($_FILES['image']) && isset($_POST['guitarname']) && isset($_POST['category'])&& isset($_POST['description'])
        && isset($_POST['brand']) && isset($_POST['stringsnumber'])&& isset($_POST['bodystyle'])&& isset($_POST['bridgetype'])&& isset($_POST['pickupselection'])
        && isset($_POST['production'])&& isset($_POST['price'])){


            $file=$_FILES['image'];
            $brand=$_POST['brand'];
            $stringsnumber=$_POST['stringsnumber'];
            $bodystyle=$_POST['bodystyle'];
            $bridgetype=$_POST['bridgetype'];
            $pickupselection=$_POST['pickupselection'];
            $production=$_POST['production'];
            $price = $_POST['price'];
            $guitarname=$_POST['guitarname'];
            $category=$_POST['category'];
            $description=$_POST['description'];


            $fileName = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileSize = $_FILES['image']['size'];
            $fileError = $_FILES['image']['error'];
            $fileType = $_FILES['image']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg','jpeg','png');

            //walidacja dla pliku
            if(in_array($fileActualExt,$allowed)){
                if($fileError===0){
                    if($fileSize<500000){
                        $fileNameNew = uniqid('', true).".".$fileActualExt;
                        $fileDestination = 'website_resources/'.$fileNameNew;
                        move_uploaded_file($fileTmpName,$fileDestination);

                        //walidacja dla reszty pól
                        if(!preg_match("/^[0-9]*$/",$_POST['stringsnumber'])){
                            header("Location: ../SickRiffs/admin_page.php?error=invalidstringsnumber");
                            exit(); 
                        }

                        if(!preg_match("/^[a-zA-Z]*$/",$_POST['production'])){
                            header("Location: ../SickRiffs/admin_page.php?error=invalidproduction");
                            exit(); 
                        }

                        //sprawdzenie pokolei istnienia wszystkich cech w bazie danych lub ich dodanie

                        //brand
                        $sql = "SELECT * FROM brands WHERE brand_name=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$brand);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        // print_r($row);
                        if($row){
                             $brandid=$row['brand_id'];
                        }
                        else{
                            // print_r("nie ma");
                            $sql = "INSERT INTO brands (brand_name) VALUES (?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            mysqli_stmt_bind_param($stmt,"s",$brand);
                            mysqli_stmt_execute($stmt);

                            //znalienie indeksu dodanej pozycji w bazie danych
                            $sql = "SELECT brand_id FROM brands WHERE brand_name=?";
                            $stmt = mysqli_stmt_init($conn);

                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            mysqli_stmt_bind_param($stmt,"s",$brand);
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $row=mysqli_fetch_assoc($result);
                            if($row){
                                $brandid=$row['brand_id'];
                            }else{
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            
                            
                        }
                        print_r($brandid);

                        //strings number
                        $sql = "SELECT * FROM strings_number WHERE number=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$stringsnumber);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        // print_r($row);
                        if($row){
                             $stringsnumberid=$row['strings_number_id'];
                        }
                        else{
                            //print_r("nie ma");
                            $sql = "INSERT INTO strings_number (number) VALUES (?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            mysqli_stmt_bind_param($stmt,"s",$stringsnumber);
                            mysqli_stmt_execute($stmt);

                            //znalienie indeksu dodanej pozycji w bazie danych
                            $sql = "SELECT strings_number_id FROM strings_number WHERE number=?";
                            $stmt = mysqli_stmt_init($conn);

                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            mysqli_stmt_bind_param($stmt,"s",$stringsnumber);
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $row=mysqli_fetch_assoc($result);
                            if($row){
                                $stringsnumberid=$row['strings_number_id'];
                            }else{
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            
                        }

                        print_r($stringsnumberid);

                        

                        //bodystyle
                        $sql = "SELECT * FROM body_styles WHERE body_style_name=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$bodystyle);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        // print_r($row);
                        if($row){
                             $bodystyleid=$row['body_styles_id'];
                        }
                        else{
                            // print_r("nie ma");
                            $sql = "INSERT INTO body_styles (body_style_name) VALUES (?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            mysqli_stmt_bind_param($stmt,"s",$bodystyle);
                            mysqli_stmt_execute($stmt);

                            //znalienie indeksu dodanej pozycji w bazie danych
                            $sql = "SELECT body_styles_id FROM body_styles WHERE body_style_name=?";
                            $stmt = mysqli_stmt_init($conn);

                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            mysqli_stmt_bind_param($stmt,"s",$bodystyle);
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $row=mysqli_fetch_assoc($result);
                            if($row){
                                $bodystyleid=$row['body_styles_id'];
                            }else{
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            
                        }

                        print_r($bodystyleid);

                        //bridgetype
                        $sql = "SELECT * FROM bridge_types WHERE bridge_type_name=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$bridgetype);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        // print_r($row);
                        if($row){
                             $bridgetypeid=$row['bridge_type_id'];
                        }
                        else{
                            // print_r("nie ma");
                            $sql = "INSERT INTO bridge_types (bridge_type_name) VALUES (?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            mysqli_stmt_bind_param($stmt,"s",$bridgetype);
                            mysqli_stmt_execute($stmt);

                            //znalienie indeksu dodanej pozycji w bazie danych
                            $sql = "SELECT bridge_type_id FROM bridge_types WHERE bridge_type_name=?";
                            $stmt = mysqli_stmt_init($conn);

                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            mysqli_stmt_bind_param($stmt,"s",$bridgetype);
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $row=mysqli_fetch_assoc($result);
                            if($row){
                                $bridgetypeid=$row['bridge_type_id'];
                            }else{
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            
                        }

                        print_r($bridgetypeid);

                        //pickupselection
                        $sql = "SELECT * FROM pickup_selections WHERE pickup_selection_name=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$pickupselection);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        // print_r($row);
                        if($row){
                            $pickupselectionid=$row['pickup_selections_id'];
                        }
                        else{
                            // print_r("nie ma");
                            $sql = "INSERT INTO pickup_selections (pickup_selection_name) VALUES (?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            mysqli_stmt_bind_param($stmt,"s",$pickupselection);
                            mysqli_stmt_execute($stmt);

                            //znalienie indeksu dodanej pozycji w bazie danych
                            $sql = "SELECT pickup_selections_id FROM pickup_selections WHERE pickup_selection_name=?";
                            $stmt = mysqli_stmt_init($conn);

                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            mysqli_stmt_bind_param($stmt,"s",$pickupselection);
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $row=mysqli_fetch_assoc($result);
                            if($row){
                                $pickupselectionid=$row['pickup_selections_id'];
                            }else{
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            
                        }

                        print_r($pickupselectionid);

                        //production
                        $sql = "SELECT * FROM productions  WHERE production_name=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$production);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        // print_r($row);
                        if($row){
                             $productionid=$row['productions_id'];
                        }
                        else{
                            // print_r("nie ma");
                            $sql = "INSERT INTO productions (production_name) VALUES (?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            mysqli_stmt_bind_param($stmt,"s",$production);
                            mysqli_stmt_execute($stmt);

                            //znalienie indeksu dodanej pozycji w bazie danych
                            $sql = "SELECT productions_id FROM productions WHERE production_name=?";
                            $stmt = mysqli_stmt_init($conn);

                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }

                            mysqli_stmt_bind_param($stmt,"s",$production);
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $row=mysqli_fetch_assoc($result);
                            if($row){
                                $productionid=$row['productions_id'];
                            }else{
                                header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                                exit();
                            }
                            
                        }
                        print_r($productionid);

                        //wzięcie id kategorii
                        //znalienie indeksu dodanej pozycji w bazie danych
                        $sql = "SELECT category_id FROM categories WHERE category_name=?";
                        $stmt = mysqli_stmt_init($conn);

                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        mysqli_stmt_bind_param($stmt,"s",$category);
                        mysqli_stmt_execute($stmt);
                        $result=mysqli_stmt_get_result($stmt);
                        $row=mysqli_fetch_assoc($result);
                        if($row){
                            $categoryid=$row['category_id'];
                        }else{
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }

                        print_r($categoryid);


                        //teraz dodanie samej gitary do tabeli gitar
                        $sql = "INSERT INTO guitars (guitar_name,guitar_category,brand,strings_number,body_style,bridge_type,pickup_selection,price,production,description,img_dir_guitars) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }
                        mysqli_stmt_bind_param($stmt,"siiiiiiiiss",$guitarname,$categoryid,$brandid,$stringsnumberid,$bodystyleid,$bridgetypeid,$pickupselectionid,$price,$productionid,$description,$fileDestination);
                        if(!mysqli_stmt_execute($stmt)){
                            header("Location: ../SickRiffs/admin_page.php?error=sqlerror");
                            exit();
                        }
                        else{
                            header("Location: ../SickRiffs/admin_page.php?success=success");
                            mysqli_stmt_close($stmt);
                            mysqli_close($conn);
                            exit();
                        }

                    }
                    else{
                        header("Location: ../SickRiffs/admin_page.php?error=tobigfile");
                        exit();
                    }

                }
                else{
                    header("Location: ../SickRiffs/admin_page.php?error=fileuploaderror");
                    exit();
                }
            }
            else{
                header("Location: ../SickRiffs/admin_page.php?error=invalidfileextension");
                exit();
            }



        }
        else{
            header("Location: ../SickRiffs/admin_page.php?error=fieldsempty");
            exit(); 
        }

    }
    else{
        header("Location: ../SickRiffs/admin_page.php");
        exit();  
    }