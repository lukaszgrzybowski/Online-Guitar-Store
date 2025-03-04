<?php
    if(isset($_GET['error'])){
        if($_GET['error'] == "emptyfields"){
            echo('<p class="errormessage">Fill in all fields!</p>');
        }
        else if($_GET['error'] == "invalidmailnamesurname"){
            echo('<p class="errormessage">Invalid email, name and surname!</p>');
        }
        else if($_GET['error'] == "invalidmailname"){
            echo('<p class="errormessage">Invalid email and name!</p>');
        }
        else if($_GET['error'] == "invalidmailsurname"){
            echo('<p class="errormessage">Invalid email and surname!</p>');
        }
        else if($_GET['error'] == "invalidnamesurname"){
            echo('<p class="errormessage">Invalid name and surname!</p>');
        }
        else if($_GET['error'] == "invalidmail"){
            echo('<p class="errormessage">Invalid email!</p>');
        }
        else if($_GET['error'] == "invalidiname"){
            echo('<p class="errormessage">Invalid name!</p>');
        }
        else if($_GET['error'] == "invalidisurname"){
            echo('<p class="errormessage">Invalid surname!</p>');
        }
    }

?>

