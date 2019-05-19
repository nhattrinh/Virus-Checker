<?php

	require_once 'verify_session.php'; // programmer defined methods to prevent session hijacking

	verify_session(basename(__FILE__)); // check the session
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<title>Infected File</title>
<center>
	<div><form action="infected_file.php" method="post" enctype="multipart/form-data">
		<br><h1>Submit a File to Check</h1><br/><br/><br/><br/>
		<input name="check_file" type="file" required=""/>
		<br/><br/>
		<button type="submit">Submit</button>
		<br/><br/>
	</form></div>
	<?php
		if (isset($_SESSION['admin'])) 
		{
			echo <<<_END
				<div><form action="infected_file.php" method="post" enctype="multipart/form-data">
				<br><font size="5"><b>Add Infected File Submission</b></font><br><br>
				<input name="virus_name" type="text" placeholder="Virus Name" required=""><br><br>
				<input name="add_virus"  type="file" required=""/>
				<button type="submit">Submit Infected</button><br><br>
				</form></div><br>
_END;
		}
	?>
	<form>
		<br><button type="submit" formaction="user_logout.php">Logout</button><br><br>
	</form>
</center>
</html>

<?php
	require_once 'db_login.php'; 
	require_once 'mysql_methods.php'; 
									  
	if(isset($_FILES['check_file']['name']) && (isset($_SESSION['user']) || isset($_SESSION['admin'])))
	{
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) mysql_fatal_error($conn->connect_error);

		move_uploaded_file($_FILES['check_file']['tmp_name'], $_FILES['check_file']['name']);
		$sig = signature_hex($_FILES['check_file']['name'], $_FILES['check_file']['size']);
		scan_file($conn, $sig);

		$conn->close();
	}

	if(isset($_FILES['add_virus']['name']) && isset($_POST['virus_name']) && isset($_SESSION['admin']))
	{
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) mysql_fatal_error($conn->connect_error);

		$name = mysql_fix_string($conn, $_POST['virus_name']);

		move_uploaded_file($_FILES['add_virus']['tmp_name'], $_FILES['add_virus']['name']);
		$sig = signature_hex($_FILES['add_virus']['name'], $_FILES['add_virus']['size']);

 		$sig = substr($sig, 0, 20);

 		add_virus($conn, $name, $sig);

		$conn->close();
	}

	function signature_hex($file, $size) 
	{
		$sig = "";

		if($handle = fopen($file, 'r')) 
		{
			$contents = fread($handle, $size);

			for ($i = 0; $i < $size; $i++) 
			{
				$ascii = $contents[$i];
				$dec = ord($ascii);
				$hex = base_convert($dec, 10, 16);
				$sig .= $hex;
			}
			return $sig;
		}
		else
			die("File does not exist or you lack permission to open it");
	}

	function scan_file($conn, $sig)
	{
		$infected = false;
		$virus_list = array();
		$infected_bytes = $sig;
		//$infectied_pos = array();
		$query = "SELECT * FROM virus;";
		$result = $conn->query($query);
		if (!$result) mysql_fatal_error($conn->error);

		for ($i = 0; $i < $result->num_rows; $i++)
		{
			$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_NUM);
			$virus_name = $row[0];
			$virus_sig = $row[1];
			if (strlen($sig) >= strlen($virus_sig))
			{
				if (!empty($virus_sig) && strpos($sig, $virus_sig) !== false) { // infected file
   					echo '<script type="text/javascript">alert("Infected File -> Virus Name: ' . $virus_name . '"); </script>';					
   					array_push($virus_list, array($virus_name, $virus_sig));
   					//$pos = strpos($sig, $virus_sig);
   					//$end = $pos + strlen($virus_sig) - 1;
   					//array_push($infectied_pos, "$pos-$end");
					$infected_bytes = mark_infected_bytes($virus_sig, $infected_bytes);
					$infected = true; 
				}
			}
			/*
			else
			{
				if (!empty($virus_sig) && strpos($virus_sig, $sig) !== false) { // infected file
					echo '<script> alert("Infected file"); </script>';
					array_push($virus_list, array($virus_name, $virus_sig));
					$infected = true; 
				}
			}
			*/
		}

		if(!$infected)
			echo '<script> alert("Secure file"); window.location = "infected_file.php"; </script>';
		//print_r($infectied_pos);
		//show_infected_file_results($infected_bytes, $infectied_pos, $virus_list);
		show_infected_file_results($infected_bytes, $virus_list);
		$result->close();
	}

	function add_virus($conn, $name, $sig)
	{
		if (record_exist_virus_tbl($conn, $name, $sig)) {
			echo '<script> alert("Duplicate record"); window.location = "infected_file.php"; </script>';
			exit;
		}

 		$date  = date("Y-m-d");
		$time  = date("H:i:s");

		if ($result = $conn->prepare("INSERT INTO virus(name, signature, date, time) VALUES(?,?,?,?)")) { // create a prepare statement
			$result->bind_param('ssss', $name, $sig, $date, $time);
			$result->execute();
			$result->close();
			echo '<script> alert("Virus added"); </script>';
			show_recorded_inserted($conn, $name, $sig);
		}
		else
			mysql_fatal_error($conn->error); 	
	}

	function record_exist_virus_tbl($conn, $name, $sig)
	{

		if ($result = $conn->prepare("SELECT * FROM virus WHERE name=? AND signature=?;")) { // create a prepare statement
			$result->bind_param('ss', $name, $sig);
			$result->execute();
			$result->store_result();
		}
		else 
			mysql_fatal_error($conn->error);
		
		if ($result->num_rows == 1) {
			$result->close();
			return true;
		}

		$result->close();		
		
		return false;
	}

	function show_recorded_inserted($conn, $name, $sig)
	{

		if ($result = $conn->prepare("SELECT * FROM virus WHERE name=? AND signature=?;")) { // create a prepare statement
			$result->bind_param('ss', $name, $sig); 
			$result->execute(); 
			$result->store_result(); 
		}
		else 
			mysql_fatal_error($conn->error);
		if ($result->num_rows == 1) {
			$result->bind_result($name, $sig, $date, $time, $id); 
			$result->fetch(); 
			echo "<center><b><font color='green'>Added Record to Database: CS 174 and Table: Virus</font></b></center><br><br>";
			echo "<center><table>
			<tr>
			<th><center>Virus Name</center></th>
			<th><center>Virus Signature</center></th>
			<th><center>Date</center></th>
			<th><center>Time</center></th>
			<th><center>ID</center></th>
			</tr>";
			echo "<td><center>" . $name . "</center></td>";
		    echo "<td><center>" . $sig . "</center></td>";
		    echo "<td><center>" . $date . "</center></td>";
		    echo "<td><center>" . $time . "</center></td>";
		    echo "<td><center>" . $id . "</center></td>";
		    echo "</tr>";
		    echo "</table></center><br><br><br>";
		}
		else 
			mysql_fatal_error($conn->error);
	}

	function show_infected_file_results($infected_bytes, $list)
	{
		echo "<center><font color='red'><b>Infected Bytes:</b></font></center><br>";
		echo $infected_bytes; echo "<br><br>";
		echo "<center><font color='red'><b>" . count($list) . " Matches Found:</b></font></center><br>";
		echo "<center><table>
		<tr>
		<th><center>Virus Name</center></th>
		<th><center>Virus Signature</center></th>
		</tr>";

		foreach($list as $row) {
			echo "<tr>";

			foreach($row as $value)
			    echo "<td><center>" . $value . "</center></td>";

		    echo "</tr>";
		}

		echo "</table></center><br><br><br>";
	}

	function mark_infected_bytes($find, $string)
	{
		$replace = "<font color='red'>$find</font>";
		return str_replace($find, $replace, $string);
	}

?>