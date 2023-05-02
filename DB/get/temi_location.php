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

    // 4. Update data in temi_location table
    $sql1 = "UPDATE temi_location SET Status_success='$statusSuccess' WHERE ID='$locationId'";
    if ($conn->query($sql1) === TRUE) {
        echo "Location updated successfully";

        // Check if the Status_success is success in the health_box_symptoms table
        $sql2 = "SELECT * FROM health_box_symptoms WHERE ID='$locationId'";
        $result = $conn->query($sql2);

        if ($result->num_rows > 0) {
            $row2 = $result->fetch_assoc();
            $data222 = array("ID"=> $row2['ID'],"Temi_ID"=>$row2['Temi_ID'],"Status_success"=>$row2['Status_symptoms']);

            if($row2['Status_symptoms'] == 'success'){
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
        echo "Error updating location: " . $conn->error;
    }

    // 5. Close database connection
    $conn->close();
?>