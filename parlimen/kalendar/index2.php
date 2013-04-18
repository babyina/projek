<?php
ob_start();
session_start();
//--------------------- auto logout ----------------------------//
if($_SESSION['timer']<>null){
	if(time() - $_SESSION['timer'] >900){
		//auto logout after 5 minute
		header("location:../auto_logout.php");
		exit(0);
	}	
}
$_SESSION['timer'] = time()+0; //set to current time
require("../comm.php");
include('../keyword.php');
$sys_acl = checkModul($conn,$db_voffice,"Modul3",$_SESSION['userid']);
if($sys_acl==0 || $sys_acl >=5){
	echo $acl_deny_access;
	exit(0);
}
if($_SESSION['valid'] == 'TRUE'){
	?>
	<html>
	<head>
	<title>Kalendar Parlimen</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" href="../style.css" id="style">
	<script language='javascript' src="../popcalendar.js"></script>
	<SCRIPT LANGUAGE="JavaScript" SRC="../lw_layers.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript" SRC="../lw_menu.js"></SCRIPT> 
	<style>		
		
		.th1{background-color:#668B8B;color:#ffffff;border-color:#ffffff}
		
	</style>
	<script language="javascript">
		function IsNumeric(sText){
			var ValidChars = "0123456789";
			var IsNumber=true;
			var Char; 
			for (i = 0; i < sText.length && IsNumber == true; i++){ 
				 Char = sText.charAt(i); 
				 if (ValidChars.indexOf(Char) == -1){
					IsNumber = false;
				}
			}
			return IsNumber;   
		}
		
		function validateForm(form){			
			if(form.name == 'borang_mesyuarat'){
				if(form.Penggal[form.Penggal.selectedIndex].text==""){
					alert("Sila pilih penggal parlimen");return false;
				}
				else if(form.Parlimen[form.Parlimen.selectedIndex].text==""){
					alert("Sila pilih parlimen");return false;
				}
				else if(form.Mesyuarat[form.Mesyuarat.selectedIndex].text==""){
					alert("Sila pilih mesyuarat");return false;
				}
				else if(form.Sesi[form.Sesi.selectedIndex].text==""){
					alert("Sila pilih sesi dewan");return false;
				}
			}
			else if(form.name == "borang_butiran"){
				if(form.Minggu[form.Minggu.selectedIndex].text == ""){
					alert("Sila pilih minggu"); return false;					
				}
				else if(form.Tarikh.value==""){
					alert("Sila isikan tarikh"); return false;
				}
				else if(form.Urusan.value==""){
					alert("Sila isikan urusan"); return false;
				}
				else if(form.BilHari.value != ""){
					if(!IsNumeric(form.BilHari.value)){
						alert("Sila isikan bilangan hari dengan betul"); return false;
					}
				}
			}
		}
		function deleteDoc(mode,id,pid){				
			if(confirm("Hapus Rekod ?")){								
				document.delete_form.id.value = id;
				document.delete_form.mode2.value = mode;
				document.delete_form.pid.value = pid;
				document.delete_form.deleteDoc.click();				
			}
			return false;
		}
		var jab = new Array();
		function addJabatan(key){
			document.borang.Jabatan.value = key;
		}
		function openJadual(id){		
			var doc = document.borang2;
			var param = "";
			sap = "";
			if(doc.week.length)
				for(var i=0;i<doc.week.length;i++){
					if(doc.week[i].checked){
						param += sap + doc.week[i].value;				
						sap = ",";
					}
				}
			else
				param = doc.week.value;
			if(param==''){
				alert('Sila pilih minggu');
				return false;
			}
			var url = 'pdf_jadual.php?id='+id+'&minggu='+param;		
			window.open(url);
			return false;
		}
		
		
	</script>
	</head>

	<body bgcolor="E7EFFF" leftmargin="0" bottommargin="0" topmargin="0" rightmargin="0">
		<div style="position:absolute;visibility:hidden">
		<form name="delete_form" id="delete_form" method="post">
			<input name="id" value=""/><input name='mode2' value=""/>
			<input name="pid" value=""/>
			<input name="deleteDoc" type="submit" value="delete"/>
		</form>
		</div>
	<? include("header.php"); 
	   include ("../sys_name.php");
	?>
		
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="container">
		<tr>
			<td width="20%" class="leftbar"><?php include("menu.php") ?></td>
			<td valign="top"><?php include("container.php") ?></td>
		</tr>
	</table>	
	</body>
	<?php include("../footer.php"); ?>
	</html>
<?
	ob_end_flush();
}else{
	echo("session invalid");
}
?>