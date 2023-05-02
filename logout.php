<?php 

    session_start();
    unset($_SESSION['nurse_login']);
    unset($_SESSION['doctor_login']);
    unset($_SESSION['admin_login']);
    header("location: index.php");

    
?>