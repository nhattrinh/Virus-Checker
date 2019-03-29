<?php
//Destroys all sessions.
session_start();
session_destroy();
header("Location: index.php");
exit();
mysql_close($conn);
?>

