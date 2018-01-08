<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
 header("Location: home.php");
}
require_once 'dbconnect.php';

if(isset($_POST['btn-signup'])) {
 
 $uname = strip_tags($_POST['username']);
 $email = strip_tags($_POST['email']);
 $firstname = strip_tags($_POST['fname']);
 $lastname = strip_tags($_POST['lname']);
 $upass = strip_tags($_POST['password']);
 $birthd = strip_tags($_POST['bd']);
 $birthm = strip_tags($_POST['bm']);
 $birthy = strip_tags($_POST['by']);

 
 $uname = $DBcon->real_escape_string($uname);
 $email = $DBcon->real_escape_string($email);
 $upass = $DBcon->real_escape_string($upass);
 $firstname = $DBcon->real_escape_string($uname);
 $lastname = $DBcon->real_escape_string($email);
 $birthd = $DBcon->real_escape_string($birthd);
 $birthm = $DBcon->real_escape_string($birthm);
 $birthy = $DBcon->real_escape_string($birthy);

 

 

 
 $check_email = $DBcon->query("SELECT email FROM user WHERE email='$email'");
 $count=$check_email->num_rows;
 
 if ($count==0) {
  
  $query = "INSERT INTO user(username,fname,lname,email,password,bdd,bdm,bdy) VALUES('$uname','$firstname','$lastname','$email','$upass','$birthd','$birthm','$birthy')";


  if ($DBcon->query($query)) {
  
   $msg = "<div class='alert alert-success'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
     </div>";

     


    }else {
    
   $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
     </div>";
  }
  
 } else {
  
  
  $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
    </div>";
   
 }
 


 
 $DBcon->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration System</title>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="style.css" type="text/css" />

</head>
<body>

<div class="signin-form">

 <div class="container">
     
        
       <form class="form-signin" method="post" id="register-form">
      
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        
        <?php
  if (isset($msg)) {
   echo $msg;
  }
  ?>
          
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="username" required  />
        </div>
        <div class="form-group">
        <input type="text" class="form-control" placeholder="First name" name="fname" required  />
        </div>
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Last name" name="lname" required  />
        </div>
        
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required  />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="number"  class="form-control" placeholder="Birthday Month" name="bm" required  />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="number"  class="form-control" placeholder="Birthday date" name="bd" required  />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="number"   class="form-control" placeholder="Birthday year" name="by" required  />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required  />
        </div>

        
      <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
   </button> 
            <a href="index.php" class="btn btn-default" style="float:right;">Log In Here</a>
        </div> 
      
      </form>

    </div>
    
</div>

</body>
</html>