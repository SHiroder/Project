<?php
session_start();
include_once 'DB/connect.php';

if (isset($_POST['signin'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    if (empty($username) || empty($password) || strlen($password) > 20 || strlen($password) < 5) {
        $_SESSION['error'] = 'กรุณากรอกอีเมลและรหัสผ่านที่ถูกต้อง';
    } else {
        try {
            $sql = "SELECT * FROM nurse WHERE Username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['Password'])) {
                    if ($row['User_role'] == 'nurse') {
                        $_SESSION['nurse_login'] = $row['ID'];
                        $_SESSION['login_success'] = true;
                    } else {
                        $_SESSION['error'] = 'Invalid user role';
                    }
                } else {
                    $_SESSION['error'] = 'Invalid password';
                }
            } else {
                $_SESSION['error'] = 'Invalid username';
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Robot Covid-19</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <!-- รวม CSS สำหรับ Swal ไว้ในส่วน head นี้ -->
    <style>
        .bgimg {
            background-image: url('image/doctor-stethoscope-hand-hospital-background-gown-94227568.jpg');
            min-height: 100%;
            background-position: center;
            background-size: cover;
        }

        body {
            background-image: url('image/doctor-stethoscope-hand-hospital-background-gown-94227568.jpg');
            min-height: 100%;
            background-position: center;
            background-size: cover;
        }
    </style>
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (isset($_SESSION['login_success'])) {
    echo '<script>
        Swal.fire({
            icon: "success",
            title: "เข้าระบบสำเร็จ"
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
