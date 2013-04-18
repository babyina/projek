<?php 


//ditambah coding satuid pada 12/11/2010
include_once('satuid/satuid_caslibrary.php');
$Login =phpCAS::getUser();
$_SESSION['ssologin']=1;


session_start();
require("config.php");
//$userid = $_POST['userid'];
//$password = $_POST['password'];

	/*$qry = "SELECT pengguna.nama as nama,jawatan, pengguna.agensi_id, pengguna.telefon, 	agensi.nama AS agensi FROM pengguna,agensi WHERE pengguna.id = '$userid' AND pengguna.password=MD5('$password') AND pengguna.agensi_id = agensi.id";*/
	
	$qry = "SELECT pengguna.nama as nama,jawatan, pengguna.agensi_id, pengguna.telefon, 	agensi.nama AS agensi FROM pengguna,agensi WHERE pengguna.id = '$Login'";
	

mysql_select_db($db_voffice, $conn) or die(mysql_error());
$result = mysql_query($qry,$conn) or die(mysql_error());
if(mysql_num_rows($result)>0)
{
	$row = mysql_fetch_array($result);
	//$_SESSION['userid'] = $userid;
	$_SESSION['userid'] = $Login;
	$_SESSION['nama'] = $row['nama'];
	$_SESSION['agensi'] = $row['agensi'];
	$_SESSION['agensi_id'] = $row['agensi_id'];
	$_SESSION['jawatan'] = $row['jawatan'];
	$_SESSION['telefon'] = $row['telefon'];
	$_SESSION['valid'] = true;				
	header("location:mainmenu.php");	
}
else {
	session_destroy();
}

?>
