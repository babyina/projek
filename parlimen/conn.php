<?php
$dbconn['host'] = "localhost";
$dbconn['user'] = "";
$dbconn['pwd'] = "";
$dbconn['dbname'] = "spmjmspsp";
// Connect to the database
$db = mysql_connect($dbconn['host'],$dbconn['user'],$dbconn['pwd']);
$db_select = mysql_select_db($dbconn['dbname'], $db)or die("Could not select database");
?>

