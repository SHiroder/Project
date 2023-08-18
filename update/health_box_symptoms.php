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
  $id--;
  sleep(15);
  $sql3 = "UPDATE temi_location SET Status_success='IDLE' WHERE ID='$id'";
  $conn->query($sql3);
  sleep(1);
  $id++;
  sleep(3);
  $sql2 = "UPDATE health_box_symptoms SET Status_symptoms = 'IDLE' WHERE ID = '$id'";
  $conn->query($sql2);
  
     
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>

<?php
/*$servername = "localhost";
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
  sleep(20);
  $sql2 = "UPDATE health_box_symptoms SET Status_symptoms = 'IDLE' WHERE ID = '$id'";
  $conn->query($sql2);
  $id--;
  $sql3 = "UPDATE temi_location SET Status_success='IDLE' WHERE ID='$id'";
  $conn->query($sql3);
     
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();*/
?>
