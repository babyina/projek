<?php
session_start();

//--------------------- auto logout ----------------------------//
if($_SESSION['timer']<>null){
	//if(time() - $_SESSION['timer'] >300){
	if(time() - $_SESSION['timer'] >1200){
		//auto logout after 5 minute		
		header("location:auto_logout.php");
		exit(0);
	}	
}
$_SESSION['timer'] = time()+0; //set to current time
if (!isset($_SESSION['valid'])) {
	echo "<center><strong><font color=red> Unauthorized User!</font></strong></center>";
	exit(0);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
<title>Sistem Pentadbiran</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="style.css" id="style"> 
</head>
<body style="margin-left:100px;margin-right:100px;margin-top:50px">
<table width="100%" border="1" cellpadding="0" cellspacing="0">
    <tr> 
    <td width="100%" height="50" valign="top">
	<center><img src="images/logo1.jpg"/><br/>
	</center>
	<br/><br/></td>
  </tr>
  <tr> 
    <td align="center"> 
      <?php include("menu.php"); ?>	  
    </td>
  </tr>
  </tr>
  <tr><td align="left" class="tdm"><?php $path = "manualssjptadbir.docx";
			echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">Download Manual Pentadbir SSJP</a><br>"; ?></td></tr>
	
  <tr>
	<td><?php include("footer.php") ?> </td>
  </tr>
</table>
</body>
</html>