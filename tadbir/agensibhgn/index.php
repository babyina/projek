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

include('../config.php');
include('../keyword.php');

$sys_acl = checkModul($conn,$db_voffice,"Modul6",$_SESSION['userid']);
if($sys_acl==0 || $sys_acl >=5){
	echo $acl_deny_access;
	exit(0);
}

?>
<html>
<head>
	<title>Sistem Pentadbiran</title>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<!--<SCRIPT LANGUAGE="JavaScript" SRC="../lw_layers.js"></SCRIPT>-->
	<!--<SCRIPT LANGUAGE="JavaScript" SRC="../lw_menu.js"></SCRIPT> -->
	<SCRIPT LANGUAGE="JavaScript" SRC="../function.js"></SCRIPT>
	<!--<script language="JavaScript" SRC="../function.js"></script>-->
	<script language="JavaScript">
	
	function validateForm(form){
			if(form.name == 'entry_form2'){
				if(form.kategori[form.kategori.selectedIndex].text==""){
					alert("Sila pilih Kategori.");
					form.kategori.focus();
					return false;
				}
				else if(form.butiran.value==""){
					alert("Sila masukkan Butiran");
					form.butiran.focus();
					return false;
				}
			}
			else if(form.name=='entry_form3'){
				if(form.pangkat.value==""){
					alert("Sila masukkan Pangkat.");
					form.pangkat.click();
					return false;
				}
			}
		}
		</script>
</head>
	<body>
		<table border=0 width=100% cellspacing=0 height="100%">
			<tr><td style="padding:0px"><?php include("../header.php") ?></td></tr>
			<tr height="100%"><td style="padding:0px">
				<table border=0 width="100%" height="100%" cellspacing=0>
					<tr>
						<td valign="top" width="200" bgcolor="#e7efff" style="padding-left:10px">
							<div align="center">
								<a href="../mainmenu.php"><img src="../images/home.gif" border="0" alt="Menu Utama"/></a> <a href="../logout.php"></a>
								<a href="../logout.php"><img src="../images/logout.gif" alt="Logout" width="20" height="20" border="0" align="bottom"/></a>
							</div>
							<?php include("menu.php")?>
						</td>
						<td valign="top" bgColor="#e7efff"><?php include("content.php") ?></td>
					</tr>
				</table>
			</td></tr>
			<tr><td style="padding:0px"><?php include("../footer.php") ?></td></tr>
		</table>
	</body>
</html>