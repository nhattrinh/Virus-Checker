<?php

//Use require_once
require_once('dbConnect.php');	//Connects to DB and chooses the Antivirus DB.
include('functions.php'); //Contains all the necessary functions that will be used.

?>

<!--BootStrap-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="upload.js"></script>


<html lang = "en">
<head>
    <title>Online Virus Defender</title>
    <meta charset="utf-8"/>
    <link rel = "stylesheet" href="style.css" type="text/css" />
    <meta name="viewport" content="width = device-width, initial-scale=1.0">
</head>

<body class = "body" bgcolor="#c9cdd3"style="width:870px; margin:0 auto;">
	<header class = "mainheader">
	
	<div align ="right"> 
		 <a href="adminlogin.php"> <p class="font-weight-light">Aware of infected files? Login as Administrator now!</p> </a> 
	</div>
	
    	<img src = "logo.png">
    </header>
	
	<div align ="center"> 
		<h5>
		<b><a href="contributorlogin.php"> <p class="font-weight-light">Login as a contributor here!</p> </a> </b>
		</h5>
	</div>
    
	<div class = "mainContent" style="width:250px; margin:0 auto;">
	
	 <!-- Upload Form Here --> 
		<form action="index.php" method="post" enctype="multipart/form-data">
		
		<font size="4" style="color:orange"> <b> Select a file to scan: </b> </font>
	 <br>
		<input type="file"  name="fileToUpload" id="fileToUpload" required>
	 <br>
		<input type="submit" value="Scan This File Now!" name="submit" style="width:250px; height:50px; color:red">
		<br>
	</div>
	
</body>


<?php

//When "Scan This File Now!" button is hit:
if(isset($_POST['submit']) != "")
{
	$name = $_FILES['fileToUpload']['name'];
    $size = $_FILES['fileToUpload']['size'];
    $type = $_FILES['fileToUpload']['type'];
    $temp = $_FILES['fileToUpload']['tmp_name'];
	
	if(isset($name))
	{
		
		if (!empty($name))
		{
			createFileArchives();
			$location = ""; //For archieve purposes - location of where the file will be uploaded to, which is the ROOT FOLDER (www):
			if(move_uploaded_file($temp, $location.$name)) //If it was moved to the directory:
			{
				$hashSignature = extractFileSignature($name);
				?>
				
					 <div id="progress" style="width:870;border:1px solid #ccc auto;"></div>
					<!-- Progress information -->
					<center><div id="information" style="width"></div></center>
					<?php
					$processes = 2;
					for($i = 1; $i <= $processes; $i++)
					{
						$percent = intval ($i / $processes * 100)."%";
						
						// Javascript for updating the progress bar and information
						echo '<script language="javascript">
						document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:lightgreen;\">&nbsp;</div>";
						document.getElementById("information").innerHTML="Scanning, please wait - '.$percent.'.";
						</script>';
						echo str_repeat(' ',1024*64);
						// Send output to browser immediately
							flush();
						// Sleep one second so we can see the delay
							sleep(1);
					}
						// Tell user that the process is completed
						echo '<script language="javascript">document.getElementById("information").innerHTML="Results below:"</script>';
						echo '<script language="javascript">
							document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-color:white;\"></div>";
							</script>';
			}
			else
			{
				alert("Upload failed!");
			}
		}		

		//Compare with our databases' virus signatures:
		$queryResult = mysql_query("SELECT * FROM antivirustable WHERE filesignature = '$hashSignature'") or die(mysql_error());
		//Check matches:
		 $row = mysql_fetch_array($queryResult);
		//Will determine if the file scanned is in the virus signature DB - if so, its a virus.
			if (strcasecmp(trim($hashSignature),trim($row['filesignature'])) == 0) //Comparing
			{
				alert("ALERT! - THREAT DETECTED!");
				$nameToUpper = ucwords($name);
				$typeToUpper = ucwords($row['type']);

				?>
					<!-- Warning Divider -->
					<div class = "container" style="width:800px; margin:0 auto;">
					<div class="alert alert-danger">
					<center> <?php echo $nameToUpper; ?> has been succesfully scanned - Threat Found! </center>
					</div>
					
					<!-- Scan Details - Table -->
					<h5><font style="color:grey"><center>Scan Details</center></h5></font>
					<table class = "table table-striped">
	
						<thead>
							<tr>
								<th> FILE NAME </th>
								<th> VIRUS TYPE </th>
								<th> THREAT </th>
							</tr>
						</thead>
							<tbody>
									<tr>
										<td><font style="color:darkred"><?php echo $nameToUpper;?></font></td>
										<td><font style="color:darkred"><?php echo $typeToUpper;?></font></td>
										<td><font style="color:darkred">Yes</font></td>
									</tr>	
							</tbody>
					</table>
				</div>
	<?php			
			}
		//If file is clean:
		else
		{
			$nameToUpper = ucwords($name);
	?>
			<div class="alert alert-success">
			<center> <?php echo $nameToUpper; ?> has been succesfully scanned - No Threats Found </center>
			</div>
	<?php
		}
	}
	//Lastly - moving the file to the fileArchive folder:
	rename("$name", "fileArchives/$name");
}
		mysqli_close($conn);
	?>
</html>