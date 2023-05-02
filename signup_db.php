<?php
session_start();
include_once 'DB/connect.php';

if (isset($_POST['signupre'])) {
    $Username = $_POST['firstname'] . '.' . substr($_POST['lastname'], 0, 4);
    $Fullname = $_POST['firstname'] . ' ' . $_POST['lastname'];
    $Password = $_POST['Password'];
    $Hospital = $_POST['Hospital'];
    $User_role = 'nurse';

    if (empty($Fullname)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อ';
        header("location: index.php");
        exit();
    } else if (empty($Password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: index.php");
        exit();
    } else if (strlen($_POST['Password']) > 20 || strlen($_POST['Password']) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: index.php");
        exit();
    } else if (empty($Hospital)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อโรงพยาบาล';
        header("location: index.php");
        exit();
    } else {
        try {
            $check_data = $conn->prepare("SELECT * FROM nurse WHERE Username = ?");
            $check_data->bind_param("s", $Username);
            $check_data->execute();
            $result = $check_data->get_result();
            $row = $result->fetch_assoc();
            if (!empty($row['Username']) && $row['Username'] == $Username) {
                $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='signin.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                header("location: register.php");
                exit();
            } else {
                $Passwordhash = password_hash($Password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `nurse`(`Username`,`Fullname`,`Password`,`Hospital_ID`,`User_role`)VALUES(
                    '" . htmlspecialchars($Username, ENT_QUOTES, 'UTF-8') . "',
                    '" . htmlspecialchars($Fullname, ENT_QUOTES, 'UTF-8') . "',
                    '" . htmlspecialchars($Passwordhash, ENT_QUOTES, 'UTF-8') . "',
                    '" . htmlspecialchars($Hospital, ENT_QUOTES, 'UTF-8') . "',
                    '" . htmlspecialchars($User_role, ENT_QUOTES, 'UTF-8') . "'
                    )";
                if (mysqli_query($conn, $sql)) {
                    $_SESSION['success'] = "ลงทะเบียนสำเร็จ";
                    header('location: index.php');
                    exit();
                } else {
                    $_SESSION['error'] = "ลงทะเบียนไม่สำเร็จ";
                    header('location: register.php');
                    exit();
                }
            }
            mysqli_close($conn);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit();
        }
    }
}
?>