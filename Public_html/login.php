<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  
  // it will never let you open index(signin) page if session is set
  if ( isset($_SESSION['user'])!="" ) {
  	echo "<script> alert('You have already signed in'); </script>";
    header("Location: home.php");
    exit;
  }
  
  $error = false;
  if(isset($_POST['signin-button'])) {  
    
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    // prevent sql injections / clear user invalid inputs
    if(empty($email)){
      $error = true;
      $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $emailError = "Please enter valid email address.";
    }
    
    if(empty($pass)){
      $error = true;
      $passError = "Please enter your password.";
    }
    
    // if there's no error, continue to signin
    if (!$error) {
      
      $password = hash('sha256', $pass); // password hashing using SHA256
    
      $res=mysqli_query($_SESSION['conn'], "SELECT userName, userPass FROM users WHERE userEmail='$email'");
      $row=mysqli_fetch_array($res);
      $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
      
      if( $count == 1 && $row['userPass']==$password ) {
        $_SESSION['user'] = $row['userName'];
        header("Location: home.php");
      } else {
        $errMSG = "Invalid credentials, please try again.";
      }
        
    }
    
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign in - Manga Recommendations</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
	<link rel="stylesheet" href="stylesheet.css">
</head>

<style>
#signin-form {
    height: 640px;
    width: 1000px;
}
input[type=email], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
.signin-button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}
</style>

<body class="w3-display-container w3-sand">
<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s2">
      <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s8" align="middle"><img src="Images/alt_logo.png" alt="logo" style="height:38px;"></div>
    <div class="w3-col s2">
      <a href="register.php" class="w3-button w3-block w3-black">SIGN UP</a>
    </div>
  </div>
</div>

<div class="w3-sand w3-large">
	<div class="w3-display-middle" id="signin-form">
	    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
	     	<div align="middle">
	       		<h2>Sign In</h2>
	       		<img src="Images/anon.png" alt="Avatar" class="avatar" style="width:200px; border-radius: 50%">
	       	</div>

            <hr />
            
            <?php
			if ( isset($errMSG) ) {
				?>
				<div class="w3-panel w3-pale-red w3-leftbar w3-border-red w3-padding-16">
					<?php echo $errMSG; ?>
            	</div>
            <?php
			}
			?>
            
            <div class="container">
  				<div>
      				<label><b>Email</b></label>
      				<input type="email" name=email placeholder="Enter your email" value="<?php echo $email; ?>" required>
      				<span class="text-danger"><?php echo $emailError; ?></span>
      			</div>

  				<label><b>Password</b></label>
  				<input type="password" name="pass" placeholder="Enter your password" required>
  				<span class="text-danger"><?php echo $passError; ?></span>

  				<button type="submit" class="signin-button" name="signin-button">Sign in</button>
  				<span style="display:inline-block; float:left;"><input type="checkbox" checked="checked"> Remember me</span>
  				<span style="display:inline-block; float:right;"><a href="register.php">Sign up</a> | <a href="#">Forgot password?</a></span>
			</div>
	        <hr />
	    </form>
    </div>	

</div>

</body>
</html>
<?php ob_end_flush(); ?>