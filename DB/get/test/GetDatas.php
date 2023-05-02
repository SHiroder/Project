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
$a23 = $conn->query("SELECT * FROM Temi_location WHERE ID = '$TT' ");
$rowlocation = $a23->fetch_assoc();
$data2222 = array("ID"=> $rowlocation['ID'],"Temi_ID"=>$rowlocation['Temi_ID'],"Status_success"=>$rowlocation['Status_success']);
echo json_encode($data2222);
 
?>