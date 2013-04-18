<?php 
include("../checkSession.php");
include("../config.php");
include("../keyword.php");
include("include/func.php");

//Check 
//  - user mesti boleh access 'modul 2'
//  - utk masuk data, user mestilah dari roles '3' atau '6'
//  - petunjuk : 
//			modul 2 = Modul Kalendar
//			role 3  = Kategori Pengguna : HEK
// 			role 6	= Kategori pengguna : Agensi-pegawai bertugas
//			sys_acl	=> 	1=delete,edit,cipta,baca; 
//						2=edit,cipta,baca; 
//						3=cipta,baca; 
//						4=baca; 
//						5=no access

$sys_acl 	= checkModul($conn,$db_voffice,"Modul2",$_SESSION['userid']);
if($sys_acl==0 || $sys_acl >=5){
	echo $acl_deny_access;
	exit(0);
}
$isCalUser		= (checkOfficer($_SESSION['userid'],'3',$conn) or checkOfficer($_SESSION['userid'],'6',$conn));
$isCalHek		= checkOfficer($_SESSION['userid'],'3',$conn);
$isCalBertugas	= checkOfficer($_SESSION['userid'],'6',$conn);

?>
<title>Sistem Pengesanan Soal Jawab Parlimen</title>
<html>
<head>
	<link rel="stylesheet" href="../style.css">
	<link rel="stylesheet" href="include/kalendar.css">

	<script language='javascript' src="../popcalendar.js"></script>
	<script language="javascript" src="../function.js"></script>
	<script language="javascript" src="../multifile_compressed.js"></script>	
	<script language="javascript" src="include/func.js"></script>
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
		/******************************************************************
		Cth pakai :
			if(form.Penggal[form.Penggal.selectedIndex].text==""){
				alert("Sila pilih penggal parlimen");return false;
			}		
			else if(form.BilHari.value != ""){
				if(!IsNumeric(form.BilHari.value)){
					alert("Sila isikan bilangan hari dengan betul"); return false;
				}
			}
			else if(form.Tarikh.value==""){
				alert("Sila isikan tarikh"); return false;
			}			
		******************************************************************/
			if(form.name == 'frm_kal'){
				if(form.tarikhMula.value==""){
					alert("Sila pilih tarikh mula dari kalendar");
					form.imgCalendar1.click();
					return false;
				}
				else if(form.tarikhAkhir.value==""){
					alert("Sila pilih tarikh akhir dari kalendar");
					form.imgCalendar2.click();
					return false;
				}
			}
			else if(form.name=='frm_cuti'){
				if(form.tarikh.value==""){
					alert("Sila pilih tarikh dari kalendar");
					form.imgCalendar.click();
					return false;
				}
				else if(form.cuti.value==""){
					alert("Sila masukkan nama bagi cuti ini.");
					form.cuti.focus();
					return false;
				}
			}
			else if(form.name=='frm_laporanDewan'){
				if(form.tarikhSidang.value==""){
					alert("Sila pilih tarikh dari kalendar");
					form.tarikhSidangCal.click();
					return false;
				}
				else if(form.masaTangguh.value==""){
					alert("Sila masukkan masa tangguh.");
					form.masaTangguh.focus();
					return false;
				}
				else if(form.pegawaiNama.value==""){
					alert("Sila pilih pegawai yang bertugas.");
					form.pegawaiNama.focus();
					return false;					
				}				
				else if(form.tarikhLaporan.value==""){
					alert("Sila pilih tarikh dari kalendar");
					form.tarikhLaporanCal.click();
					return false;
				}
				else if(form.tarikhSidang2.value==""){
					alert("Sila pilih tarikh dari kalendar");
					form.tarikhSidang2Cal.click();
					return false;
				}
				else if(form.masaSidang2.value==""){
					alert("Sila masukkan masa persidangan seterusnya.");
					form.masaSidang2.focus();
					return false;
				}
			}
		}
	</script>
</head>
<body>
	<!-- hidden form: untuk delete form -->
	<div style="position:absolute;visibility:hidden">
		<form name="delete_form" id="delete_form" method="post">
			<input name="id" value=""/>
			<input name="pid" value=""/>
			<input name="mode" value=""/>
			<input name="deleteDoc" type="submit" value="delete"/>
		</form>
	</div>
	<table border=0 width=100% cellspacing=0 height="100%">
		<tr><td style="padding:0px"><?php include("../header.php") ?></td></tr>
		<tr height="100%"><td style="padding:0px">
			<table border=0 width=100% height="100%" cellspacing="0" style="padding:0px;">
				<tr>
					<td valign="top" width="180" bgcolor="#e7efff" style="padding-left:10px">
					<div align="center">
						<a href="../mainmenu.php"><img src="../images/home.gif" border="0" alt="Menu Utama"/></a> <a href="../logout.php"></a>
						<a href="../logout.php"><img src="../images/logout.gif" alt="Logout" width="20" height="20" border="0" align="bottom"/></a>
					</div>
					<?php include("menu.php")?>
					</td>
					<td valign="top" bgColor="#e7efff" style="padding:10px 10px"><?php include("content.php") ?></td>
				</tr>
			</table>
		</td></tr>
		<tr><td style="padding:0px"><?php include("../footer.php") ?></td></tr>
	</table>
</body>
</html>