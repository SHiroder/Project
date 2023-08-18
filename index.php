<!DOCTYPE html>
<html>
<head>
<title>Robot Covid-19</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

<style>
body,h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
  background-image: url('image/doctor-stethoscope-hand-hospital-background-gown-94227568.jpg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
.popup{
  width: 500px;
  background:#fff;
  border-radius: 10px;
  position:absolute;
  height: auto;
  top:100px;
  left:50%;
  transform: translate(-50%,-50%) ; 
  text-align:center;
  padding: 0 30px 30px;
  color:#333;

}

</style>
</head>
<body>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white" style ="display" >
  <div class="w3-display-topleft w3-padding-large w3-xlarge" >
  <h1 style="font-family:verdana; text-align:center;"></h1>
  </div>
  <div class="w3-display-middle">
    
    <hr class="w3-border-grey" style="margin:auto;width:40%"><br/>
    <div class ="popup" id = "popup">
      
    <div class="form-container sign-in-container">
    <form action="signin_db.php" method="post">
    <br />
    <h1 class="w3-jumbo w3-animate-top" style="top:100%">LOG IN</h1>
    <br />
			
      <input type="text"  name="Username"  placeholder="Username" style ="background : white; width:100% ; Height:60%;"> <br />  <br /> 
			<input type="password"  name="Password" placeholder="Password" style ="background : white; width:100% ; Height:60%;"> <br />  <br /> 

			<a href="register.php">Forgot your password?</a> <br />  <br /> 
            
      <button type="submit" name="signin" class="btn btn-primary" style ="background : blue,0.2; width:100% ; Height:60%;">Login Now</button> <br /> 
		</form>
	</div>  
        <button type = "button"onclick="closePopup()" style ="background : red,0.5,0.8,0.5; width:100% ; Height:60%;">Return</button>
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