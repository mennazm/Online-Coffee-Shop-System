<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION["role"] !== "admin") {
    $_SESSION['message'] = "You are not authorized to access here";
    header("Location: ../index.php");
   
}




else{
$_SESSION['message'] ="Login to continue";
header("Location: ../login_page/login.php");


}

?>