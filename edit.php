<?php 
    session_start();

    include_once 'DB/connect.php';

    if(isset($_REQUEST['edit_id'])){
        $id = $_REQUEST['edit_id'];
        $select_stmt = $conn->prepare("SELECT * FROM patient WHERE ID = ?");
        $select_stmt->bind_param('i', $id);
        $select_stmt->execute();
        $result = $select_stmt->get_result();
        $row = $result->fetch_assoc();
    }

    if(isset($_REQUEST['btn_update'])) {
        try {
            $id = $_REQUEST['ID'];
            $Firstname = $_REQUEST['Firstname'];
            $Lastname = $_REQUEST['Lastname'];
            $Patientname = $Firstname.' '.$Lastname;
            $Gender = $_REQUEST['Gender'];
            $Height = $_REQUEST['Height'];
            $Weight = $_REQUEST['Weight'];
            $BMI = $_REQUEST['BMI'];
            $Age = $_REQUEST['Age'];
            $Room = $_REQUEST['Room'];
            $Caretaker = $_REQUEST['Caretaker'];
            $Birthdate = $_REQUEST['Birthdate'];
            $Telephone = $_REQUEST['Telephone'];

            $update_stmt = $conn->prepare("UPDATE patient SET Firstname = ?, Lastname = ?, Patientname = ?, Gender = ?, Height = ?, Weight = ?, BMI = ?, Age = ?, Room = ?, Caretaker = ?, Birthdate = ?, Telephone = ? WHERE ID = ?");
            $update_stmt->bind_param('ssssssssssssi', $Firstname, $Lastname, $Patientname, $Gender, $Height, $Weight, $BMI, $Age, $Room, $Caretaker, $Birthdate, $Telephone, $id);

            if($update_stmt->execute()) {
                $updateMsg = "File update successfully...";
                header("refresh:2;nurse.php");
            } else {
                $errorMsg = "Failed to update data.";
            }
        } catch(mysqli_sql_exception $e) {
            echo $e->getMessage();
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
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
</style>

    <div class="container text-center">
        <h1>แก้ไขข้อมูล</h1>
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
            </div>
        <?php } ?>
        </div>
        </div>
        <div>
        <form action="edit.php">
        </div>
        </div>
        <div class="form-group">

            <label for="age" class="form-label">ชื่อ</label>
            <input type="text" class="form-control" name="Firstname" aria-describedby="Firstname" value ="<?php echo $row['Firstname'] ;?>"require> 
        </div>
        </div>
        <div class="form-group">

            <label for="lastname" class="form-label">นามสกุล</label>

            <input type="text" class="form-control" name="Lastname" aria-describedby="Lastname" value ="<?php echo $row['Lastname']; ?>"require>
        </div>
        </div>
        <div class="form-group">

            <label for="lastname" class="form-label">ชื่อผู้ป่วย</label>

            <input type="text" class="form-control" name="Lastname" aria-describedby="Lastname" value ="<?php echo $row['Patientname']; ?>"disabled>
        </div>
        </div>
        <div class="form-group">

            <label for="age" class="form-label">เพศ</label>
          
            <input type="text" class="form-control" name="Gender" aria-describedby="Gender" value ="<?php echo $row['Gender'] ;?>"require>
        </div>
        </div>
        <div class="form-group">

            <label for="gender" class="form-label">ส่วนสูง หน่วย(cm)</label>

            <input type="int" class="form-control" name="Height" aria-describedby="Height" value ="<?php echo $row['Height'] ;?>"require>
        </div>
        </div>
        <div class="form-group">

            <label for="gender" class="form-label">น้ำหนัก หน่วย(kg)</label>

            <input type="int" class="form-control" name="Weight" aria-describedby="Height" value ="<?php echo $row['Weight'] ;?>"require>
        </div>
        </div>
        <div class="form-group">

            <label for="gender" class="form-label">BMI</label>

            <input type="float" class="form-control" name="BMI" aria-describedby="Height" value ="<?php echo $row['BMI'] ;?>" require>
        </div>
        </div>
        <div class="form-group">

            <label for="gender" class="form-label">อายุ</label>

            <input type="text" class="form-control" name="Age" aria-describedby="Height" value ="<?php echo $row['Age'] ;?>" require>
        </div>
        </div>
        <div class="form-group">
            <label for="gender" class="form-label">ห้อง</label>
            <input type="text" class="form-control" name="Room" aria-describedby="Height" value ="<?php echo $row['Room'] ;?>" require>
        </div>
        </div>
        <div class="form-group">
            <label for="gender" class="form-label">ผู้ดูแล</label>
            <input type="text" class="form-control" name="Caretaker" aria-describedby="Height" value ="<?php echo $row['Caretaker'] ;?>" require>
        </div>
        </div>
        <div class="form-group">
            <label for="birthdate" class="form-label">วันเกิด</label>
            <input type="text" class="form-control" name="Birthdate" aria-describedby="birthdate" value ="<?php echo $row['Birthdate'] ;?>"require>
        </div>
        </div>
        <div class="form-group">
            <label for="Telephone" class="form-label">เบอร์ติดต่อ</label>

            <input type="Telephone" class="form-control" name="Telephone" value ="<?php echo $row['Telephone'];?>"require> 
        </div>
        <br>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="submit" name="btn_update" class="btn btn-primary" value="Update">
                <a href="nurse.php" class="btn btn-danger" style="width:100%">Cancel</a>
            </div>
        </div>
        </form>
        </div>        
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
