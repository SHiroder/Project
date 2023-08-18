<?php 

session_start();
include_once 'DB/connect.php';

if (isset($_POST['signup_pa'])) {
    
    $Firstname = $_POST['Firstname'];
    $Lastname = $_POST['Lastname'];
    $Patientname =$_POST['Firstname']. ' ' .$_POST['Lastname'];
    $Gender = $_POST['Gender'];
    $Height = $_POST['Height'];
    $Weight = $_POST['Weight'];
    $Room = $_POST['Room'];
    $Caretaker = $_POST['Caretaker'];
    $Birthdate = $_POST['Birthdate'];
    $Telephone = $_POST['Telephone'];

    if (empty($Firstname)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อ';
        header("location: registor.php");
    } else if (empty($Lastname)) {
        $_SESSION['error'] = 'กรุณากรอกนามสกุล';
        header("location: registor.php");
    } else {
        try {
            
            date_default_timezone_set('Asia/Bangkok');
            $currentDate  = date('Y-m-d'); 
            $diff = abs(strtotime($currentDate) - strtotime($Birthdate)); 
            $years = floor($diff / (365*60*60*24));
            $Age = $years;
            $BMI = ((int)$Weight /(((int)$Height * (int)$Height))*10000);
            $check_Patientname= $conn->prepare("SELECT * FROM patient WHERE Patientname = ?");
            $check_Patientname->bind_param("s", $Patientname);
            $check_Patientname->execute();
            $result = $check_Patientname->get_result();
            $row = $result->fetch_assoc();
            
            if ($row && $row['Patientname'] == $Patientname){
                echo '<script> alert("มีผู้ป่วยนี้อยู่ในระบบแล้ว")</script>';
                header('Refresh:0; url=../nurse.php');
            } else {
                $sql = "INSERT INTO `patient`(`Firstname`, `Lastname`, `Patientname`, `Gender`, `Height`, `Weight`, `BMI`, `Age`, `Room_ID_p`, `Nurse_ID`, `Birthdate`, `Telephone`, `switch_status`)
                    VALUES (
                        '".htmlspecialchars($Firstname, ENT_QUOTES, 'UTF-8')."',
                        '".htmlspecialchars($Lastname, ENT_QUOTES, 'UTF-8')."',
                        '".htmlspecialchars($Patientname, ENT_QUOTES, 'UTF-8')."',
                        '".htmlspecialchars($Gender, ENT_QUOTES, 'UTF-8')."',
                        '".$Height."',
                        '".$Weight."',
                        '".$BMI."',
                        '".$Age."',
                        '".htmlspecialchars($Room, ENT_QUOTES, 'UTF-8')."',
                        '".htmlspecialchars($Caretaker, ENT_QUOTES, 'UTF-8')."',
                        '".htmlspecialchars($Birthdate, ENT_QUOTES, 'UTF-8')."',
                        '".htmlspecialchars($Telephone, ENT_QUOTES, 'UTF-8')."',
                        '1' 
                    )";
        
                    if(mysqli_query($conn,$sql)){
                        echo '<script> alert("Success")</script>';
                        header('Refresh:2; url=nurse.php');
                    }else{
                        echo '<script> alert("Failed")</script>';
                    }

                }
        } catch(PDOException $e) {
            
        }
    }
}
if(!isset($_SESSION['nurse_login'])){
    header("location: index.php");
}
if (isset($_SESSION['nurse_login'])) {
    
    $users_id = $_SESSION['nurse_login'];
    $stmt = $conn->query("SELECT * FROM nurse WHERE ID = $users_id");
    $row = $stmt->fetch_assoc();
}

if (isset($_REQUEST['delete_id'])) {
    $id = $_REQUEST['delete_id'];
    $deleteHistoryStmt = $conn->prepare('DELETE FROM patient_history_of_hospital_use WHERE Patient_ID = ?');
    $deleteHistoryStmt->bind_param('s', $id);
    $deleteHistoryStmt->execute();
    // ลบข้อมูลในตาราง patient
    $deleteStmt = $conn->prepare('DELETE FROM patient WHERE IDp = ?');
    $deleteStmt->bind_param('i', $id);
    $deleteStmt->execute();
    
    // ลบข้อมูลในตาราง patient_history_of_hospital_use
    
    
    header("location: nurse.php");
}



