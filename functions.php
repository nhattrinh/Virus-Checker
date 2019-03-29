<?php

//Functions.php contains functions required for the Online AV tool.


//Alert function (JavaScript translated to PHP):
function alert($message)
{
	echo '<script type = "text/javascript">alert("'.$message.'"); </script>';
}

//Function for creating a 'fileArchives' directory:
function createFileArchives()
{
	if (!file_exists('fileArchives'))
	{
		mkdir('fileArchives', 0777, true);
	}
}

//Function for creating a 'contributorFileArchives' directory:
function createContributorFileArchives()
{
	if (!file_exists('contributorFileArchives'))
	{
		mkdir('contributorFileArchives', 0777, true);
	}
}

//Function that extracts the first 20 bytes of the file:
function extractFileSignature($file)
{	$extensionInfo = pathinfo($file);
	if ($extensionInfo["extension"] == "")
	{
		alert("Please upload a file to be scanned!");
	}
	else
	{
		$fileOpen = fopen($file, "rb");
		$fileSize = filesize($file);
		$contents = fread($fileOpen, $fileSize);
		fclose($fileOpen);
		$bitStorage = "";

		//If file size has 20 bytes or more:
		if ($fileSize >= 20)
		{
			//Iterating for the first 20 bytes of the file:
			for($i = 0; $i < 20; $i++)
			{ 
				//Characters that are represented as the index position of the byte:
				$characters = $contents[$i];
		
				//Convert to the base ten value of the character:
				$baseValueConverted = ord($characters);
		
				//Convert to Binary:
				$binaryConverted = base_convert($baseValueConverted,10,2);

				//Convert to Hex
				$hexConverted = base_convert($binaryConverted,2,16);
				$bitStorage .= $hexConverted;
			}
			return $bitStorage;
		}
		
		//If file size has less than 20 bytes:
		else
		{
			//Iterating through the fileSize:
			for($i = 0; $i < $fileSize; $i++)
			{ 
				//Characters that are represented as the index position of the byte:
				$characters = $contents[$i];
		
				//Convert to the base ten value of the character:
				$baseValueConverted = ord($characters);
		
				//Convert to Binary:
				$binaryConverted = base_convert($baseValueConverted,10,2);

				//Convert to Hex
				$hexConverted = base_convert($binaryConverted,2,16);
				$bitStorage .= $hexConverted;
			}
			return $bitStorage;
		}
	}
}

?>