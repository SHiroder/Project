<?php
 include_once 'connect.php';

$sql = "INSERT INTO rooms (id, hospital_id, room_bed) VALUES ('" . $_GET['id'] . "', '" . $_GET['hospital_id'] . "', '" . $_GET['room_bed'] ."')";

    
if ($conn->query($sql) == TRUE) {
     echo "New record created successfully";
 } else {
     echo "Error: " . $sql . "<br>" . $conn->error;
 }
?>