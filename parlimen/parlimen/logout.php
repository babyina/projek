<?php include("config.php");
session_start();//update history record$log_id = $_SESSION['_login_id'];
$logout = date("Y-m-d H:i:s");
$qry = "UPDATE history SET Logout = '$logout' WHERE Id = '$log_id'";mysql_select_db($db_voffice);mysql_query($qry,$conn) or die(mysql_error());session_clear();header("location:index.php");function session_clear(){	while (list ($key, $val) = each ($_SESSION)) {		session_unregister($key);			}	session_destroy();
}
?>