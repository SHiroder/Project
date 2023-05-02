<?php
// Create a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if (isset($_POST["temi_id"])) {
    // Prepare and bind the insert statement
    $stmt = $conn->prepare("INSERT INTO temi_history (Temi_ID) VALUES (?)");
    $stmt->bind_param("s", $temiId);

    // Set the parameter values and execute the statement
    $temiId = $_POST["temi_id"];
    $stmt->execute();

    // Check if the insert was successful
    if ($stmt->affected_rows > 0) {
        echo "Data inserted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
} else {
    echo "Error: temi_id parameter is not set";
}

$conn->close();

?>
