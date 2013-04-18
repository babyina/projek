<?php 
session_start();/*
if ($_SESSION['valid'] == false){
	$url	= $_SERVER['PHP_SELF'];
	$qs		= $_SERVER['QUERY_STRING'];
	$urlFrom= $url.'?'.$qs;
	echo "<script> alert(\"Nama dan KataLaluan tidak sepadan\"); </script>";
	//echo "Session Timeout";
	//echo '<br>'.$urlFrom;
	header("location:../index.php?urlFrom=".$urlFrom);
	exit(0);
}else{
	if($_SESSION['timer']<>null){
		if(time() - $_SESSION['timer'] >900){
		//auto logout after 5 minute
			header("location:../auto_logout.php");
			exit(0);
		}	
	}
	
}*/

include('../config.php');
include('../keyword.php');

//if($_SESSION['jawatan'] == "PSU")
//	$app = "psu";
//else
//{
//echo $_SESSION['roles'];

	$app = "";
	$result = (strpos($_SESSION['roles'],"8"));
	if($result === false)
	{
		$app = $app;	
	}
	else
	{	
		$app = "psu";
	}
	
/*	$result2 = (strpos($_SESSION['roles'],"3"));
	if($result2 === false)
	{
		$app = $app;	
	}
	else
	{	
		$app = "yes";
	}
*/	
	$result2 = (strpos($_SESSION['roles'],"9"));
	if($result2 === false)
	{
		$app = $app;	
	}
	else
	{	
		$app = "yes";
	}
//}

function checkRole($userid,$conn){
$qry = "SELECT roles FROM pengguna WHERE id = '$userid' or nokp='$userid'";	
$result = mysql_query($qry,$conn);
$rows = mysql_fetch_array($result);
$roles = explode("+",$rows['roles']);
	for($i = 0; $i < count($roles)+1; $i++){
		if($roles[$i] == 1){
			$access = 1;
			return $access;
			exit;
		}
		if($roles[$i] == 3){
			$access = 1;
			return $access;
			exit;
		}
		if($roles[$i] == 8){
			$access = 1;
			return $access;
			exit;
		}
		if($roles[$i] == 9){
			$access = 1;
			return $access;
			exit;
		}		
	}
}

$access = checkRole($_SESSION['userid'],$conn);
if($access < 1){
	echo $acl_deny_access;
	exit(0);
}

//$sys_acl = checkModul($conn,$db_voffice,"Modul5",$_SESSION['userid']);
//if($sys_acl==0 || $sys_acl >=5){
//	echo $acl_deny_access;
//	exit(0);
//}

?>
<html>
<head>
	<title>Sistem Pentadbiran</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../ttip.js"></script>
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></script>
</head>
	<body>
		<table border=0 width=100% cellspacing=0 height="100%">
			<tr><td style="padding:0px"><?php include("../header.php") ?></td></tr>
			<tr height="100%"><td style="padding:0px">
				<table border=0 width=100% cellspacing=0 height="100%">
					<tr>
						<td valign="top" width="200" bgcolor="#e7efff" style="padding-left:10px">
							<div align="center">
								<a href="../mainmenu.php"><img src="../images/home.gif" border="0" alt="Menu Utama"/></a> <a href="../logout.php"></a>
								<a href="../logout.php"><img src="../images/logout.gif" alt="Logout" width="20" height="20" border="0" align="bottom"/></a>
							</div>
							<?php include("menu.php")?>
						</td>
						<td valign="top" bgColor="#e7efff" style="padding:10px 10px">
							<table width="100%">
							<tbody>
							<?php if($_GET['action']=='list' || $_GET['action']==''){?> 
								<tr>
									<form action="redirect.php" method="post"/>
									<td align="right" valign="top" bgColor="#e7efff">
										Carian Mengikut Nama atau No. KP : 
										  <input name="carian" type="text" class="txt"> 
										<input type="submit" value="Cari" class="button"/>
									</td>
									</form>
								</tr>
							<?php } ?>
							<tr>
								<td valign="top" bgColor="#e7efff"><?php include("content.php") ?></td>
							</tr>
							</tbody>
							</table>
						</td>
					</tr>
				</table>
			</td></tr>
			<tr><td style="padding:0px"><?php include("../footer.php") ?></td></tr>
		</table>
	</body>
</html>