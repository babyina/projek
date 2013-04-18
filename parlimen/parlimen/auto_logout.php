<?php
//include("config.php");	
session_start();
$log_id = $_SESSION['_login_id'];
$logout = date("Y-m-d H:i:s");
//$qry = "UPDATE history SET logout = '$logout' WHERE Id = '$log_id'";
//mysql_select_db($db_voffice);
//mysql_query($qry,$conn);
session_destroy();
?>
<html>
<body style="margin:100px">
	<div style="text-align:center;font-size:bold">
		<!--Abaikan:Sessi anda telah tamat disebabkan tiada aktiviti dalam tempoh masa 5 minit.<br/>-->
		Sesi anda telah tamat disebabkan tiada aktiviti dalam tempoh masa 20 minit.<br/>
		Sila <a href="../index.php">login</a> semula jika hendak menggunakan sistem.
	</div>
</body>

</html>