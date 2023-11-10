<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

$conn = new mysqli($servername, $username, $password, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับค่า IDp จากการร้องขอ
$IDp = $_GET['IDp']; // เปลี่ยนเป็นชื่อคอลัมน์ที่ถูกต้อง
$sql = "SELECT SpO2, Temp, Pulse, DATE(Time_latest) AS DateOnly FROM patient_symptoms WHERE patient_ID = '$IDp' ORDER BY Time_latest DESC LIMIT 30";

$result = $conn->query($sql);

$spo2_data = array();
$date_data = array();
$pulse_data = array();
$temp_data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $spo2_data[] = $row["SpO2"];
        $date_data[] = $row["DateOnly"];
        $temp_data[] = $row["Temp"];
        $pulse_data[] = $row["Pulse"];
    }
}

// สร้าง JSON สำหรับส่งคืนข้อมูล
$data = array(
    "spo2_data" => $spo2_data,
    "date_data" => $date_data,
    "pulse_data" => $pulse_data,
    "temp_data" => $temp_data
);

header('Content-Type: application/json');
echo json_encode($data);

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
