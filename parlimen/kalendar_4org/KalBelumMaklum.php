<?php
//Akan jana satu list pegawai yg bertugas yg BELUM DIMAKLUMKAN bagi mesyuarat ini.

include("../checkSession.php");
include("../config.php");
include("../keyword.php");

$id			= $_GET['id'];
$parlimen	= $_GET['plm'];
$penggal	= $_GET['pgl'];
$mesyuarat	= $_GET['msyt'];
$dwn		= $_GET['dwn'];

$sqlBelum	= "SELECT DISTINCT PegawaiBtugas,Agensi
				FROM 
					kal_pegawaitugas 
				WHERE 
					Kal_mesyuarat_id='$id'
					AND Maklum_email='0'
					AND PegawaiBtugas IS NOT NULL ";
if(!empty($dwn)){
	$sqlBelum	.= "AND Dewan='$dwn' ";
}
$sqlBelum	.= "ORDER BY PegawaiBtugas";

$rsBelum	= mysql_query($sqlBelum);
$rowNum		= mysql_num_rows($rsBelum);

?>
<html>
<head>
<title>Senarai Belum Maklum</title>
<SCRIPT LANGUAGE="JAVASCRIPT" SRC="sorttable.js"></SCRIPT>
<SCRIPT type=text/javascript>
function confirmJobCatDelete(aURL) {
	if(confirm('Deleting a project status category will remove reference to any project/s still categorized with that status.\n\nAre you sure you want to delete this project category?')) {
		location.href = aURL;
	}
}

function toggleJobCats(which) {
	if(document.getElementById("jobcat_"+which).style.display=="block") {
		document.getElementById("jobcat_"+which).style.display="none";
		document.getElementById("icon_open_"+which).style.display="none";
		document.getElementById("icon_closed_"+which).style.display="block";
	} 
else {
	document.getElementById("jobcat_"+which).style.display="block";
	document.getElementById("icon_open_"+which).style.display="block";
	document.getElementById("icon_closed_"+which).style.display="none";
	}
}

function closeCats() {
	if (document.getElementById("jobcat_1")) { 
		document.getElementById("jobcat_1").style.display="none";
		document.getElementById("icon_open_1").style.display="none";
		document.getElementById("icon_closed_1").style.display="block";
	}

	if (document.getElementById("jobcat_2")) { 
		document.getElementById("jobcat_2").style.display="none";
		document.getElementById("icon_open_2").style.display="none";
		document.getElementById("icon_closed_2").style.display="block";
	}

	if (document.getElementById("jobcat_3")) { 
		document.getElementById("jobcat_3").style.display="none";
		document.getElementById("icon_open_3").style.display="none";
		document.getElementById("icon_closed_3").style.display="block";
	}

	document.getElementById("jobcatslinkopen").style.display="inline";
	document.getElementById("jobcatslinkclose").style.display="none";
}

function openCats() {

	if (document.getElementById("jobcat_1")) {
		document.getElementById("jobcat_1").style.display="block";
		document.getElementById("icon_open_1").style.display="block";
		document.getElementById("icon_closed_1").style.display="none";
	}
	
	if (document.getElementById("jobcat_2")) {
		document.getElementById("jobcat_2").style.display="block";
		document.getElementById("icon_open_2").style.display="block";
		document.getElementById("icon_closed_2").style.display="none";
	}
	
	if (document.getElementById("jobcat_3")) {
		document.getElementById("jobcat_3").style.display="block";
		document.getElementById("icon_open_3").style.display="block";
		document.getElementById("icon_closed_3").style.display="none";
	}
	
	document.getElementById("jobcatslinkopen").style.display="none";
	document.getElementById("jobcatslinkclose").style.display="inline";
}
</SCRIPT>

<STYLE type=text/css>
	.rel {POSITION: relative; width:100%;}
	.abs {POSITION: absolute; width:100%;}
	.right { text-align:right; }
	.left { text-align:left; }
	.center { text-align:center; }
</STYLE>
</head>
<body>

<SCRIPT LANGUAGE="JavaScript" SRC="include/CheckBoxGroup.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	var notifyNameGroup = new CheckBoxGroup();
	notifyNameGroup.addToGroup("notifyName[]");
	notifyNameGroup.setControlBox("allnotifyNames");
	notifyNameGroup.setMasterBehavior("all");
