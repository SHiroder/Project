<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

// Create a MySQLi instance
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query
$query = "SELECT * FROM temi_location WHERE ID = 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Fetch the result as associative array
    $row = $result->fetch_assoc();

    // Create a response object
    $response = array();
    $response['Status_success'] = $row['Status_success'];

    // Set the response header
    header('Content-Type: application/json');

    // Send the JSON response
    echo json_encode($response);

    // Fetch health_box_symptoms data
    $sql2 = "SELECT * FROM health_box_symptoms WHERE ID = '$locationId'";
    $result2 = $conn->query($sql2);

    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $data222 = array(
            "ID" => $row2['ID'],
            "Temi_ID" => $row2['Temi_ID'],
            "Status_success" => $row2['Status_symptoms']
        );
        sleep(3);
        if ($row2['Status_symptoms'] == 'success') {
            // Update Status_success to IDLE in temi_location table
            $sql3 = "UPDATE temi_location SET Status_success='IDLE' WHERE ID='$locationId'";
            if ($conn->query($sql3) === TRUE) {
                echo "IDLE updated successfully";
            } else {
                echo "Error updating IDLE: " . $conn->error;
            }
        }
    }
} else {
    echo "No data found";
}

// Close the database connection
$conn->close();
?>
