<?php

//Use require_once
require_once('dbConnect.php');	//Connects to DB and chooses the Antivirus DB.
include('functions.php'); //Contains all the necessary functions that will be used.
session_start();

if (!ISSET($_SESSION["user"]))
	{
		header("Location: index.php");
		exit();
	}
	
	//If file is uploaded:
	if(isset($_POST['submit']) != "")
{
	$name = $_FILES['fileToUpload']['name'];
    $size = $_FILES['fileToUpload']['size'];
    $type = $_FILES['fileToUpload']['type'];
    $temp = $_FILES['fileToUpload']['tmp_name'];
	$virusType2 = $_POST['manualVirusType2'];
	
	if(isset($name))
	{
		
		if (!empty($name))
		{
			createContributorFileArchives();
			$location = ""; //For archieve purposes - location of where the file will be uploaded to, which is the ROOT FOLDER (www):
			if(move_uploaded_file($temp, $location.$name)) //If it was moved to the directory:
			{
				$hashSignatureAdmin = extractFileSignature($name);
					
				//Let us store it in the database:
				$query1 = "INSERT INTO `contributorsputativefilestable` (`id`, `type`, `filesignature`, `threatdetect`) VALUES (NULL, '".mysql_real_escape_string($virusType2)."', '".mysql_real_escape_string($hashSignatureAdmin)."', 'Doublecheck')";
				$result1 = mysql_query($query1);
	
				if($result1)
				{
					alert("Your file is currently scanning - Thank you for your support!");
					alert("File signature and its virus type has been uploaded and will be reviewed by an Admin");
					//Lastly - moving the file to the fileArchive folder:
					rename("$name", "contributorFileArchives/$name");
				}
				else
				{
					alert("Failed!");	
				}		
			}
		}
	}
}

mysql_close($conn);
?>

<script>
function validateMalware()
{
	var malwareNameValidate = document.forms["userMalwareForm"]["manualVirusType2"].value;
	if (malwareNameValidate == "")
	{
		alert("All fields must be filled out");
		return false;
	}
	else if (/[^a-zA-Z0-9]/.test(malwareNameValidate))
	{
		alert("Name of malware cannot have any special characters.");
		return false;
	}
}
</script>

<!--BootStrap-->
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="upload.js"></script>


<head>
    <title>Online Virus Defender - Contributor Panel</title>
    <meta charset="utf-8"/>
    <link rel = "stylesheet" href="style.css" type="text/css" />
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
</head>
<h6> Welcome, Contributor! </h6>

<div align="right">
<a href="logout.php"> Log out </a>
</div>

<body class = "body" bgcolor="#c9cdd3"style="width:870px; margin:0 auto;">
	<header class = "mainheader">	
    	<img src = "usercontributor.png">
    </header>
    

	 <!-- Upload Form Here --> 
	<form action="UserPanel.php" method="post" enctype="multipart/form-data" name="userMalwareForm" onsubmit="return validateMalware()">
	<center> <p class="font-weight-light">Upload File Below</p> </center>
		<div class = "mainContent" style="width:250px; margin:0 auto;">
		<input type="file"  name="fileToUpload" required id="fileToUpload">
		
		<center> Enter Malware Type:
		<input type = "text" name="manualVirusType2" class="textinput" required size="10" maxlength="20"></center>
		<input type="submit" value="Scan This File Now!" name="submit" style="width:250px; height:50px; color:red">
		<br>
	</div>
	</form>
</body>
</html>