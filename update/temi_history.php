<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the temi_id parameter is set
if (isset($_POST["temi_id"])) {
    $temiId = $_POST["temi_id"];

    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO temi_history (Temi_start_ID) VALUES (?)");
    $stmt->bind_param("s", $temiId);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: temi_id parameter is not set";
}

// Close the database connection
$conn->close();
?>
