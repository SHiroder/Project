<?php

header("Content-Type: application/json");

// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// prepare and execute the SQL query
$sql = "SELECT * FROM room ";
$result = $conn->query($sql);

// create JSON response
$response = array();

if ($result->num_rows > 0) {
    $response["success"] = true;
    $response["message"] = "Data found";
    $response["data"] = array();

    // loop through the data and add to the response
    while ($row = $result->fetch_assoc()) {
        $data = array();
        $data["ID"] = $row["ID"];
        $data["Hospital_ID"] = $row["Hospital_ID"];
        $data["Room"] = $row["Room"];
        // add more fields as needed
        array_push($response["data"], $data);
    }
} else {
    $response["success"] = false;
    $response["message"] = "No data found";
}

// return the response as JSON
echo json_encode($response);

// close the database connection

?>
