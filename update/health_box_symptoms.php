<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

// Check connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Read data sent from ESP8266 via POST method
$id = $_POST["id"];
$status = $_POST["status"];

// Update data in health_box_symptoms table for the specified ID
$sql = "UPDATE health_box_symptoms SET Status_symptoms = '$status' WHERE ID = '$id'";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
  sleep(5500);
  $sql = "UPDATE health_box_symptoms SET Status_symptoms = 'IDLE' WHERE ID = '$id'";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