if (isset($_REQUEST['stop_id'])) {
    $patientID = $_GET['stop_id'];

    // ตรวจสอบว่ามีข้อมูลในตาราง patient_history_of_hospital_use สำหรับ Patient_ID นี้หรือไม่
    $checkStmt = $conn->prepare('SELECT * FROM patient_history_of_hospital_use WHERE Patient_ID = ?');
    $checkStmt->bind_param('s', $patientID);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // ถ้ามีข้อมูลอยู่แล้ว อัปเดตค่า Frequency, switch_status, และ Time_now
        $updateStmt = $conn->prepare('UPDATE patient_history_of_hospital_use SET Frequency = Frequency + 1, time_now = NOW() WHERE Patient_ID = ?');
        $updateStmt->bind_param('s', $patientID);
        $updateStmt->execute();

        $updatePatientStmt = $conn->prepare('UPDATE patient SET switch_status = 0 WHERE IDp = ?');
        $updatePatientStmt->bind_param('s', $patientID);
        $updatePatientStmt->execute();

    } else {
        // ถ้ายังไม่มีข้อมูล ทำการเพิ่มข้อมูลใหม่
        $insertStmt = $conn->prepare('INSERT INTO patient_history_of_hospital_use (patient_id, Frequency, time_now) VALUES (?, 1, NOW())');
        $insertStmt->bind_param('s', $patientID);
        $insertStmt->execute();

        $updatePatientStmt = $conn->prepare('UPDATE patient SET switch_status = 0 WHERE IDp = ?');
        $updatePatientStmt->bind_param('s', $patientID);
        $updatePatientStmt->execute();
    }
}



$select_stmt = $conn->prepare('SELECT * FROM Temi_start ');
$select_stmt->execute();
$result = $select_stmt->get_result();
foreach($result as $row3)


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Robot Covid-19</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<style>
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
margin: 0;
padding: 0;
outline: none;
box-sizing: border-box;
font-family: 'Poppins', sans-serif;

}
body{
height: 100vh;
width: 100%;
background: linear-gradient(115deg, #8bc34a 5%, #f9fbe7 95%);
zoom: 75%
}
.show-btn{

font-size: 16px;
height: -80px;
color: black;
cursor: pointer;

}
.show-btn, .container{
position: absolute;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
}
input[type="checkbox"]{
display: none;
}
.container{
display: none;
background: #fff;
top: 100%;
right: 6000px;
weight: 800px;
width: 4100px;

padding: 30px;
box-shadow: 0 0 8px rgba(0,0,0,0.1);
}
#show:checked ~ .container{
display: block;
scale: 0.7;
height: 800px;
weight: 800px;
}
.container .close-btn{
position: absolute;
right: 20px;
top: 1500px;
font-size: 18px;
cursor: pointer;
}
.container .close-btn:hover{
color: #3498db;
}
.container .text{
font-size: 35px;
font-weight: 600;
text-align: center;
}
.container form{
margin-top: -20px;
}
.container form .data{
height: 45px;
width: 100%;
margin: 40px 0;
}
form .data label{
font-size: 18px;
}
th, td {
text-align: left;
padding: 8px;
}
th {
background-color: #008080;
color: white;
}
tr:nth-child(even) {
background-color: #f2f2f2;
}
form .data input{
height: 100%;
width: 100%;
padding-left: 10px;
font-size: 17px;
border: 1px solid silver;
}
form .data input:focus{
border-color: #3498db;
border-bottom-width: 2px;
}
form .forgot-pass{
margin-top: -8px;
}
form .forgot-pass a{
color: #3498db;
text-decoration: none;
}
form .forgot-pass a:hover{
text-decoration: underline;
}
form .btn{
margin: 30px 0;
height: 45px;
width: 100%;
position: relative;
overflow: hidden;
}
form .btn .inner{
height: 100%;
width: 300%;
position: absolute;
left: -100%;
z-index: -1;
background: -webkit-linear-gradient(right, #56d8e4, #9f01ea, #56d8e4, #9f01ea);
transition: all 0.4s;
}
form .btn:hover .inner{
left: 0;
}
form .btn button{
height: 100%;
width: 100%;
background: none;
border: none;
color: #fff;
font-size: 18px;
font-weight: 500;
text-transform: uppercase;
letter-spacing: 1px;
cursor: pointer;
}
form .signup-link{
text-align: left;
}
form .signup-link a{
color: #3498db;
text-decoration: none;
}
form .signup-link a:hover{
text-decoration: underline;
}
.sidebar {
position: fixed;
top: 0;
bottom: 0;
        left: 0;
        z-index: 90;
        padding: 90px 0 0;
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        z-index: 99;
    }

    @media (max-width: 767.98px) {
        .sidebar {
            top: 11.5rem;
            padding: 0;
        }
    }
        
    .navbar {
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .1);
    }

    @media (min-width: 767.98px) {
        .navbar {
            top: 0;
            position: sticky;
            z-index: 999;
        }
    }

    .sidebar .nav-link {
        color: #333;
    }

    .sidebar .nav-link.active {
        color: #0d6efd;
    }

    .popup .content{
        position: absolute;
        top:0%;
        left:50%;
        transform:translate(-50%,-50%);
        background:#fff;
        width:70%;
        height:auto;
        z-index:2;
        text-align:center;
        padding:20px;
        box-sizing:border-box;
    }
