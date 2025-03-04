<?php

session_start();
session_unset();
session_destroy();
header("Location: ../SickRiffs/login_register.php");