<?php
    // 1. Set up database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registor";

    // 2. Receive data from Android Application
    $locationId = $_POST["ID"] ?? '';
    $statusSuccess = $_POST["status_success"] ?? '';
    
    // 3. Connect to database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
 /*   $temiID = 2;
    $sql = "INSERT INTO temi_history (Temi_start_ID) VALUES ($temiID)";

    if ($conn->query($sql) === TRUE) {
    echo "เพิ่มข้อมูลเรียบร้อยแล้ว";
    } else {
    echo "การเพิ่มข้อมูลผิดพลาด: " . $conn->error;
    }
*/

    // 4. Update data in temi_location table
    $sql1 = "UPDATE temi_location SET Status_success='$statusSuccess' WHERE ID='$locationId'";
    if ($conn->query($sql1) === TRUE) {
        echo "Location updated successfully";
      
    } else {
        echo "Error updating location: " . $conn->error;
    }

    // 5. Close database connection
    $conn->close();
?>