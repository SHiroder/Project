<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input1 = $_POST['input1'];
  $input2 = $_POST['input2'];
  $input3 = $_POST['input3'];
  $input4 = $_POST['input4'];
  $hospitalID = $_POST['Caretaker']; // รับค่า Hospital ID ที่เลือกจากฟอร์ม
  $temiID = 1; // กำหนดค่า Temi_ID เป็น 1

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "registor";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO room (Hospital_ID, Room) VALUES (?, ?)");

  if (!empty($input1)) {
    $stmt->bind_param("is", $hospitalID, $input1);
    if ($stmt->execute()) {
      echo "New record created successfully for Room 1";
      $stmt = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
      $stmt->bind_param("i", $temiID);
      $stmt->execute();
    } else {
      echo "Error: " . $stmt->error;
    }
  }

  if (!empty($input2)) {
    $stmt2 = $conn->prepare("INSERT INTO room (Hospital_ID, Room) VALUES (?, ?)");

    $stmt2->bind_param("is", $hospitalID, $input2);
    if ($stmt2->execute()) {
      echo "New record created successfully for Room 2";
      $stmt2 = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
      $stmt2->bind_param("i", $temiID);
      $stmt2->execute();
    } else {
      echo "Error: " . $stmt->error;
    }
  }

  if (!empty($input3)) {
    $stmt3 = $conn->prepare("INSERT INTO room (Hospital_ID, Room) VALUES (?, ?)");

    $stmt3->bind_param("is", $hospitalID, $input3);
    if ($stmt3->execute()) {
      echo "New record created successfully for Room 3";
      $stmt3 = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
      $stmt3->bind_param("i", $temiID);
      $stmt3->execute();
    } else {
      echo "Error: " . $stmt->error;
    }
  }

  if (!empty($input4)) {
    $stmt4 = $conn->prepare("INSERT INTO room (Hospital_ID, Room) VALUES (?, ?)");

    $stmt4->bind_param("is", $hospitalID, $input4);
    if ($stmt4->execute()) {
      echo "New record created successfully for Room 4";
      $stmt4 = $conn->prepare("INSERT INTO temi_location (Temi_ID, Status_success) VALUES (?, 'IDLE')");
      $stmt4->bind_param("i", $temiID);
      $stmt4->execute();
    } else {
      echo "Error: " . $stmt->error;
    }
  }
  header("location: nurse.php");

  $stmt->close();
  $conn->close();
}

?>
