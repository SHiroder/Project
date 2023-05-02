<?php
//เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect("localhost","root","","registor");

//ตรวจสอบการเชื่อมต่อ
if (mysqli_connect_errno()){
    echo "ไม่สามารถเชื่อมต่อ MySQL: " . mysqli_connect_error();
}

//รับค่า ID จาก URL Parameter
if(isset($_GET['ID'])){
    $id = $_GET['ID'];
}else{
    $id = 0;
}

//เลือกข้อมูลจากตารางของฐานข้อมูล
$result = mysqli_query($conn, "SELECT * FROM room WHERE ID = ".$id);

//นำข้อมูลออกมาเป็น JSON Array
$data = array();
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
}

$response = array("data" => $data);
echo json_encode($response);

//ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
