<?PHP
session_start();
include_once "dbconnect.php";

if(isset($_SESSION["user_id"])) {
	header("Location: index.php");
} 
	
$error = false;

if (isset($_POST['signup'])) {
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$cpassword = mysqli_real_escape_string($con, $_POST['conpassword']);
	
	//name can contain only alpha characters and space
    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $name_error = "Name must contain only letters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please enter a valid email address.";
    }
    if (strlen($password) < 6) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters.";
    }
    if ($password != $cpassword) {
        $error = true;
        $cpassword_error = "Your password and confirmation password do not match.";
    }
    if (!$error) {
        if(mysqli_query($con, "INSERT INTO users(name,email,password) VALUES('" . $name . "', '" . $email . "', '" . md5($password) . "')")) {
            $successmsg = "Successfully registered! <a href='#'>You may login now.</a>";
        } else {
            $errormsg = "Error in registering...Please try again later.";
        }
    }
}
?>

<?php
//check if login form is submitted
if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $result = mysqli_query($con, "SELECT * FROM users WHERE email = '" . $email. "' and password = '" . md5($password) . "'");

    if ($row = mysqli_fetch_array($result)) {
        $_SESSION['usr_id'] = $row['id'];
        $_SESSION['usr_name'] = $row['name'];
        header("Location: index.php");
    } else {
        $errormsg = "Incorrect Email or Password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css" type="text/css"></link>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Sansita|Philosopher|Quicksand|Rubik');
	</style>
</head>
<!--End Heading-->
<body class="bkg-black">
<div class="container-fluid">
	<div class='row justify-content-end'>
	<nav class="navbar navbar-toggleable-sm fixed-top bkg-yellow txt-black" role="navigation">
		<div class="col-md-7 bkg-yellow">
		<p class="bkg-yellow txt-black upper sansita txt-size-2">Syntax | Reference Guide</p>
		</div>
    	<div class="collapse navbar-collapse bkg-yellow col-md-5">
    		<form class="form-inline bkg-yellow" role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
      			<input type="text" name="email" placeholder="Your Email" required class="form-control mr-sm-2" />
				<input type="password" name="password" placeholder="Your Password" required class="form-control mr-sm-2" />
      			<button class="btn bkg-black txt-white" type="submit" name="login" value="login">Login</button>
    		</form>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
  		</div>
	</nav>	
	</div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 well">
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                <fieldset>
                    <legend>Sign Up</legend>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Enter Full Name" required value="<?php if($error) echo $name; ?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" name="email" placeholder="Email" value="<?php if($error) echo $email;?>" class="form-control" />
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" name="password" placeholder="Password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Confirm Password</label>
                        <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>
            <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
            <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
        </div>
    </div>
   <!-- <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">    
        Already Registered? <a href="login.php">Login Here</a>
        </div>
    </div>-->
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>