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
  sleep(30);
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
          // Check if the Status_success is success in the health_box_symptoms table
  $sql2 = "SELECT * FROM health_box_symptoms WHERE ID='$id'";
  $result = $conn->query($sql2);
  if ($result->num_rows > 0) {
    $row2 = $result->fetch_assoc();
    $data222 = array("ID"=> $row2['ID'],"Temi_ID"=>$row2['Temi_ID'],"Status_success"=>$row2['Status_symptoms']);
    
    if($row2['Status_symptoms'] == 'success'){
        // Update Status_success to IDLE in temi_location table
        $sql3 = "UPDATE temi_location SET Status_success='IDLE' WHERE ID='$id'";
        if ($conn->query($sql3) === TRUE) {
            echo "IDLE updated successfully";
            sleep(2);
            $sql4 = "UPDATE health_box_symptoms SET Status_symptoms='IDLE' WHERE ID='$id'";
            $conn->query($sql4);
        } else {
            echo "Error updating IDLE: " . $conn->error;
        }
      }
    }else {
    echo "Error updating location: " . $conn->error;
    }
  
  $sqlidle = "UPDATE health_box_symptoms SET Status_symptoms = 'IDLE' WHERE ID = '$id'";
  $conn->query($sqlidle);
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();*/
?>
