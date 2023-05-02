<?php
// รับ parameter ID จาก URL
$id = $_GET["ID"];

// รับ request body และแปลงเป็น JSON object
$requestBody = json_decode(file_get_contents("php://input"));

// อัพเดทค่า Status_start เป็น IDLE ในฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

// สร้าง connection
$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// อัพเดทค่าในฐานข้อมูล
$sql = "UPDATE temi_start SET Status_start='" . $requestBody->Status_start . "' WHERE ID=" . $id;

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
