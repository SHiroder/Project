<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input1 = $_POST['input1'];
  $input2 = $_POST['input2'];
  $input3 = $_POST['input3'];
  $input4 = $_POST['input4'];
  $input5 = "Home base";
  $input6 = $_POST['input6'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "registor";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // ใช้ parameterized query
  $stmt = $conn->prepare("INSERT INTO room (input1, input2, input3, input4, input5, input6) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $input1, $input2, $input3, $input4, $input5, $input6);

  if ($stmt->execute() === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}

?>