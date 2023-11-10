<?php
   session_start();

   include_once 'DB/connect.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $temi_id = $_REQUEST['Temi_ID'];
    
    $sql1 = "UPDATE temi_start SET Status_start = 'start' WHERE Temi_ID = $temi_id";
    $sql2 = "UPDATE temi SET Operation_Status = 'start' WHERE ID= $temi_id";
    if ($conn->query($sql1) === TRUE) {
        $_SESSION['login_success'] =true;
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();
    header("refresh:2;nurse.php");
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!DOCTYPE html>
<html>
<head>
    <title>Robot Covid-19</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- รวม CSS สำหรับ Swal ไว้ในส่วน head นี้ -->
    
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (isset($_SESSION['login_success'])) {
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "เปิดการทำงาน"
        });
        setTimeout(function() {
            window.location.href = "nurse.php"; // ย้ายไปที่หน้า nurse.php
        }, 1000); // รอเวลา 1 วินาทีก่อนย้ายหน้า
    </script>';
    unset($_SESSION['login_success']);
}else if (isset($_SESSION['error'])) {
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "เข้าระบบไม่สำเร็จ",
            text: "' . $_SESSION['error'] . '",
            allowEscapeKey: false,
            allowOutsideClick: false, // ไม่อนุญาตให้คลิกด้านนอกป็อปอัพ
            allowEnterKey: true, // อนุญาตให้กด Enter
            showCloseButton: true, // แสดงปุ่มปิด
            showConfirmButton: true, // แสดงปุ่ม "OK"
            confirmButtonText: "OK", // แสดงข้อความ "OK" บนปุ่ม
        }).then(function() {
            window.location.href = "index.php"; // ย้ายกลับไปที่ index.php เมื่อกด "OK"
        });
    </script>';
}
?>

</body>
</html>
