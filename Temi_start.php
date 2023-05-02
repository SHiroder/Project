<?php
   session_start();

   include_once 'DB/connect.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $temi_id = $_REQUEST['Temi_ID'];
    
    $sql1 = "UPDATE temi_start SET Status_start = 'start' WHERE Temi_ID = $temi_id";
    $sql2 = "UPDATE temi SET Operation_Status = 'start' WHERE ID= $temi_id";
    
    if ($conn->query($sql1) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
    header("refresh:2;nurse.php");
?>
