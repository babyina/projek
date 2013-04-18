<?php session_start();
if ($_SESSION['valid'] == false){
	echo "invalid session";	
	exit(0);
}else{/*
	if($_SESSION['timer']<>null){
		if(time() - $_SESSION['timer'] >900){
		//auto logout after 5 minute
			header("location:../auto_logout.php");
			exit(0);
		}	
	}
	*/
}
include("../config.php");
include('../keyword.php');
?>
<html>
<head>
<title>Sistem Maklumbalas Parlimen</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<!--<SCRIPT LANGUAGE="JavaScript" SRC="../lw_layers.js"></SCRIPT>-->
<!--	<SCRIPT LANGUAGE="JavaScript" SRC="../lw_menu.js"></SCRIPT> -->
	
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
		<!-- Include the MULTI_UPLOAD function  -->
	<script src="multifile_compressed.js"></script>
</head>
	<body>
		<?php include("../header.php") ?>
		<table border=0 width=100% cellspacing=0>
			<tr>
				<td valign="top" width="200" class="menu"><?php include("menu.php")?>
				<div align="center"><img src="../images/home.gif"/><a href="../mainmenu.php">Menu Utama</a></div>
				</td>
				<td valign="top" bgColor="#e7efff"><?php include("content.php") ?></td>
			</tr>
		</table>
		<?php include("../footer.php") ?>
	</body>
</html>