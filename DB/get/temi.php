
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
            $sql = "SELECT * FROM temi WHERE ID = $ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Room_ID']) && !empty($_GET['Room_ID'])){
            
            $Room_ID = $_GET['Room_ID'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Room_ID มาให้แสดงเฉพาะข้อมูลของ Room_ID นั้น
            $sql = "SELECT * FROM temi WHERE Room_ID = $Room_ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Operation_Status']) && !empty($_GET['Operation_Status'])){
            
            $Operation_Status = $_GET['Operation_Status'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า temi มาให้แสดงเฉพาะข้อมูลของ temi นั้น
            $sql = "SELECT * FROM temi WHERE Operation_Status = $Operation_Status";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else{
            $sql = "SELECT * FROM temi";
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