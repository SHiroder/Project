<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM temi_location WHERE Status_success = 'success'";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$sql2 = "SELECT * FROM health_box_symptoms WHERE Status_symptoms = 'success'";
$result2 = $conn->query($sql2);

$data2 = [];

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2;
    }
}

$sql3 = "SELECT * FROM patient INNER JOIN room ON patient.Room_ID_p = room.ID WHERE patient.switch_status = 1";

$result3 = $conn->query($sql3);

$data3 = [];

if ($result3->num_rows > 0) {
    while ($row3 = $result3->fetch_assoc()) {
        $data3[] = $row3;
    }
}

$conn->close();

$combinedData = [
    'temi_location' => $data,
    'health_box_symptoms' => $data2,
    'patient' => $data3
];

header('Content-Type: application/json'); 
echo json_encode($combinedData);
?>
