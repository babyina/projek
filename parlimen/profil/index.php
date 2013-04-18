<?php session_start();
if ($_SESSION['valid'] == false){
	echo "invalid session";	
	exit(0);
}else{
	if($_SESSION['timer']<>null){
		if(time() - $_SESSION['timer'] >900){
		//auto logout after 5 minute
			header("location:../auto_logout.php");
			exit(0);
		}	
	}
}
include("../config.php");
include('../keyword.php');

$sys_acl = checkModul($conn,$db_voffice,"Modul3",$_SESSION['userid']);
if($sys_acl==0 || $sys_acl >=5){
	echo $acl_deny_access;
	exit(0);
}

$isCalUser = (checkOfficer($_SESSION['userid'],'3',$conn) or checkOfficer($_SESSION['userid'],'6',$conn));


?>
<title>Sistem Pengesanan Soal Jawab Parlimen</title>
<html>
<head>
	<link rel="stylesheet" href="../style.css"> 
	<script language='javascript' src="../popcalendar.js"></script>
	<!--<SCRIPT LANGUAGE="JavaScript" SRC="../lw_layers.js"></SCRIPT>-->
	<!--<SCRIPT LANGUAGE="JavaScript" SRC="../lw_menu.js"></SCRIPT> -->
	
	<script language="JavaScript" SRC="../function.js"></script>
	<script language="JavaScript">
	
	function validateForm(form){
			if(form.name == 'entry_form'){
				if(form.pangkat.value==""){
					alert("Sila masukkan Pangkat.");
					form.pangkat.focus();
					return false;
				}
				else if(form.nama_yb.value==""){
					alert("Sila masukkan Nama Y.B.");
					form.nama_yb.click();
					return false;
				}
				else if(form.Kawasan[form.Kawasan.selectedIndex].text==""){
					alert("Sila pilih Kawasan.");return false;
				}
				else if(form.Parti[form.Parti.selectedIndex].text==""){
					alert("Sila pilih Parti.");return false;
				}
			}
			else if(form.name=='entry_form2'){
				if(form.pangkat.value==""){
					alert("Sila masukkan Pangkat.");
					form.pangkat.click();
					return false;
				}
				else if(form.nama_yb.value==""){
					alert("Sila masukkan Nama Y.B. Senator.");
					form.nama_yb.focus();
					return false;
				}
				//else if(form.Negeri[form.Negeri.selectedIndex].text==""){
					//alert("Sila pilih Negeri.");return false;
				//}
			}
		}
		</script>
		
</head>
	<body>
	
<!-- untuk delete form -->
<div style="position:absolute;visibility:hidden">
	<form name="delete_form" id="delete_form" method="post">
		<input name="id" value=""/>
		<input name="pid" value=""/>
		<input name="mode" value=""/>
		<input name="deleteDoc" type="submit" value="delete"/>
	</form>
</div>
	
<?php include("../header.php") ?>
<table border=0 width=100% cellspacing=0>
<tr>
	<td valign="top" width="200" class="menu"><p align="center"><img src="../images/home.gif"/><a href="../mainmenu.php">Menu Utama</a></p>
	<?php include("menu.php")?>
	</td>
	<td valign="top" bgColor="#e7efff"><?php include("content.php") ?></td>
</tr>
</table>
<?php include("../footer.php") ?>
</body>
</html>