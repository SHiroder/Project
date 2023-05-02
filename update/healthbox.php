<?php

$id = $_GET['ID'];
$status = $_GET['Status_Onoff'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE healthbox SET Status_Onoff='$status' WHERE ID=$id";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";

  sleep(5);
  $status2 = "Off";
  $sql2 = "UPDATE healthbox SET Status_Onoff='$status2' WHERE ID=$id";
  if ($conn->query($sql2) === TRUE) {
    echo "Record updated Off successfully";
  
  } else {
    echo "Error updating record: " . $conn->error;
  }
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

?>
