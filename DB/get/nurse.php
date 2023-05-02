
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
            $sql = "SELECT * FROM nurse WHERE ID = $ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Fullname']) && !empty($_GET['Fullname'])){
            
            $Fullname = $_GET['Fullname'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Fullname มาให้แสดงเฉพาะข้อมูลของ Fullname นั้น
            $sql = "SELECT * FROM nurse WHERE Fullname = $Fullname";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Username']) && !empty($_GET['Username'])){
            
            $Username = $_GET['Username'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Username มาให้แสดงเฉพาะข้อมูลของ Username นั้น
            $sql = "SELECT * FROM nurse WHERE Username = $Username";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Password']) && !empty($_GET['Password'])){
            
            $Password = $_GET['Password'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Password มาให้แสดงเฉพาะข้อมูลของ Password นั้น
            $sql = "SELECT * FROM nurse WHERE Password = $Password";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['User_role']) && !empty($_GET['User_role'])){
            
            $User_role = $_GET['User_role'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า User_role มาให้แสดงเฉพาะข้อมูลของ User_role นั้น
            $sql = "SELECT * FROM nurse WHERE User_role = $User_role";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Hospital_ID']) && !empty($_GET['Hospital_ID'])){
            
            $Hospital_ID = $_GET['Hospital_ID'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Hospital_ID มาให้แสดงเฉพาะข้อมูลของ Hospital_ID นั้น
            $sql = "SELECT * FROM nurse WHERE Hospital_ID = $Hospital_ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else{
            $sql = "SELECT * FROM nurse";
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