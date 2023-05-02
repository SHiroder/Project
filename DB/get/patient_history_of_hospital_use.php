
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
            $sql = "SELECT * FROM patient_history_of_hospital_use WHERE ID = $ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Patient_ID']) && !empty($_GET['Patient_ID'])){
            
            $Patient_ID = $_GET['Patient_ID'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Patient_ID มาให้แสดงเฉพาะข้อมูลของ Patient_ID นั้น
            $sql = "SELECT * FROM patient_history_of_hospital_use WHERE Patient_ID = $Patient_ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Frequebcy']) && !empty($_GET['Frequebcy'])){
            
            $Frequebcy = $_GET['Frequebcy'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Frequebcy มาให้แสดงเฉพาะข้อมูลของ Frequebcy นั้น
            $sql = "SELECT * FROM patient_history_of_hospital_use WHERE Frequebcy = $Frequebcy";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else{
            $sql = "SELECT * FROM patient_history_of_hospital_use";
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