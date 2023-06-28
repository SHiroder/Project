<?php 

session_start();
include_once 'DB/connect.php';

if (isset($_POST['signin'])) {
    $username = $_POST['Username'];
    $password = $_POST['Password'];


    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกอีเมล';
        header("location: index.php");
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: index.php");
    } else if (strlen($_POST['Password']) > 20 || strlen($_POST['Password']) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: index.php");
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
                   // if ($row['Hospital_ID']== $row['Hopitalname']){
                        if ($row['User_role'] == 'nurse') {
                            session_start();
                            $_SESSION['nurse_login'] = $row['ID'];
                            echo '<script> alert("Login successed")</script>';
                            header("location: nurse.php");
                            exit();
                        } else {
                            $_SESSION['error'] = 'Invalid user role';
                            echo '<script> alert("Invalid user role")</script>';
                            header("location: index.php");
                            exit();
                        }
                   // }else{
                       // echo '<script> alert("Invalid hopital")</script>';
                    //}
                } else {
                    $_SESSION['error'] = 'Invalid password';
                    echo '<script> alert("Invalid password")</script>';
                    header("location: index.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = 'Invalid username';
                echo '<script> alert("Invalid password")</script>';
                header("location: index.php");
                exit();
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }
}



?>