
<?php
    //กำหนดค่า Access-Control-Allow-Origin ให้ เครื่อง อื่น ๆ สามารถเรียกใช้งานหน้านี้ได้
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    //ตั้งค่าการเชื่อมต่อฐานข้อมูล
    $link = mysqli_connect('localhost', 'root', '', 'registor');
    mysqli_set_charset($link, 'utf8');
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    
    //ตรวจสอบหากใช้ Method GET
    if($requestMethod == 'GET'){
        //ตรวจสอบการส่งค่า id
        if(isset($_GET['ID']) && !empty($_GET['ID'])){
            
            $ID = $_GET['ID'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า ID มาให้แสดงเฉพาะข้อมูลของ ID นั้น
            $sql = "SELECT * FROM patient_symptoms WHERE ID = $ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Patient_ID']) && !empty($_GET['Patient_ID'])){
            
            $Patient_ID = $_GET['Patient_ID'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Patient_ID มาให้แสดงเฉพาะข้อมูลของ Patient_ID นั้น
            $sql = "SELECT * FROM patient_symptoms WHERE Patient_ID = $Patient_ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['SpO2']) && !empty($_GET['SpO2'])){
            
            $SpO2 = $_GET['SpO2'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า SpO2 มาให้แสดงเฉพาะข้อมูลของ SpO2 นั้น
            $sql = "SELECT * FROM patient_symptoms WHERE SpO2 = $SpO2";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Pulse']) && !empty($_GET['Pulse'])){
            
            $Pulse = $_GET['Pulse'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Pulse มาให้แสดงเฉพาะข้อมูลของ Pulse นั้น
            $sql = "SELECT * FROM patient_symptoms WHERE Pulse = $Pulse";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Temp']) && !empty($_GET['Temp'])){
            
            $Temp = $_GET['Temp'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Temp มาให้แสดงเฉพาะข้อมูลของ Temp นั้น
            $sql = "SELECT * FROM patient_symptoms WHERE Temp = $Temp";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else{
            $sql = "SELECT * FROM patient_symptoms";
        }
        $result = mysqli_query($link, $sql);
//สร้างตัวแปร array สำหรับเก็บข้อมูลที่ได้
        $arr = array();
        while ($row = mysqli_fetch_assoc($result)) {
             $arr[] = $row;
        }
        echo json_encode($arr);
    }
    ?>