.popup1 .overlay{
width: 5000px;
height: 50000px;
position:fixed;
top:-620px;
left:-1000px;    
height:1000vh;
background:rgba(0,0,0,0.93);
z-index:1;
}
    .popup1 .content{
        position: absolute;
        top:0%;
        left:50%;
        transform:translate(-50%,-50%);
        background:#fff;
        width:70%;
        height:auto;
        z-index:2;
        text-align:center;
        padding:20px;
        box-sizing:border-box;
    }
    .popup2 .overlay{
        width: 5000px;
height: 50000px;
position:fixed;
        top:-620px;
        left:-1000px;
        
        height:1000vh;
        background:rgba(0,0,0,0.93);
        z-index:1;
    }
    .popup2 .content{
        position: absolute;
        top:0%;
        left:50%;
        transform:translate(-50%,-50%);
        background:#fff;
        width:70%;
        height:auto;
        z-index:2;
        text-align:center;
        padding:20px;
        box-sizing:border-box;
    }
    .popup3 .overlay{
width: 5000px;
height: 50000px;
position:fixed;
top:-620px;
left:-1000px;    
height:1000vh;
background:rgba(0,0,0,0.93);
z-index:1;
}
    .popup3 .content{
        position: absolute;
        top:0%;
        left:50%;
        transform:translate(-50%,-50%);
        background:#fff;
        width:70%;
        height:auto;
        z-index:2;
        text-align:center;
        padding:20px;
        box-sizing:border-box;
    }
    .popup{
        width: 70%;
height: Auto;
background:rgba(255,255,255);
border-radius: 10px;
position:fixed;
top: -100px;
left:55%;
transform: translate(-50%,-50%) ; 
text-align:center;
padding: 0 30px 30px;
color:#000;
visibility: hidden;
transition: transfrom 0.4s, top 0.4s;
align-self: start;
z-index: 1;

}
.open-popup{
visibility:visible;

top:60% ;
transform:translate(-50%,-50% scale(1));
}
.popup3{
        width: 70%;
height: Auto;
background:rgba(255,255,255);
border-radius: 10px;
position:fixed;
top: -100px;
left:55%;
transform: translate(-50%,-50%) ; 
text-align:center;
padding: 0 30px 30px;
color:#000;
visibility: hidden;
transition: transfrom 0.4s, top 0.4s;
align-self: start;
z-index: 1;

}
.open-popup3{
visibility:visible;

top:50% ;
transform:translate(-50%,-50% scale(1));
}
.popup1{
        width: 100%;
height: Auto;
position: fixed;
background:#999;
border-radius: 10px;
position:fixed;
top: 50%;
left:55%;
transform: translate(-50%,-50%) ; 
text-align:center;
padding: 0 30px 30px;
color:#000;
visibility: hidden;
transition: transfrom 0.4s, top 0.4s;
align-self: start;
}
.open-popup1{
visibility:visible;

top:50% ;
transform:translate(-50%,-50% scale(1));
}
.popup4{
        width: 70%;
height: Auto;
background:rgba(255,255,255);
border-radius: 10px;
position:fixed;
top: -100px;
left:55%;
transform: translate(-50%,-50%) ; 
text-align:center;
padding: 0 30px 30px;
color:#000;
visibility: hidden;
transition: transfrom 0.4s, top 0.4s;
align-self: start;
z-index: 1;

}
.open-popup4{
visibility:visible;

top:50% ;
transform:translate(-50%,-50% scale(1));
}
.popup3{
        width: 50%;
height: Auto;
position: fixed;
background:#999;
border-radius: 10px;
position:fixed;
top: 50%;
left:55%;
transform: translate(-50%,-50%) ; 
text-align:center;
padding: 0 30px 30px;
color:#000;
visibility: hidden;
transition: transfrom 0.4s, top 0.4s;
align-self: start;
}
.open-popup3{
visibility:visible;

top:50% ;
transform:translate(-50%,-50% scale(1));
}
.popup2{
width: 100%;
height: 100%;
position: fixed;
background:#999;
border-radius: 10px;
position:fixed;
top: 0%;
left:55%;
transform: translate(-50%,-50%) ; 
text-align:center;
padding: 0 30px 30px;
color:#000;
visibility: hidden;
transition: transfrom 0.4s, top 0.4s;
align-self: start;
}
.open-popup2{
visibility:visible;
top:650px ;
transform:translate(-50%,-50% scale(1));
}
.btn{
background:none;
color:#000;
text-transform:uppercase;
padding: 12px 20px;
min-width:200px;
margin:10px;
cursor: pointer;
transition: color 0.4s linear;
position:relative;
}
.btn:hover{
color:#fff;

}
.btn::before{
content:"";
position:absolute;
left:0;
top:0;
width:100%;
height:100%;
background: Green;
z-index:-1;
transition: transform 0.2s;
transform-origin:0 0;
transition-timing-function: cubic-bezier(0.5,1.6,0.4,0.7);

}

