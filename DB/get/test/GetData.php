
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registor";
$TT = $_GET["ID"];
$conn =new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
  die("Connection failed: ".$conn->connect_error);

}
$a2 = $conn->query("SELECT * FROM healthbox WHERE ID = '$TT' ");
$row2 = $a2->fetch_assoc();
$data222 = array("ID"=> $row2['ID'],"Temi_loaction_ID"=>$row2['Temi_loaction_ID'],"Status_Onoff"=>$row2['Status_Onoff']);
echo json_encode($data222);




?>