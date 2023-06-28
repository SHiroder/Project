<?php
// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบค่าที่ส่งมาจากหน้าเว็บ
if (isset($_POST['id']) && isset($_POST['status'])) {
  $id = $_POST['id'];
  $status = $_POST['status'];

  // อัปเดตสถานะของสวิตช์ในฐานข้อมูล
  $sql = "UPDATE patient SET switch_status = '$status' WHERE IDp = '$id'";

  if ($conn->query($sql) === TRUE) {
    echo "Status updated successfully";
  } else {
    echo "Error updating status: " . $conn->error;
  }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
