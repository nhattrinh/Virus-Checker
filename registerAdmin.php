<?php

//Simple page - this is only for registering more admin accounts for the admin panel.

//Use require_once
require_once('dbConnect.php');	//Connects to DB and chooses the Antivirus DB.
include('functions.php'); //Contains all the necessary functions that will be used.

if (isset($_POST['register_btn']))
{
	$usernamez0 = $_POST['username'];
	//Non-case sensitive:
	$usernamez = strtolower($usernamez0);
	$passwordz = mysql_real_escape_string($_POST['password']);
	$passwordz512 = hash('sha512',$passwordz);
	$checkExisting=mysql_query("SELECT * FROM admintable WHERE usernamedb = '$usernamez'");
	$checkExistingTB=mysql_fetch_array($checkExisting);
	
	if($checkExistingTB['usernamedb'] == $usernamez)
	{
		alert("Username already exists, please try another username");
	}
	else
	{
		$insert=mysql_query("insert into admintable(usernamedb, passworddb)values('".mysql_real_escape_string($usernamez)."', '".mysql_real_escape_string($passwordz512)."')");
		if($insert)
		{
			alert("Administrator account created!");
		}
		else
		{
			alert("There has been an error creating your account.");
		}
	}
}

mysql_close($conn);
?>

<!--BootStrap-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="upload.js"></script>

<script>
function validateUserInputs()
{
	var usernameValidate = document.forms["adminform"]["username"].value;
	var passwordValidate = document.forms["adminform"]["password"].value;
	if (usernameValidate && passwordValidate == "")
	{
		alert("All fields must be filled out");
		return false;
	}	
	else if (/[^a-zA-Z0-9\-\_]/.test(usernameValidate))
	{
		alert("Username cannot have any special characters except for dashes and underscores.");
		return false;
	}
}
</script>

<html>
<head>
    <title>Online Virus Defender - Admin Registration</title>
    <meta charset="utf-8"/>
    <link rel = "stylesheet" href="style.css" type="text/css" />
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
</head>

<body class = "body" bgcolor="#c9cdd3"style="width:870px; margin:0 auto;">
<header class = "mainheader">
	<img src = "register.png">
</header>

<center>
<div class = "container">
	<div class="wrapper">
		<form action="registerAdmin.php" method="post" name="adminform" class="form-signin" onsubmit="return validateUserInputs()">       
		    <h4 class="form-signin-heading">Admin Registration </h4>
			  <hr class="">	  
			  Username:<input type = "text" class = "form-control" placeholder="Appropriate username" name="username" class="textinput" required maxlength="20">
			  Password:<input type = "password" class = "form-control" placeholder ="Password will be encrypted" name="password" class="textinput" required>
			  <button class="btn abtn-lg btn-primary btn-block"  name="register_btn" value="Register Me Now!" type="submit"> Register Me Now! </button>  			
		</form>			
	</div>
<div align ="center"> 
<a href="adminlogin.php"> <p class="font-weight-light">Take me back!</p> </a>
</div>
</div>
</center>
</body>
</html>

<style>
.wrapper 
{    
	margin-top:0px;
	margin-bottom:0px;
}

.form-signin 
{
  max-width: 500px;
  padding: 10px 40px 50px;
  margin: 0 auto;
  background-color: gold;
  border: 1px dotted rgba(1,2,3,4.5);  
 }

.form-signin-heading
{
  text-align:center;
  margin-bottom: 10px;
}

input[type="password"] 
{
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

</style>