.btn1::before{
transform:scaleX(1);

}
.btn1:hover::before{
transform:scaleX(0);
}
.btn2::before{
transform:scaleX(0);
}
.btn2:hover::before{
transform:scaleX(1);

}
.btn3::before{
transform:scaleX(0);
}
.btn3:hover::before{
transform:scaleX(1);
}.btn4::before{
transform:scaleX(0);
}
.btn4:hover::before{
transform:scaleX(1);
}
.feather:hover{
color:#fff;
}
.feather::before{
content:"";
position:absolute;
left:0;
top:0;
width:100%;
height:100%;
background: Green;
z-index:-1;
transition: transform 0.5s;
transform-origin:0 0;
transition-timing-function: cubic-bezier(0.5,1.6,0.4,0.7);
}
.popup .overlay{
        width: 5000px;
height: 50000px;
position:fixed;
top:-620px;
left:-1000px;
        
height:1000vh;
background:rgba(0,0,0,0.93);
z-index:1;
}
.switch {
position: relative;
display: inline-block;
width: 40px;
height: 24px;
}

.switch-on {
background-color: #66BB6A;
}

.switch-off {
background-color: #E0E0E0;
}

.switch .slider {
position: absolute;
cursor: pointer;
top: 0;
left: 0;
right: 0;
bottom: 0;
background-color: grey;
-webkit-transition: .4s;
transition: .4s;
}

.switch .slider:before {
position: absolute;
content: "";
height: 16px;
width: 16px;
left: 4px;
bottom: 4px;
background-color: black;
-webkit-transition: .4s;
transition: .4s;
}

.switch-checkbox {
display: none;
}

.switch-checkbox:checked + .slider {
background-color: #66BB6A;
}

.switch-checkbox:checked + .slider:before {
transform: translateX(16px);
}

.switch-checkbox:focus + .slider {
box-shadow: 0 0 1px #66BB6A;
}
.popup4 .overlay{
        width: 5000px;
height: 50000px;
position:fixed;
        top:-620px;
        left:-1000px;
        
        height:1000vh;
        background:rgba(0,0,0,0.93);
        z-index:1;
    }
    .popup4 .content{
        position: absolute;
        top:0%;
        left:50%;
        transform:translate(-50%,-50%);
        background:#fff;
        width:70%;
        height:auto;
        z-index:2;
        text-align:center;
        padding:20px;
        box-sizing:border-box;
    }

</style>
</head>

