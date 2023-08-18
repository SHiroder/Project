<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from request
$data = json_decode(file_get_contents('php://input'), true);
$hospitalId = $data['Hospital_ID'];
$room = $data['Room'];

// Check if the room already exists in the database
$sql = "SELECT * FROM room WHERE Room = '$room'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Room does not exist, insert new data
    $sql = "INSERT INTO room (Hospital_ID, Room) VALUES ('$hospitalId', '$room')";
    
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Data inserted successfully');
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to insert data');
        echo json_encode($response);
    }
} else {
    // Room already exists, skip insertion
    $response = array('status' => 'success', 'message' => 'Room already exists');
    echo json_encode($response);
}

$conn->close();

?>
