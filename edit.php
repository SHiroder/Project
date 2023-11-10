<?php 
session_start();
include_once 'DB/connect.php';

// ตรวจสอบว่า edit_id ถูกส่งมาจาก nurse.php หรือไม่
if (isset($_REQUEST['edit_id'])) {
    $id = $_REQUEST['edit_id'];
    
    $select_stmt = $conn->prepare("SELECT * FROM patient WHERE IDp = ?");
    $select_stmt->bind_param('i', $id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    
    // ตรวจสอบว่ามีข้อมูลของผู้ป่วยที่ต้องแก้ไขหรือไม่
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // ดึงข้อมูลผู้ป่วยจากฐานข้อมูล
    } else {
        // ถ้าไม่มีข้อมูลผู้ป่วยที่ต้องแก้ไข สามารถเพิกเฉยตามความเหมาะสม
        // และสามารถเพิกเฉยไปยังหน้าเว็บอื่นหรือแสดงข้อความแจ้งเตือน
    }
}

// ตรวจสอบความถูกต้องของคำสั่งปัจจุบันก่อนใช้ $row
if (isset($row)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับและอัปเดตข้อมูล
    
    
        try {
            $id = $row['IDp'];
            // รับข้อมูลจากฟอร์ม
            $Firstname = $_POST['Firstname'];
            $Lastname = $_POST['Lastname'];
            $Gender = $_POST['Gender'];
            $Height = $_POST['Height'];
            $Weight = $_POST['Weight'];
            $BMI = $_POST['BMI'];
            $Age = $_POST['Age'];
            $Room = $_POST['Room_ID_p'];
            $Nurse_ID = $_POST['Nurse_ID'];
            $Birthdate = $_POST['Birthdate'];
            $Telephone = $_POST['Telephone'];
            $switch_status = $_POST['switch_status'];
            
    
            // ทำการอัปเดตข้อมูลในฐานข้อมูล
            $update_stmt = $conn->prepare("UPDATE patient SET Firstname = ?, Lastname = ?, Patientname = ?, Gender = ?, Height = ?, Weight = ?, BMI = ?, Age = ?, Room_ID_p = ?, Nurse_ID = ?, Birthdate = ?, Telephone = ?, switch_status = ? WHERE IDp = ?");
            $update_stmt->bind_param('ssssssssssssii', $Firstname, $Lastname, $Patientname, $Gender, $Height, $Weight, $BMI, $Age, $Room, $Nurse_ID, $Birthdate, $Telephone, $switch_status, $id);
    
            if ($update_stmt->execute()) {
                $updateMsg = "อัปเดตข้อมูลเรียบร้อย...";
                header("refresh:1;nurse.php"); // ไปยังหน้า nurse.php หลังจากอัปเดตสำเร็จ
            } else {
                $errorMsg = "ไม่สามารถอัปเดตข้อมูลได้";
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center">
        <h1>แก้ไขข้อมูล</h1>
    </div>

    <div class="container">
        <?php 
        if(isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php 
        if(isset($updateMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $updateMsg; ?></strong>
            </div>
        <?php } ?>

        <form action="edit.php" method="POST">

            <div class="form-group">
                <label for="age" class="form-label">ชื่อ</label>
                <input type="text" class="form-control" name="Firstname" aria-describedby="Firstname" value="<?php echo $row['Firstname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastname" class="form-label">นามสกุล</label>
                <input type="text" class="form-control" name="Lastname" aria-describedby="Lastname" value="<?php echo $row['Lastname']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastname" class="form-label">ชื่อผู้ป่วย</label>
                <input type="text" class="form-control" name="Lastname" aria-describedby="Lastname" value="<?php echo $row['Patientname']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="age" class="form-label">เพศ</label>
                <input type="text" class="form-control" name="Gender" aria-describedby="Gender" value="<?php echo $row['Gender']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">ส่วนสูง หน่วย(cm)</label>
                <input type="number" class="form-control" name="Height" aria-describedby="Height" value="<?php echo $row['Height']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">น้ำหนัก หน่วย(kg)</label>
                <input type="number" class="form-control" name="Weight" aria-describedby="Height" value="<?php echo $row['Weight']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">BMI</label>
                <input type="number" step="0.01" class="form-control" name="BMI" aria-describedby="Height" value="<?php echo $row['BMI']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">อายุ</label>
                <input type="number" class="form-control" name="Age" aria-describedby="Height" value="<?php echo $row['Age']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">ห้อง</label>
                <input type="text" class="form-control" name="Room_ID_p" aria-describedby="Height" value="<?php echo $row['Room_ID_p']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender" class="form-label">ผู้ดูแล</label>
                <input type="text" class="form-control" name="Nurse_ID" aria-describedby="Height" value="<?php echo $row['Nurse_ID']; ?>" required>
            </div>

            <div class="form-group">
                <label for="birthdate" class="form-label">วันเกิด</label>
                <input type="text" class="form-control" name="Birthdate" aria-describedby="birthdate" value="<?php echo $row['Birthdate']; ?>" required>
            </div>

            <div class="form-group">
                <label for="birthdate" class="form-label">สถานะการยังรักษาอยู่ (0 = ออกจากโรงพยาบาลแล้ว | 1 = ยังรักษาอยู่)</label>
                <input type="number" class="form-control" name="switch_status" aria-describedby="birthdate" value="<?php echo $row['switch_status']; ?>" required>
            </div>

            <div class="form-group">
                <label for="Telephone" class="form-label">เบอร์ติดต่อ</label>
                <input type="tel" class="form-control" name="Telephone" value="<?php echo $row['Telephone']; ?>" required>
            </div>

            <div class="form-group">
                <div class="col-sm-12">
                <a href="edit.php?btn_update=<?php echo $row['IDp']; ?>" class="btn btn-primary" name="btn_update">แก้ไข</a>



                    <a href="nurse.php" class="btn btn-danger btn-block">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
