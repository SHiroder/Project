<!DOCTYPE html>
<html>
   <head>
      <title>Gmail Sender</title>
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <div class="wrapper">
         <form method="post" action="index.php">
            <h2>Gmail Sender App</h2><br>
            Email To :<br>
            <input type="text" name="email"><br>
            Subject :<br>
            <input type="text" name="subject"><br>
            Body :<br>
            <textarea name="body"></textarea><br>
            <a href="admin.php" class="btn btn-warning">Return</a> 
            <input type="submit" value="SEND" name="submit">     
                  
         </form>
         <?php
         if(isset($_POST['submit'])){
            $url = "https://script.google.com/macros/s/AKfycby4yxKRGxPcx5aWQBIR5sBBAthavE4A4DvXe67YJHE-vV2GrO7OaYpYnBcG-YkZyxQNDA/exec";
            $ch = curl_init($url);
            curl_setopt_array($ch, [
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_POSTFIELDS => http_build_query([
                  "recipient" => $_POST['email'],
                  "subject"   => $_POST['subject'],
                  "body"      => $_POST['body']
               ])
            ]);
            $result = curl_exec($ch);
            echo $result;
         }
         ?>
      </div>
      
   </body>
</html>