<body style="font-family:Segoe UI Black;">
<nav class="navbar navbar-light bg-light p-3">
    <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
        <a class="navbar-brand" href="nurse.php" style ="font-size: 30px;font-weight: bold;">
        ROBOT COVID-19
        </a>
        <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="col-12 col-md-4 col-lg-2">

        <div class="dropdown">
        
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
            <?php  echo $row['Fullname']?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style ="width:50%">
            <li><a class="dropdown-item" href="setting.php" style="text-align: center;">ตั้งค่า</a></li>
            <li><a class="dropdown-item" href="Gmail_Sender/index.php" style="text-align: center;">เมล</a></li>
            <li><a class="dropdown-item" href="logout.php" style="text-align: center;">ออกระบบ</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="width: 20em; ">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item" ><br>
                    <span class="ml-2"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home" id="feather"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <button sytle="color:#fff;" type ="submit" class = "btn btn1"onclick="closePopup()" >หน้าหลัก</button>   
                    </a>
                    </li>
                    <li class="nav-item">
                    <span class="ml-2"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"  id="feather"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                        
                        <button type ="submit" class = "btn btn2" onclick="openPopup2();changColor();" >ประวัติการตรวจ</button>   
                    </a>
                    </li>
                    </li>
                    <li class="nav-item">
                    <span class="ml-2"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2" id="feather"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <button type ="submit" class = "btn btn3" onclick="openPopup()">เพิ่มข้อมูลผู้ป่วย</button>   
                    </a>
                    </li>
                    <li class="nav-item">
                    <span class="ml-2"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers" id="feather"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <button type ="submit" class = "btn btn4" onclick="openPopup1()">ประวัติจ่ายยา</button>   
                    </a>
                    </li>
                    <li class="nav-item">
                    <span class="ml-2"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers" id="feather"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <button type ="submit" class = "btn btn4" onclick="openPopup3()">เริ่มการทำงานของหุ่น Temi</button>  
                        
                    </a>
                    </li>
                </ul>
            </div>
        </nav>
        </div>
        </div>
        <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
        
            <div class="row my-4" style ="color=green">
                <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0"style="width:49.3%;height:100%">
                    <div class="card">
                        <h5 class="card-header" style="text-align:center;background-color:#673ab7;color:white;">แสดงผลการทำงาน Temi</h5>
                        <div class="card-body">
                        <h5 class="card-title" style="text-align: center(0.3); font-size: 24px; height:50pxleft">TEMI ID [<?php echo $row3['Temi_ID'] ?>] สถานะ : <?php echo $row3['Status_start'];?></h5>
                        <!-- ตรงนี้เป็นส่วนของ HTML -->
                        สถานะ :<p id="message" class="card-text" style=" font-size: 30px; height: 50px; left: 0;">-</p>

                        <script>
                            let i = 0;
                            let ii = 1; // เริ่มต้นที่ 0 ในการเข้าถึงข้อมูล health_box_symptoms
                            function fetchData() {
                                fetch('http://localhost:8080/project/api.php')
                                .then(response => response.json())
                                .then(data => {
                                    if (data.temi_location.length > 0 && data.temi_location[0].Status_success === 'success' && data.patient.length > 0 && data.patient[0].switch_status === '1') {
                                        const roomID = data.patient[i].Room;
                                        document.getElementById('message').textContent = `กำลังไปที่ ${roomID}`;
                                    }if (data.health_box_symptoms.length > 0 && data.health_box_symptoms[ii].Status_symptoms === 'success' && data.patient.length > 0 && data.patient[0].switch_status === '1') {
                                        const roomID = data.patient[i].Room;
                                        document.getElementById('message').textContent = `ตรวจวัดค่าข้อมูลผู้ป่วยและส่งยาเสร็จที่ ${roomID}`;
                                        i = (i + 1) % data.patient.length; // เปลี่ยน i ให้วนกลับไปที่ 0 เมื่อ i เกินขนาดของ data.patient
                                        ii = (ii + 1);
                                    } else {
                                        document.getElementById('message').textContent = 'ว่าง';
                                    }
                                })
                                .catch(error => {
                                    console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error);
                                });
                            }

                            setInterval(fetchData, 1000); // โหลดข้อมูลทุก 1 วินาที (แก้ไขตามต้องการ)
                            fetchData(); // เรียกใช้ครั้งแรก
                        </script>


                        <p class="card-text text-success"></p>
                        </div>
                    </div>
                </div>
                

                <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3" style="width:49.2%;">
                    <div class="card">
                        <h5 class="card-header"style="text-align:center;background-color:#673ab7;color:white">เวลา</h5>
                        <div class="time"><script src ="time.js"></script>
                        <h5 class="card-title"><br><h1 id="current-time" style="text-align: center; height:87px">--:--:--</h1></h5>
                        <p class="card-text"></p>
                        <p class="card-text text-success"><br></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row" style="width: 100%;">
                <div class="col-12 col-xl-8 mb-4 mb-lg-0" style="width: 99.5%;">
                    <div class="card" >
                        <h5 class="card-header" style="text-align:center;background-color:#673ab7;color:white">ผู้ป่วย</h5>
                        <div class="card-body">
                            
                            <div class="table-responsive">
                            <table id="myTable" class="display" style="width: 100%;" active ="loadData()">
                                    <thead>
                                    <tr>
                                        <th scope="col"style="width: 5%;">ไอดี</th>
                                        <th scope="col"style="width: 10%;">สำหรับหุ่นเดินไป</th>
                                        <th scope="col"style="width: 30%;">ชิ่อผู้ป่วย</th>
                                        <th scope="col"style="width: 10%;">ห้อง</th>
                                        <th scope="col"style="width: 30%;">ผู้ดูแล</th>
                                        <th scope="col"style="width: 20%;">ตรวจล่าสุด</th>
                                        <th scope="col"style="width: 10%;"></th>
                                        

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $select_stmt = $conn->prepare('SELECT * FROM patient INNER JOIN room ON patient.Room_ID_p = room.ID INNER JOIN nurse ON patient.Nurse_ID = nurse.ID WHERE switch_status = 1');
                                        $select_stmt->execute();
                                        $result = $select_stmt->get_result();
                                        while ($row2 = $result->fetch_assoc()) {
                                            $statusClass = ($row2['switch_status'] == 1) ? 'switch-on' : 'switch-off';
                                    ?>
                                    <tr>
                                        <td style="background-color:#e0f7fa"><?php echo $row2['IDp']; ?></td>
                                        <td>
                                            <label class="switch <?php echo $statusClass; ?>" >
                                                <input type="checkbox" class="switch-checkbox" data-id="<?php echo $row2['IDp']; ?>"
                                                <?php if ($row2['switch_status'] == 1) echo 'checked'; ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td style="background-color:#e0f7fa"><?php echo $row2['Patientname']; ?></td>                        
                                        <td><?php echo $row2['Room']; ?></td>  
                                        <td style="background-color:#e0f7fa"><?php echo $row2['Fullname']; ?></td>  
                                        <td><?php echo $row2['Time_now']; ?></td>            
                                        <td style="background-color:#e0f7fa">
                                            <a href="edit.php?edit_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:#99FFFF;">แก้ไขข้อมูล</a>
                                            <a href="?delete_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:#FF3333;">ลบการใช้งาน</a>
                                            <a href="?stop_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:blue">ผู้ป่วยออกจากโรงพยาบาล</a>
                                            
                                        </td>                        
                                    </tr>
                                <?php } ?>
                                <?php 
                                        $select_stmt = $conn->prepare('SELECT * FROM patient INNER JOIN room ON patient.Room_ID_p = room.ID INNER JOIN nurse ON patient.Nurse_ID = nurse.ID WHERE switch_status = 0');
                                        $select_stmt->execute();
                                        $result = $select_stmt->get_result();
                                        while ($row2 = $result->fetch_assoc()) {
                                            $statusClass = ($row2['switch_status'] == 1) ? 'switch-on' : 'switch-off';
                                    ?>
                                    <tr>
                                        <td style="background-color:#e0f7fa"><?php echo $row2['IDp']; ?></td>
                                        <td>
                                            <label class="switch <?php echo $statusClass; ?>" >
                                                <input type="checkbox" class="switch-checkbox" data-id="<?php echo $row2['IDp']; ?>"
                                                <?php if ($row2['switch_status'] == 1) echo 'checked'; ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td style="background-color:#e0f7fa"><?php echo $row2['Patientname']; ?></td>                        
                                        <td><?php echo $row2['Room']; ?></td>  
                                        <td style="background-color:#e0f7fa"><?php echo $row2['Fullname']; ?></td>  
                                        <td><?php echo $row2['Time_now']; ?></td>            
                                        <td style="background-color:#e0f7fa">
                                            <a href="edit.php?edit_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:#99FFFF;">แก้ไขข้อมูล</a>
                                            <a href="?delete_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:#FF3333;">ลบการใช้งาน</a>
                                            <a href="?stop_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:blue">ผู้ป่วยออกจากโรงพยาบาล</a>
                                            
                                        </td>                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <script>
        var switches = document.querySelectorAll('.switch-checkbox');
        for (var i = 0; i < switches.length; i++) {
            switches[i].addEventListener('change', function() {
                var id = this.getAttribute('data-id');
                var status = this.checked ? 1 : 0;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_switch.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        console.log('Status updated');
                    }
                }
                xhr.send('id=' + id + '&status=' + status);
            });
        }
    </script>