</SCRIPT>

<form name="frm_belumMaklum" method="post" action="KalProses.php">
<fieldset>
<legend>Senarai Belum Maklum</legend>
<table width="100%"><tr>
          <TD class=contractcopy 
          style="PADDING-RIGHT: 6px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px" 
          align=right>All Categories:&nbsp;<A class=textlinks 
            id=jobcatslinkopen style="DISPLAY: none" 
            href="javascript:openCats();">open</A><A class=textlinks 
            id=jobcatslinkclose style="DISPLAY: inline" 
            href="javascript:closeCats();">closed</A></TD>
</tr></table>
<table width="100%" border="0" bordercolor="#666666">
	<tr >
		<td width="30"><input name="allnotifyNames" type="checkbox" class="checkbox" onclick="notifyNameGroup.check(this);" value="0"></td>
		<td width="29">Bil</td>
		<td width="362">Nama</td>
		<td width="344">Agensi</td>
		<td width="362"> Emel</td>
		<TD width="60" class=contractcopy 
		style="PADDING-RIGHT: 6px; PADDING-BOTTOM: 3px; PADDING-TOP: 3px" 
		align=right>&nbsp;</TD>
	</tr>
	<!-- Begin nama pegawai bertugas -->
	<?php
	$x	= 1;
	while ($rowBelum	= mysql_fetch_array($rsBelum)){
		$pegawaiBtugas	= $rowBelum['PegawaiBtugas'];
		$agensi			= $rowBelum['Agensi'];
		$emailPgw		= lookup($conn, "pengguna", "emel", "nama='$pegawaiBtugas'");
		?>
		<tr class="<?=$row_color?>" valign="top" bgcolor="#e6e6e6" background="images/bg_mainbarfade.gif">
			<td><input name="notifyName[]" type="checkbox" class="checkbox" onclick="notifyNameGroup.check(this);" value="<?php echo $pegawaiBtugas?>">&nbsp;</td>
			<td><?php echo $x;?>.</td>
			<td><?php echo $pegawaiBtugas;?></td>
			<td><?php echo $agensi;?></td>
			<td><?php echo $emailPgw;?></td>
			<TD style="PADDING-RIGHT: 2px"><A 
                  href="javascript:toggleJobCats(1);"><IMG id=icon_closed_1 
                  style="DISPLAY: none" height=15 alt=Open 
                  src="images/icon_object_closed.gif" 
                  width=15 align=absMiddle border=0><IMG id=icon_open_1 
                  style="DISPLAY: block" height=15 alt=Close 
                  src="images/icon_object_open.gif" width=15 
                  align=absMiddle border=0></A>
			</TD>
		</tr>

		<!-- Begin Maklumat bertugas -->
		<?php 
		$sqlHari	= "SELECT * FROM kal_pegawaitugas WHERE PegawaiBtugas='$pegawaiBtugas' AND Maklum_email='0' ORDER BY Tarikh";
		$rsHari	= mysql_query($sqlHari);
		while ($rowHari	= mysql_fetch_array($rsHari)){ ?>
			<div id="jobcat_1" style="display: block ">
			<tr classx="<?=$row_color?>" valign="top">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan="3">
					<table width="100%"  border="0">
							<tr class="<?=$color2?>" valign="top">
								<td width="20">&nbsp;</td>
								<td width="253"><?php echo DisplayDate($rowHari['Tarikh']) ?></td>							
							 	<td width="374"><?php echo $rowHari['Sesi'] ?></td>
							</tr>
					</table>
				</td>
				<td>&nbsp;</td>
			</tr>
			</div>
		<?php } ?>
		<!-- End Maklumat Anak -->

	<?php $x++;
	} ?>
</table>
<div align="right">
<input type="hidden" name="idKalendar" value="<?php echo $id?>">
<input type="hidden" name="parlimen" value="<?php echo $parlimen?>">
<input type="hidden" name="penggal" value="<?php echo $penggal?>">
<input type="hidden" name="mesyuarat" value="<?php echo $mesyuarat?>">
<input type="submit" class="button" name="hantarMaklum" value="Hantar">
<input type="button" class="button" name="tutup" value="Tutup" onClick="window.close()">
</div>
</fieldset>
</form>
</body>
</html>