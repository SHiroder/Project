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

// ตรวจสอบค่าที่ส่งมาจาก HTTP POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $temiId = $_POST["temi_id"];

    // ตรวจสอบว่ามีค่า temi_id ที่ส่งมาหรือไม่
    if (!empty($temiId)) {
        // เตรียมคำสั่ง SQL สำหรับแทรกข้อมูล
        $sql = "INSERT INTO temi_history (Temi_ID) VALUES (?)";

        // เตรียม statement และผูกค่าพารามิเตอร์
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $temiId);

        // ส่งคำสั่ง SQL ไปประมวลผล
        if ($stmt->execute()) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $stmt->error;
        }
    } else {
        echo "Invalid temi_id value";
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
