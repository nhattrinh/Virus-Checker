<?php

require_once('dbConnect.php');	//Connects to DB and chooses the Antivirus DB.
include('functions.php'); //Contains all the necessary functions that will be used.

//Open session, so we can work with it.
session_start();


//Check to see if user is logged in, if so, send to success page.
if (ISSET($_SESSION["user"]))
{
	header("Location: UserPanel.php");
	exit();
}

//If user is not logged in, show the form and log in!
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
		$UserPost = $_POST['Username'];
		//Non-case sensitive:
		$UserLowerCase = strtolower($UserPost);
		$User = mysql_real_escape_string($UserLowerCase);
		$Pass = mysql_real_escape_string($_POST['Password']);
		$Pass = hash('sha512',$Pass);

		//Query match
		$query = mysql_query("SELECT * FROM contributorstable WHERE username = '$User' and password = '$Pass'") or die ("Failed ".mysql_error());
		$row = mysql_fetch_array($query);
		
		if ($row['username'] == $User && $row['password'] == $Pass)
		{
			$_SESSION["user"] = $User;
			header("Location: UserPanel.php");
			exit();
		}		
		else
		{
			alert("Invalid credentials, please try again!");
		}
}
mysql_close($conn);
?>

<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<head>
    <title>Online Virus Defender - User Contributor Login</title>
    <meta charset="utf-8"/>
    <link rel = "stylesheet" href="style.css" type="text/css" />
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
</head>

<body class = "body" bgcolor="#c9cdd3"style="width:870px; margin:0 auto;">
	<header class = "mainheader">
    	<img src = "logo.png">
    </header>

<div class = "container">
	<div class="wrapper">
		<form action="" method="post" name="loginform" class="form-signin">       
		    <h4 class="form-signin-heading">Contributor Login </h4>
			  <hr class="">
			  
			  <input type="text" class="form-control" name="Username" placeholder="Username" required="true"/>
			  <input type="password" class="form-control" name="Password" placeholder="Password" required="true"/>     		  
			  <button class="btn abtn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit"> Login </button>  			
		</form>			
	</div>
</div>

<div align ="center"> 
		<h5>
		<b><a href="registerContributors.php"> <p class="font-weight-light">Don't have an account? Create now!</p> </a> </b>
		</h5>
		<a href="index.php"> <p class="font-weight-light">Take me back!</p> </a>
</div>
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
  background-color: pink;
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