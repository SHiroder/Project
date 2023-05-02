
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
            $sql = "SELECT * FROM patient WHERE ID = $ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////id           
        }else if(isset($_GET['Firstname']) && !empty($_GET['Firstname'])){
            $Firstname = $_GET['Firstname'];
            $sql = "SELECT * FROM patient WHERE Firstname = $Firstname";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   Firstname         
        }else if(isset($_GET['Lastname']) && !empty($_GET['Lastname'])){
            
            $Lastname = $_GET['Lastname'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Lastname มาให้แสดงเฉพาะข้อมูลของ Lastname นั้น
            $sql = "SELECT * FROM patient WHERE Lastname = $Lastname";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }
        else if(isset($_GET['Patientname']) && !empty($_GET['Patientname'])){
            $Patientname = $_GET['Patientname'];
            $sql = "SELECT * FROM patient WHERE Patientname = $Patientname";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   Firstname         
        }else if(isset($_GET['Gender']) && !empty($_GET['Gender'])){
            
            $Gender = $_GET['Gender'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Gender มาให้แสดงเฉพาะข้อมูลของ Gender นั้น
            $sql = "SELECT * FROM patient WHERE Gender = $Gender";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Height']) && !empty($_GET['Height'])){
            $Height = $_GET['Height'];
            $sql = "SELECT * FROM patient WHERE Height = $Height";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   Firstname         
        }else if(isset($_GET['Weight']) && !empty($_GET['Weight'])){
            
            $Weight = $_GET['Weight'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Weight มาให้แสดงเฉพาะข้อมูลของ Weight นั้น
            $sql = "SELECT * FROM patient WHERE Weight = $Weight";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['BMI']) && !empty($_GET['BMI'])){
            $BMI = $_GET['BMI'];
            $sql = "SELECT * FROM patient WHERE BMI = $BMI";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   BMI         
        }else if(isset($_GET['Age']) && !empty($_GET['Age'])){
            
            $Age = $_GET['Age'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Age มาให้แสดงเฉพาะข้อมูลของ Age นั้น
            $sql = "SELECT * FROM patient WHERE Age = $Age";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Room_ID_p']) && !empty($_GET['Room_ID_p'])){
            $Room_ID_p = $_GET['Room_ID_p'];
            $sql = "SELECT * FROM patient WHERE Room_ID_p = $Room_ID_p";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   Firstname         
        }else if(isset($_GET['Nurse_ID']) && !empty($_GET['Nurse_ID'])){
            
            $Nurse_ID = $_GET['Nurse_ID'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Nurse_ID มาให้แสดงเฉพาะข้อมูลของ Nurse_ID นั้น
            $sql = "SELECT * FROM patient WHERE Nurse_ID = $Nurse_ID";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Birthdate']) && !empty($_GET['Birthdate'])){
            $Birthdate = $_GET['Birthdate'];
            $sql = "SELECT * FROM patient WHERE Birthdate = $Birthdate";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   BMI         
        }else if(isset($_GET['Telephone']) && !empty($_GET['Telephone'])){
            
            $Telephone = $_GET['Telephone'];
            
            //คำสั่ง SQL กรณี มีการส่งค่า Telephone มาให้แสดงเฉพาะข้อมูลของ Telephone นั้น
            $sql = "SELECT * FROM patient WHERE Telephone = $Telephone";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////            
        }else if(isset($_GET['Time_now']) && !empty($_GET['Time_now'])){
            $Time_now = $_GET['Time_now'];
            $sql = "SELECT * FROM patient WHERE Time_now = $Time_now";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   BMI         
        }else{
            $sql = "SELECT * FROM patient";
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