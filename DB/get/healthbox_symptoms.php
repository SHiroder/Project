<?php
header("Content-Type: application/json");

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID parameter from the request URL
$Temi_ID = $_GET['Temi_ID'] ?? '';

if (!empty($Temi_ID)) {
    // Prepare and execute the SQL query
    $sql = "SELECT * FROM health_box_symptoms WHERE Temi_ID = $Temi_ID";
    $result = $conn->query($sql);

    // Create JSON response
    $response = array();

    if ($result && $result->num_rows > 0) {
        $response["success"] = true;
        $response["message"] = "Data found";
        $response["data"] = array();

        // Loop through the data and add to the response
        while ($row = $result->fetch_assoc()) {
            $data = array();
            $data["ID"] = $row["ID"];
            $data["Temi_ID"] = $row["Temi_ID"];
            $data["Status_symptoms"] = $row["Status_symptoms"];
            // Add more fields as needed
            array_push($response["data"], $data);
        }
    } else {
        $response["success"] = false;
        $response["message"] = "No data found";
    }
} else {
    $response["success"] = false;
    $response["message"] = "Invalid ID parameter";
}

// Return the response as JSON
echo json_encode($response);

// Close the database connection
$conn->close();
?>