<div class ="popup3" id = "popup3">
<div class = "overlay"></div>
    <div class = "content" style="border-radius: 10px;">

        <div class="form-container sign-in-container">
    
            <legend ><h2 style="color:black;"><b style="color:black;">เปิดการส่งยาให้ผู้ป่วย</b></h2></legend><br>
            <a href="Temi_start.php?Temi_ID=<?php echo $row3['Temi_ID'];  ?>" class="btn btn-danger" style="background:#99FFFF;">เปิดการทำงาน</a>
            <button type = "button"onclick="closePopup3()" class="btn btn-primary" style ="background:red;">ปิด</button>
                        </div>
                    </div>
                    </div>
</div>  <br>
    
</div>
        
<div class ="popup1" id = "popup1">
<div class = "overlay"></div>
    <div class = "content" style="border-radius: 10px;">

        <div class="form-container sign-in-container">
    
            <legend ><h2 style="color: black;"><b>ประวัติจ่ายยา</b></h2></legend><br>
            <div class="row" style="width: 100%;">
                <div class="col-12 col-xl-8 mb-4 mb-lg-0" style="width: 100%;">
                    <div class="card" >
                        <h5 class="card-header" >ประวัติ</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table id="myTable2" class="display" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th scope="col"style="width: 30%;">ลำดับ</th>
                                        <th scope="col"style="width: 10%;">ช่องส่งยา</th>
                                        <th scope="col"style="width: 10%;">ไอดีผู้ป่วย </th>
                                        <th scope="col"style="width: 20%;">ได้รับล่าสุด</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $select_stmt7 = $conn->prepare('SELECT * FROM healthbox_history ');
                                    // $select_stmt7 = $conn->prepare('SELECT * FROM healthbox_history INNER JOIN healthbox ON healthbox_history.Healthbox_ID = healthbox.ID INNER JOIN patient ON healthbox_history.Patient_ID = patient.ID');
                                        $select_stmt7->execute();
                                        $result7 = $select_stmt7->get_result();
                                        foreach($result7 as $row7){
                                        ?>

                                            <tr>
                                                <td style="background-color:#e0f7fa"><?php echo $row7['ID'] ?></td>                        
                                                <td><?php echo $row7['Healthbox_ID'] ?></td> 
                                                <td style="background-color:#e0f7fa"><?php echo $row7['Patient_ID'] ?></td>                        
                                                <td><?php echo $row7['Healthbox_History_Time'] ?></td>                     
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            </div>
                        
                        </div>
                    </div>
                    </div>
</div>  <br>
    <button type = "button"onclick="closePopup1()" class="btn btn-primary" style ="background:red;">ปิด</button>
</div>
<div class ="popup" id = "popup" >
<div class = "overlay"></div>
<div class = "content" style="border-radius: 10px;">
    <form action="nurse.php" method="post">
        <div class="form-container sign-in-container">
        
            <div class="container__child signup__form" style="width: 100%;;">
        
                <div class="mb-3">
                    <input type="text" class="form-control" name="Firstname" aria-describedby="Firstname" placeholder="ชื่อ">
                </div>
                <div class="mb-3">   
                    <input type="text" class="form-control" name="Lastname" aria-describedby="Lastname" placeholder="นามสกุล">
                </div>
                <div class="mb-3">
                    <select class="form-label" name="Gender" style="width: 100%;height: 40px; background-color:white;"require>
                        <option selected="" disabled="">เพศ</option>
                        <option value = "ผู้ชาย">ผู้ชาย</option>
                        <option value = "ผู้หญิง">ผู้หญิง</option>
                    </select>
                </div>
                    <div class="mb-3">     
                        <input type="date" class="form-control" name="Birthdate" aria-describedby="birthdate" placeholder="วันเกิด">
                    </div>
                    <div class="mb-3">       
                        <input type="int" class="form-control" name="Height" aria-describedby="height"  placeholder="ส่วนสูง                                                                                                                                                                                                                                                                                                                                                      หน่วย(cm)">
                    </div>
                    <div class="mb-3">
                        <input type="int" class="form-control" name="Weight" aria-describedby="weight"  placeholder="น้ำหนัก                                                                                                                                                                                                                                                                                                                                                      หน่วย(kg)">
                    </div>
                    <div class="mb-3">
                        
                        <select class="form-label" name="Room" style="width: 100%;height: 40px; background-color:white;"require>
                        <option selected="" disabled="">ห้อง</option>
                        <?php 
                            $select_room = $conn->prepare('SELECT * FROM room ');
                            $select_room->execute();
                            $result_room = $select_room->get_result();
                            foreach($result_room as $rowroom){
                                echo "<option id ='".$rowroom['ID']."' value='".$rowroom['ID']."'>".$rowroom['Room']."</option>";
                            }
                        ?>

                    </select>
                    </div>
                    <div class="mb-3">
                        
                        <select class="form-label" name="Caretaker" style="width: 100%;height: 40px; background-color:white;"require>
                        <option selected="" disabled="">ผู้ดูแล</option>
                        <?php 
                            $select_caretaker = $conn->prepare('SELECT * FROM nurse ');
                            $select_caretaker->execute();
                            $result = $select_caretaker->get_result();
                            foreach($result as $rowcaretaker){
                                echo "<option id ='".$rowcaretaker['Fullname']."' value='".$rowcaretaker['ID']."'>".$rowcaretaker['Fullname']."</option>";
                            }
                        ?>

                    </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="Telephone"  placeholder="เบอร์ติดต่อ">
                    </div>
        
                    <button type="submit" name="signup_pa" class="btn btn-primary" style ="width:80%;background:blue; padding: 5px; margin-top: 10px;margin-bottom: 10px;margin-left: 20px;margin-right: 20px;">ลงทะเบียน</button>
                    <button type = "button"onclick="closePopup()" class="btn btn-primary" style ="width:80%;background:green; padding: 5px; margin-top: 10px;margin-bottom: 10px;margin-left: 20px;margin-right: 20px">ปิด</button>

                </div></div>
        </div>        
    </form>
    <button type = "button"onclick="closePopup()">Return</button>
</div>  

</div>
        
<div class ="popup4" id = "popup4">
<div class = "overlay"></div>
    <div class = "content" style="border-radius: 10px;">

        <div class="form-container sign-in-container">
    
            <legend ><h2 style="color: black;"><b>ลบการใช้งาน / ผู้ป่วยออกจากโรงพยาบาล</b></h2></legend><br>
            
</div>  <br>
<a href="?delete_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:#FF3333;">ลบการใช้งาน</a>

    <button type = "button"onclick="closePopup4()" class="btn btn-primary" style ="background:green;">ปิด</button>
    <a href="?stop_id=<?php echo $row2['IDp']; ?>" class="btn btn-danger" style="background:blue">ผู้ป่วยออกจากโรงพยาบาล</a>
</div>

                    <div class ="popup2" id = "popup2" >
<div class = "overlay"></div>
    <div class = "content" style="border-radius: 10px;">
    <script>
        let popup2 = document.getElementById("popup2")
            function openPopup2(){
                popup.classList.remove("open-popup");
                popup2.classList.add("open-popup2");
                popup1.classList.remove("open-popup1");
                popup3.classList.remove("open-popup3");
            

            }
            let popup4 = document.getElementById("popup4")
            function openPopup4(){
                popup4.classList.add("open-popup4");


            }
            function closePopup2(){
                popup2.classList.remove("open-popup2");

            }
            function changColor(){
                popup2.classList.add("btn99::before");
            }
                        
                    let popup = document.getElementById("popup")
                        function openPopup(){
                            popup2.classList.remove("open-popup2");
                            popup.classList.add("open-popup");
                            popup1.classList.remove("open-popup1");
                            popup3.classList.remove("open-popup3");
                    
                        }
                        function closePopup(){
                            popup.classList.remove("open-popup");
                            popup1.classList.remove("open-popup1");
                            popup2.classList.remove("open-popup2");
                            popup3.classList.remove("open-popup3");
            
                        }
                            
                        let popup1 = document.getElementById("popup1")
                        function openPopup1(){
                            
                            popup1.classList.add("open-popup1");
                            popup.classList.remove("open-popup");
                            popup2.classList.remove("open-popup2");
                            popup3.classList.remove("open-popup3");
                        }
                        function closePopup1(){
                            popup1.classList.remove("open-popup1");
        
                        }
                        function closePopup4(){
                            popup4.classList.remove("open-popup4");
        
                        }
                        function close(){
                                popup.classList.remove("open-popup");
                            popup1.classList.remove("open-popup1");
                            
                            popup2.classList.remove("open-popup2");
                            popup3.classList.remove("open-popup3");
                        }
                        
                        let popup3 = document.getElementById("popup3")
                        function openPopup3(){
                            
                            popup3.classList.add("open-popup3");
                            popup.classList.remove("open-popup");
                            popup2.classList.remove("open-popup2");
                            popup1.classList.remove("open-popup1");
                        }
                        function closePopup3(){
                            popup3.classList.remove("open-popup3");
        
                        }
                        function close(){
                            popup1.classList.remove("open-popup1");
                            popup.classList.remove("open-popup");
                            popup2.classList.remove("open-popup2");
                            popup3.classList.remove("open-popup3");
                        }

    </script> 
                    <div class="form-container sign-in-container" >
            <legend ><h2 style="color: black;"><b>ประวัติตรวจวัด</b></h2></legend><br>
            <div class="row" style="width: 100%;">
                <div class="col-12 col-xl-8 mb-4 mb-lg-0" style="width: 100%;">
                    <div class="card" >
                        <h5 class="card-header" >ประวัติ</h5>
                        <div class="card-body">
                            
                            <div class="table-responsive">
                            <table id="myTable1" class="display" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th scope="col"style="width: 20%;">ไอดีผู้ป่วย</th>
                                        <th scope="col"style="width: 20%;">ออกซิเจนในเลือด %</th>
                                        <th scope="col"style="width: 20%;">อุณหภูมิ  °C</th>
                                        <th scope="col"style="width: 20%;">ชีพจร bpm</th>
                                        <th scope="col"style="width: 20%;">ตรวจเวลา</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $select_stmt = $conn->prepare('SELECT * FROM patient_symptoms ');
                                        $select_stmt->execute();
                                        $result = $select_stmt->get_result();
                                        foreach($result as $row9){
                                        ?>
                                            <tr>
                                                <td><?php echo $row9['Patient_ID'] ?></td>                        
                                                <td><?php echo $row9['SpO2'] ?></td>  
                                                <td><?php echo $row9['Temp'] ?></td>  
                                                <td><?php echo $row9['Pulse'] ?></td>                        
                                                <td><?php echo $row9['Time_latest'] ?></td>                     
                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  <br>
    <button type = "button"onclick="closePopup2()" class="btn btn-primary" style ="background:red;">ปิด</button>
    </div>

        </main>

<script src ="time.js"></script>
<script src ="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<style>

</style>
<script>
        $(document).ready(function () {
            $("#myTable").DataTable();
    });
    $(document).ready(function () {
            $("#myTable1").DataTable();
    });
    $(document).ready(function () {
            $("#myTable2").DataTable();
    });
</script>


</body>
</html>