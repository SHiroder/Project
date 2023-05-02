
<?php
include_once 'DB/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 50px auto;
            max-width: 600px;
            font-size: 18px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, select {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 18px;
            width: 100%;
            max-width: 400px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path fill='%23ccc' d='M7.41 8.59L12 13.17l4.59-4.58L18 9l-6 6-6-6z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 20px;
            padding-right: 30px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }
    </style>
</head>

<body>
<form method="post" action="process.php">
  <label for="input1">พิกัดที่ 1</label>
  <input type="text" id="input1" name="input1"><br>

  <label for="input2">พิกัดที่ 2</label>
  <input type="text" id="input2" name="input2"><br>

  <label for="input3">พิกัดที่ 3</label>
  <input type="text" id="input3" name="input3"><br>

  <label for="input4">พิกัดที่ 4</label>
  <input type="text" id="input4" name="input4"><br>

  <select class="input6" name="Caretaker"require>
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

  <button type="submit">กดเพิ่อเพิ่มตำแหน่ง</button>

</body>
</html>