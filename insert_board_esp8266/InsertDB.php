<?php
//Creates new record as per request
    //Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registor";

    try {
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        echo "connected";
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $conn->prepare("INSERT INTO patient_symptoms(Patient_ID,SpO2, Pulse, Temp) 
                                            VALUES(:Patient_ID,:SpO2,:Pulse,:Temp)");
    $stmt->bindParam(':Patient_ID', $Patient_ID, PDO::PARAM_STR);
    $stmt->bindParam(':SpO2', $SpO2, PDO::PARAM_STR);
    $stmt->bindParam(':Pulse', $Pulse, PDO::PARAM_STR);
    $stmt->bindParam(':Temp', $Temp, PDO::PARAM_STR);

    $Patient_ID = isset($_POST['Patient_ID']) ? $_POST['Patient_ID'] : ''; 
    $SpO2 = isset($_POST['spo2']) ? $_POST['spo2'] : ''; 
    $Pulse = isset($_POST['pulse']) ? $_POST['pulse'] : '';
    $Temp = isset($_POST['temp']) ? $_POST['temp'] : '';
    $result = $stmt->execute();

    if ($result) {
        echo "OK";
        $stmt2 = $conn->prepare("INSERT INTO healthbox_history(Patient_ID,Healthbox_ID) 
                                            VALUES(:Patient_ID,:Healthbox_ID)");
        $stmt2->bindParam(':Patient_ID', $Patient_ID, PDO::PARAM_STR);
        $stmt2->bindParam(':Healthbox_ID', $Healthbox_ID, PDO::PARAM_STR);

        $Patient_ID = isset($_POST['Patient_ID']) ? $_POST['Patient_ID'] : ''; 
        $Healthbox_ID = isset($_POST['Healthbox_ID']) ? $_POST['Healthbox_ID'] : ''; 

        $result2 = $stmt2->execute();
        $newTimestamp = date("Y-m-d H:i:s"); // Get the current date and time in the desired format

 
        $sql2 = "UPDATE patient SET Time_now= '$newTimestamp' WHERE IDp = $Patient_ID";
        $conn->query($sql2);
    } else {
        // Handle error here
    }
?>
