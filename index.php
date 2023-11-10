<!DOCTYPE html>
<html>
<head>
<title>Robot Covid-19</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

<style>
body{ opacity: 0.9;}
h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%;}
.bgimg {
  background-image: url('image/doctor-stethoscope-hand-hospital-background-gown-94227568.jpg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
.popup{
  opacity: 0.9;
  min-height: 90%;
  min-width: 90%;
  background:#fff;
  border-radius: 10px;
  position:absolute;
  height: auto;
  top:10%;
  left:10%;
  transform: translate(-50%,-50%) ; 
  text-align:center;
  padding: 0 10px 10px;
  color:#333;
  border-width: 2px 10px 4px 20px;
}
input[type=text] {
  border: none;
  border-bottom: 2px solid black;
}
input[type=password] {
  border: none;
  border-bottom: 2px solid black;
}
h1 { color: #000; font-family: 'Raleway',sans-serif; font-size: 62px; font-weight: 800; line-height: 72px; margin: 0 0 24px; text-align: center; text-transform: uppercase; }

@keyframes hover-animation {
    0% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
    }
  }

  /* สร้าง animation hover โดยใช้ CSS */
  input[type="text"]:hover,
  input[type="password"]:hover {
    animation: hover-animation 0.3s ease-in-out;
  }

  /* กำหนดสไตล์ของช่อง Username และ Password */
  input[type="text"],
  input[type="password"] {
    background: white;
    width: 100%;
    height: 50px;
    border: 1px solid #ccc;
    padding: 5px;
    transition: border-color 0.3s;
  }

  /* สไตล์ของช่อง Username และ Password เมื่อ hover */
  input[type="text"]:hover,
  input[type="password"]:hover {
    border-color: #007bff; /* เปลี่ยนสีขอบเมื่อ hover */
  }
  button:hover {
    background-image: linear-gradient(to right, green, blue);
    transform: scale(1.05); /* เพิ่มขนาดเล็กน้อยเมื่อ hover */
  }

  /* กำหนด transition เพื่อทำให้การเปลี่ยนแปลงเกิดขึ้นอย่างนุ่มนวล */
  button {
    transition: background-image 0.3s, transform 0.3s;
  }
  h1 {
  font-family: 'Raleway', sans-serif; /* เลือกแบบอักษรที่คุณต้องการ */
  font-size: 36px; /* ขนาดตัวอักษร */
  font-weight: bold; /* ความหนาของตัวอักษร */
  color: #333; /* สีของตัวอักษร */
  text-align: center; /* จัดกลางตำแหน่งของตัวอักษร */
  text-transform: uppercase; /* แปลงตัวอักษรเป็นตัวใหญ่ทั้งหมด */
  margin: 0; /* ลบขอบรอบของ <h1> */
  padding: 10px; /* ระยะห่างภายใน <h1> */

}

</style>
</head>
<body>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white" style ="display" >
  <div class="w3-display-topleft w3-padding-large w3-xlarge" >
  <h1 style="font-family:verdana; text-align:center;"></h1>
  </div>
  <div class="w3-display-middle">
    
    <hr class="w3-border-grey" style="margin:auto;width:auto"><br/>
    <div class ="popup" id = "popup" >
      
    <div class="form-container sign-in-container">
    <form action="signin_db.php" method="post">
    <br />
    <br />
    <h1 class="w3-jumbo w3-animate-top" style="top:100%">LOG IN</h1>
   
			
         <input type="text" name="Username" placeholder="Username" style="width: 100%; height: 50px;border-radius: 30px;"><br><br>
        <input type="password" name="Password" placeholder="Password" style="width: 100%; height: 50px;border-radius: 30px;"><br><br>

			<a href="register.php" >Forgot your password?</a> <br />  <br /> 
            
      <button type="submit" name="signin" style ="color: white;background-image: linear-gradient(to right, blue , green); opacity: 0.9; width:350px ;Height:50px;border-radius: 30px;margin: 5px;">Login Now</button>
		</form>
     
	</div>  
        <button type = "button"onclick="closePopup()" style ="color: white;background-image: linear-gradient(to right, red , green); width:50% ; Height:60%;Height:30px;border-radius: 30px;margin: 5px;">Return</button>
</div>
    </div>
  </div>
  <div class="w3-display-bottomleft w3-padding-large">
    <a href="https://www.w3schools.com/w3css/default.asp" target="_blank"></a>
  </div>
</div>

</script>
</body>
</html>