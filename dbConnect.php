<?php

//Connection to the MYSQL Database (WAMP):
ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
$conn=new mysqli("localhost","root","password","antivirusdb") or die(mysql_error());

//Selecting the MYSQL Database to work with:
// $sdb=mysql_select_db("antivirusdb",$conn) or die(mysql_error());

?>