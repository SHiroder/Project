<?php 

    session_start();
    require_once 'DB/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration System PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h3 class="mt-4">ใส่ข้อมูลลงทะเบียน</h3>
        <hr>
        <form id ="addForm"action="signup_db.php" method="post">
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" name="firstname" aria-describedby="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" name="lastname" aria-describedby="lastname" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="Password" required>
            </div>
            <div class="mb-3">
            <label for="Hospital" class="form-label">Hospital</label>
                <select class="form-label" name="Hospital" style="width: 100%;height: 40px; background-color:white;"require>
                            <option selected="" disabled="">โรงพยาบาล</option>
                             <?php 
                                $select_caretaker = $conn->prepare('SELECT * FROM hospital ');
                                $select_caretaker->execute();
                                $result = $select_caretaker->get_result();
                                foreach($result as $rowcaretaker){
                                    echo "<option id ='".$rowcaretaker['Hospitalname']."' value='".$rowcaretaker['ID']."'>".$rowcaretaker['Hospitalname']."</option>";
                                }
                            ?>

                        </select>
            </div>
            <button type="submit" name="signupre" class="btn btn-primary">Sign Up</button> <a href="index.php" class="btn btn-danger">Return</a>
        </form>
        <hr>
        <p>เป็นสมาชิกแล้วใช่ไหม คลิ๊กที่นี่เพื่อ <a href="signin.php">เข้าสู่ระบบ</a></p>
    </div>

    
</body>
</html>