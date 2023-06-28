<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input1 = $_POST['input1'];
  $input2 = $_POST['input2'];
  $input3 = $_POST['input3'];
  $input4 = $_POST['input4'];
  $input5 = "Home base";


  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "registor";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // ใช้ parameterized query
  $stmt = $conn->prepare("INSERT INTO room (input1) VALUES (?)");
  $stmt->bind_param("ssssss", $input1);
  $stmt = $conn->prepare("INSERT INTO room (input2) VALUES (?)");
  $stmt->bind_param("ssssss", $input2);
  $stmt = $conn->prepare("INSERT INTO room (input3) VALUES (?)");
  $stmt->bind_param("ssssss", $input3);
  $stmt = $conn->prepare("INSERT INTO room (input4) VALUES (?)");
  $stmt->bind_param("ssssss", $input4);
  $stmt = $conn->prepare("INSERT INTO room (input5) VALUES (?)");
  $stmt->bind_param("ssssss", $input5);
  $temiID = 1;
  $stmt = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
  $stmt->bind_param("i", $temiID);
  $stmt = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
  $stmt->bind_param("i", $temiID);
  $stmt = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
  $stmt->bind_param("i", $temiID);
  $stmt = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
  $stmt->bind_param("i", $temiID);
  $stmt = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
  $stmt->bind_param("i", $temiID);


  

  if ($stmt->execute() === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}

?>