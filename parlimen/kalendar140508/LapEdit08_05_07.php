<?php
if($sys_acl>=4 && (!$isCalUser)){
	echo $acl_denied;
}else{

//submited field
	$sesiDewan		= $_POST['sesiDewan'];
	$tarikhSidang 	= Reverse($_POST['tarikhSidang']);
	$hari		 	= $_POST['hari'];
	$sesi			= $_POST['sesi'];
	$masaTangguh	= $_POST['masaTangguh'];
	$pegawaiNama	= $_POST['pegawaiNama'];
	$pegawaiBhg		= $_POST['pegawaiBhg'];
	$pegawaiTlfn	= $_POST['pegawaiTlfn'];
	$tarikhLaporan	= Reverse($_POST['tarikhLaporan']);
	$tarikhSidang2	= Reverse($_POST['tarikhSidang2']);
	$masaSidang2	= $_POST['masaSidang2'];
	$jumSoalan		= $_POST['JumSoalan'];
	$jumJawab		= $_POST['JumJawab'];
	$sahSoalanMent 	= isset($_POST['SahSoalanMent'])? $_POST['SahSoalanMent']:"1";
	$bilSoalan		= $_POST['BilSoalan'];
	$sahSoalanTamb	= $_POST['SahSoalanTamb'];
	$sahSoalanBerkaitan	= $_POST['SahSoalKaitan'];
	$sahIsuBerkaitan	=	$_POST['SahIsuBerkaitan'];
	$sahRangUndang	= $_POST['SahRangUndang'];
	$rang1			= $_POST['Rang1'];
	$rang2			= $_POST['Rang2'];
	$rang3			= $_POST['Rang3'];
	$rang4			= $_POST['Rang4'];
	$status1		= $_POST['StatusRang1'];
	$status2		= $_POST['StatusRang2'];
	$status3		= $_POST['StatusRang3'];
	$status4		= $_POST['StatusRang4'];

//Sekiranya mode edit
if($_GET['action']=='editLap'){
	$id = $_GET['id'];		
	$qry = "SELECT * FROM kal_lapdwn
			WHERE Kal_LapDwn_id ='$id'";	
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	
	//ThisRecord
	$sesiDewan		= $row['SesiDewan'];
	$tarikhSidang 	= Reverse($row['TarikhSidang']);
	$hari		 	= $row['Hari'];
	$sesi			= $row['Sesi'];
	$masaTangguh	= $row['MasaTangguh'];
	$pegawaiNama	= $row['PgwNama'];
	$pegawaiBhg		= $row['PgwBhg'];
	$pegawaiTlfn	= $row['PgwTelefon'];
	$tarikhLaporan	= Reverse($row['TarikhLaporan']);
	$tarikhSidang2	= Reverse($row['TarikhSidang2']);
	$masaSidang2	= $row['MasaSidang2'];
	$jumSoalan		= $row['JumSoalan'];
	$jumJawab		= $row['JumJawab'];
	$sahSoalanMent 	= isset($row['SahSoalanMent'])? $row['SahSoalanMent']:"1";
	$bilSoalan		= $row['BilSoalan'];
	$sahSoalanTamb	= isset($row['SahSoalanTamb'])? $row['SahSoalanTamb']:"1";
	$sahSoalanBerkaitan	= isset($row['SahSoalKaitan'])? $row['SahSoalKaitan']:"1";
	$sahIsuBerkaitan	= isset($row['SahIsuBerkaitan'])? $row['SahIsuBerkaitan']:"1";
	$sahRangUndang	= isset($row['SahRangUndang'])? $row['SahRangUndang']:"1";
	$rang1			= $row['Rang1'];
	$rang2			= $row['Rang2'];
	$rang3			= $row['Rang3'];
	$rang4			= $row['Rang4'];
	$status1		= $row['StatusRang1'];
	$status2		= $row['StatusRang2'];
	$status3		= $row['StatusRang3'];
	$status4		= $row['StatusRang4'];

//FOR TESTING PURPOSES
/*
if(isset($id)){
	$sahSoalanMent 	= 1;
	$sahSoalanTamb	= 1;
	$sahSoalanBerkaitan	= 1;
	$sahIsuBerkaitan	=	1;
	$sahRangUndang	= 1;
}
*/
//FOR TESTING PURPOSES

	$isVisibleSM	= ($sahSoalanMent!=1)? "none":"";
	$isVisibleST	= ($sahSoalanTamb!=1)? "none":"";
	$isVisibleSB	= ($sahSoalanBerkaitan!=1)? "none":"";
	$isVisibleIB	= ($sahIsuBerkaitan!=1)? "none":"";
	$isVisibleRU	= ($sahRangUndang!=1)? "none":"";

	//checking
	/*
	echo $sesiDewan.'<br>';
	echo $tarikhSidang.'<br>';
	echo $hari.'<br>';echo $sesi.'<br>';echo $masaTangguh.'<br>';echo $pegawaiNama.'<br>';echo $pegawaiBhg.'<br>';
	echo $pegawaiTlfn.'<br>';echo $tarikhLaporan.'<br>';echo $tarikhSidang2.'<br>';echo $masaSidang2.'<br>';
	*/
}

$userid			= $_SESSION['userid'];
$sqlPengguna	= "SELECT pengguna.nama, agensi.nama AS agensi, pengguna.telefon 
					FROM pengguna 
					INNER JOIN agensi 
					ON pengguna.agensi_id = agensi.id
					WHERE pengguna.id='$userid'";
if($isCalHek){
	$sqlPengguna	= "SELECT pengguna.nama, agensi.nama AS agensi, pengguna.telefon 
							FROM pengguna 
							INNER JOIN agensi 
							ON pengguna.agensi_id = agensi.id
							WHERE pengguna.nama='$pegawaiNama'";
	$sqlPgwTugas	= "SELECT nama FROM pengguna 
						WHERE roles LIKE'%6%' 
						ORDER BY nama";
	$rsPgwTugas		= mysql_query($sqlPgwTugas) or die("LapEdit.php : ".mysql_error());
}
$rsPengguna		= mysql_query($sqlPengguna) or die("LapEdit.php : ".mysql_error());
$pengguna		= mysql_fetch_array($rsPengguna);


if(empty($pegawaiNama))
	$pegawaiNama	= ($row['PgwNama'])? $row['PgwNama']:$pengguna['nama'];

$pegawaiBhg		= ($row['PgwBhg'])? $row['PgwBhg']:$pengguna['agensi'];
$pegawaiTlfn	= ($row['PgwTelefon'])? $row['PgwTelefon']:$pengguna['telefon'];


?>
<script language="javascript">
	function findHari(tarikh,day){
		var hari = ["Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu"];
		var dat = explode(tarikh.value,"/",true);
		var tkh = new Date(dat[2],dat[1]-1,dat[0]);
		day.value = hari[tkh.getDay()];
	}
	function showMe (it, box) {
	  var vis = (box.checked) ? "" : "none";
	  document.all[it].style.display = vis;
	}
	function hideMe (it, box) {
	  var vis = !(box.checked) ? "" : "none";
	  document.all[it].style.display = vis;
	}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>

<form id="frm_laporanDewan" name="frm_laporanDewan" method="post" onSubmit="return validateForm(this)">
<div class="tajuk">&nbsp;</div>
<fieldset><legend>Butir-butir Persidangan</legend>
<br>
<table border=0 width="100%">
    <tr>
		<td width="252">Sesi Dewan </td><td width="10"><strong>:</strong></td>
		<td width="674"><select name="sesiDewan"><?php echo getSesiDewan($sesiDewan) ?></select></td>
	</tr>
    <tr>
		<td>Tarikh Persidangan <span class="style1">*</span></td>
		<td><strong>:</strong></td>
		<td><input name="tarikhSidang" class="txt" value="<?php echo $tarikhSidang ?>" size="15" onBlur="findHari(this, document.frm_laporanDewan.hari)"/>&nbsp;
		<a href='' onClick='popUpCalendar(this, frm_laporanDewan.tarikhSidang, "dd/mm/yyyy");return false'>
		<img name="tarikhSidangCal" src="../images/calendar.gif" border="0" alt="" align="absmiddle"></a></td>
	</tr>
    <tr>
		<td>Hari</td>
		<td><strong>:</strong></td>
		<td><input class="txt" name="hari" value="<?php echo $hari ?>" style="background:transparent;border-width:0"/></td>
    </tr>
    <tr>
		<td>Sesi</td><td><strong>:</strong></td>
		<td>
		  <select name="sesi">
		    <option value="Pagi" <?php $chk=($sesi=="Pagi")? " selected":""; echo $chk; ?>>Pagi</option>
			<option value="Petang" <?php $chk=($sesi=="Petang")? " selected":""; echo $chk; ?>>Petang</option>
		  </select>
		</td>
   	</tr>
    <tr>
	<td>Masa Penangguhan (hh:mm) <span class="style1">*</span></td>
		<td><strong>:</strong></td>
	  <td><input class="txt" name="masaTangguh" size=15 value="<?php echo $masaTangguh ?>"/> 
		(hh:mm) </td>
	</tr>
    <tr>
		<td>Pegawai Bertugas</td>
		<td><strong>:</strong></td>
		<td><?php if($isCalHek){?>
		<select name="pegawaiNama" onChange="submit()">
			<option value=""></option>
			<?php
			while($rowPgwTugas=mysql_fetch_array($rsPgwTugas)){?>
				<option value="<?php echo $rowPgwTugas['nama']?>" <?php echo ($pegawaiNama==$rowPgwTugas['nama'])? " selected":""?>><?php echo $rowPgwTugas['nama'] ?></option>
			<?php }?>
	    </select>
		<?php }
		else{?>
			<input class="txt" name="pegawaiNama" size=50 value="<?php echo $pegawaiNama ?>" onFocus="blur()" style="background:transparent;border-width:0"/>
		<?php } ?>
	  	</td>
    </tr>
    <tr>
		<td>Bahagian </td>
		<td><strong>:</strong></td>
		<td><input class="txt" name="pegawaiBhg" size=60 value="<?php echo $pegawaiBhg ?>" onFocus="blur()" style="background:transparent;border-width:0"/></td>
    </tr>
    <tr>
		<td>Tel/Sambungan</td>
		<td><strong>:</strong></td><td><input class="txt" name="pegawaiTlfn" size=20 value="<?php echo $pegawaiTlfn ?>" onFocus="blur()" style="background:transparent;border-width:0"/></td>
    </tr>
    <tr>
		<td>Tarikh Laporan <span class="style1">*</span></td>
		<td><strong>:</strong></td>
		<td><input name="tarikhLaporan" class="txt" value="<?php echo $tarikhLaporan ?>" size="15" onBlur="findHari(document.entry_form)"/>&nbsp;
		<a href='' onClick='popUpCalendar(this, frm_laporanDewan.tarikhLaporan, "dd/mm/yyyy");return false'>
		<img src="../images/calendar.gif" name="tarikhLaporanCal" border="0" align="absmiddle"></a></td>
    </tr>
    <tr>
		<td>Tarikh Persidangan Seterusnya <span class="style1">*</span></td><td><strong>:</strong></td>
		<td><input name="tarikhSidang2" class="txt" value="<?php echo $tarikhSidang2;?>" size="15"/> &nbsp;<a href='' onClick='popUpCalendar(this, frm_laporanDewan.tarikhSidang2, "dd/mm/yyyy");return false'><img src="../images/calendar.gif" name="tarikhSidang2Cal" border="0" alt="" align="absmiddle"></a></td>
    </tr>
    <tr>
		<td>Masa Persidangan Seterusnya (hh:mm) <span class="style1">*</span></td>
		<td><strong>:</strong></td>
	  <td><input class="txt" name="masaSidang2" size=15 value="<?php echo $masaSidang2; ?>"/>	   
	     (hh:mm)</td>
    </tr>
    <tr>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
    </tr>	
</table>
</fieldset>

<table border=0 width="100%" style="margin-left:10;">
    <?php if($_GET['action']=='newdocLap'){?>
	<tr>
		<td width="220"><input type="submit" value="SETERUSNYA" name="simpanLap" class="button"/></td>
		<td width="10">&nbsp;</td>
		<td width="639">&nbsp;</td>
	</tr>
	<?php }?>
	<tr><td colspan="3">&nbsp;</td></tr>
</table>

<?php if($_GET['action']!='newdocLap'){?>
<fieldset><legend>Sesi Jawapan Mulut</legend>
<br>
<table border=0 width="100%">
	<tr>
		<td width="201">Jumlah Soalan Dibentangkan</td>
		<td width="5"><strong>:</strong></td>
		<td width="663" colspan="4"><input class="txt" name="jumSoalan" size=20 value="<?php echo $jumSoalan ?>"/></td>
	</tr>
	<tr>
		<td width="201">Jumlah Soalan Dijawab</td>
		<td><strong>:</strong></td>
		<td colspan="4"><input class="txt" name="jumJawab" size=20 value="<?php echo $jumJawab ?>"/></td>
	</tr>
    <tr>
		<td width="201">Soalan Kepada Menteri WP</td><td><strong>:</strong></td>
		<td colspan="4">
			<input type="radio" name="sahSoalanMent" value="1" <?php if($sahSoalanMent == 1) print "checked"; ?> onClick="showMe('div1', this)">Ada
			<input type="radio" name="sahSoalanMent" value="0" <?php if($sahSoalanMent == 0) print "checked"; ?> onClick="hideMe('div1', this)">Tiada
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<div id="div1" style="display:<?php echo $isVisibleSM;?>">
			<table>
			<tr>
				<td width="197">No Bilangan Soalan</td>
				<td width="10"><strong>:</strong></td>
				<td width="192">&nbsp;<input class="txt" name="bilSoalan" size=20 value="<?php echo $bilSoalan ?>"/></td>
			</tr>
			</table>
			</div>
	  	</td>
	</tr>
	<tr>
		<td width="201">Soalan Tambahan</td>
		<td><strong>:</strong></td>
		<td>
		  <input type="radio" name="sahSoalanTamb" value="1" <?php if($sahSoalanTamb == 1) print "checked"; ?> onClick="showMe('div2', this)">Ada
		  <input type="radio" name="sahSoalanTamb" value="0" <?php if($sahSoalanTamb == 0) print "checked"; ?> onClick="hideMe('div2', this)">Tiada
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<div id="div2" style="display:<?php echo $isVisibleST;?>">
			<table width="95%">
				<tr>
					<td align="right"><input type="button" value="Tambah Soalan Tambahan" name="SoalanTambahan" style="width:180px" class="button" onClick="NewWindow('LapSub_st.php?pid=<?php echo $id; ?>&dewan=<?php echo $sesiDewan; ?>','st',900,450,true)"></td>
				</tr>
				<tr>
					<td>
					<!--Table soalan tambahan -->
					<table border="1" width="100%">
						<tr>
							<td width="673" class="kalendar">Ahli Yang Berhormat</td>
							<td width="61" class="kalendar">Kawasan</td>
							<td width="70" class="kalendar">Terperinci?</td>
							<?php echo ($sys_acl==1)?"<td class=\"kalendar\">Hapus ?</td>":""?>
						</tr>
						<?php
						$sql	= "SELECT *
									FROM kal_lapdwn_st AS st
									WHERE st.Kal_lapdwn_id = '$id'
									ORDER BY Kal_lapdwn_st_id";
						$rs		= mysql_query($sql) or die(mysql_error()); 
						$count	= mysql_num_rows($rs);
						if($count=0){
						?>
							<tr>
							  <td colspan="3">Tiada Rekod </td>
							</tr>
						<?php
						}
						while($row = mysql_fetch_array($rs)){
							$recId	= $row['Kal_lapdwn_st_id'];
							$del = ($sys_acl==1)? "<td align=\"center\"><a href='' onClick=\"return delDoc('kalLapDewan_st','".$row['Kal_lapdwn_st_id']."','".$id."')\"><img src=\"../images/del.gif\" border=0></a></td>":"";	
						?>
							<tr>
								<td><?php echo $row['NamaYB']?></td>
								<td><?php echo $row['Kawasan']?></td>
								<td align="center"><a href="javascript: NewWindow('LapSub_st.php?id=<?php echo $recId;?>&pid=<?php echo $id; ?>','st',900,450,true)"><img src="images/bt_edit.png" width="14" height="14" border="0"></a></td>
								<?php echo $del ?>
							</tr>
						<?php } ?>
					</table>
					</td>
				</tr>  
			</table>
			<br>
			</div>
		</td>
	</tr>
	<tr>
		<td width="201">Soalan Ditujukan Kepada PM/Menteri Lain Yang Berkaitan Dengan Hal Ehwal KKM</td><td><strong>:</strong></td>
		<td>
			<input type="radio" name="sahSoalanBerkaitan" value="1" <?php if($sahSoalanBerkaitan == 1) print "checked"; ?> onClick="showMe('div3', this)">Ada
			<input type="radio" name="sahSoalanBerkaitan" value="0" <?php if($sahSoalanBerkaitan == 0) print "checked"; ?> onClick="hideMe('div3', this)">Tiada
		</td>
	</tr>	
</table>
			<div id="div3" style="display:<?php echo $isVisibleSB;?>">
			<table width="95%">
				<tr>
					<td align="right"><input type="button" value="Tambah Soalan Berkaitan" name="SoalanBerkaitan" style="width:180px" class="button" onClick="NewWindow('LapSub_sb.php?pid=<?php echo $id; ?>','sb',900,450,true)"></td>
				</tr>			
				<tr>
					<td colspan="2">
					<!--Table soalan berkaitan -->
					<table border="1" width="100%">
						<tr>
							<td width="678" class="kalendar">Ahli Yang Berhormat</td>
							<td width="61" class="kalendar">Kawasan</td>
							<td width="70" class="kalendar">Terperinci?</td>
							<?php echo ($sys_acl==1)?"<td class=\"kalendar\">Hapus ?</td>":""?>
						</tr>
						<?php
						$sql	= "SELECT *
									FROM kal_lapdwn_sb AS sb
									WHERE sb.Kal_lapdwn_id = '$id'
									ORDER BY Kal_lapdwn_sb_id";
						$rs		= mysql_query($sql) or die(mysql_error()); 
						while($row = mysql_fetch_array($rs)){
						$recId	= $row['Kal_lapdwn_sb_id'];
						$del = ($sys_acl==1)? "<td align=\"center\"><a href='' onClick=\"return delDoc('kalLapDewan_sb','".$row['Kal_lapdwn_sb_id']."','".$id."')\"><img src=\"../images/del.gif\" border=0></a></td>":"";	
						?>
						<tr valign="top">
							<td><?php echo $row['NamaYB']?></td>
							<td>&nbsp;<?php echo $row['Kawasan']?></td>
							<td align="center"><a href="javascript: NewWindow('LapSub_sb.php?id=<?php echo $recId;?>&pid=<?php echo $id; ?>','sb',900,450,true)"><img src="images/bt_edit.png" width="14" height="14" border="0"></a></td>
							<?php echo $del ?>
						</tr>
						<?php  } ?>
					</table>
					</td>
				</tr>  
			</table>
			<br>
			</div>
</fieldset>

<table><tr><td>&nbsp;</td></tr></table>

<fieldset><legend>Perbahasan Titah Ucapan/Rang Undang-undang</legend>
<br>
<table border="1" width="95%">
	<tr>
		<td width="100%" class="kalendar">Rang Undang-Undang Yang Dibahaskan</td>
		<td width="42" class="kalendar">Status</td>
	<tr align="left">
		<td><input class="txt" name="rang1" size="95" value="<?php echo $rang1 ?>"/></td>
		<td><select name="statusRang1">
			<option value=""></option>
			<?php getKeyword("Status Laporan",$status1,$conn) ?></select></td>
	</tr>
	<tr align="left">
		<td><input class="txt" name="rang2" size=95 value="<?php echo $rang2 ?>"/></td>
		<td><select name="statusRang2">
			<option value=""></option>
			<?php getKeyword("Status Laporan",$status2,$conn) ?></select></td>
	</tr>  
	<tr align="left">
		<td><input class="txt" name="rang3" size=95 value="<?php echo $rang3 ?>"/></td>
		<td><select name="statusRang3">
			<option value=""></option>
			<?php getKeyword("Status Laporan",$status3,$conn) ?></select></td>
	</tr>  
	<tr align="left">
		<td><input class="txt" name="rang4" size=95 value="<?php echo $rang4 ?>"/></td>
		<td><select name="statusRang4">
			<option value=""></option>
			<?php getKeyword("Status Laporan",$status4,$conn) ?></select></td>
	</tr>  
</table>
<table border=0 width="100%">
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td colspan="3">&nbsp;</td>
    </tr>
	<tr>
      <td width="203">Isu Berkaitan Dengan KKM</td>
	  <td width="5"><strong>:</strong></td>
	  <td width="661" colspan="3">
		<input type="radio" name="sahIsuBerkaitan" value="1" <?php if($sahIsuBerkaitan > 0) print "checked"; ?> onClick="showMe('div4', this)">Ada
		<input type="radio" name="sahIsuBerkaitan" value="0" <?php if($sahIsuBerkaitan < 1) print "checked"; ?> onClick="hideMe('div4', this)">Tiada
	  </td>
    </tr>
	<tr>
		<td colspan="3">
			<div id="div4" style="display:<?php echo $isVisibleIB?>">
				<table width="100%">
				<tr>
					<td width="34%"><input type="button" value="Isu Berbangkit" name="isuBerbangkit" class="button" onClick="NewWindow('LapSub_ib.php?pid=<?php echo $id; ?>','ib',900,450,true)"></td>
					<td width="57%">&nbsp;</td>
					<td width="9%">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3">
					<!--Table isu berkaitan -->
					<table border="1" width="95%">
					<tr>
						<td width="665" class="kalendar">Ahli Yang Berhormat </td>
						<td width="61" class="kalendar">Kawasan</td>
						<td width="78" class="kalendar">Terperinci?</td>
						<?php echo ($sys_acl==1)?"<td class=\"kalendar\">Hapus ?</td>":""?>
					</tr>
						<?php
						$sql	= "SELECT *
									FROM kal_lapdwn_ib AS ib
									WHERE ib.Kal_lapdwn_id = '$id'
									ORDER BY Kal_lapdwn_ib_id";
						$rs		= mysql_query($sql) or die(mysql_error()); 
						while($row = mysql_fetch_array($rs)){
						$recId	= $row['Kal_lapdwn_ib_id'];
						$del = ($sys_acl==1)? "<td align=\"center\"><a href='' onClick=\"return delDoc('kalLapDewan_ib','".$row['Kal_lapdwn_ib_id']."','".$id."')\"><img src=\"../images/del.gif\" border=0></a></td>":"";	
						?>
					<tr>
					  <td><?php echo $row['NamaYB']?></td>
					  <td><?php echo $row['Kawasan']?></td>
					  <td align="center"><a href="javascript: NewWindow('LapSub_ib.php?id=<?php echo $recId;?>&pid=<?php echo $id; ?>','ib',900,450,true)"><img src="images/bt_edit.png" width="14" height="14" border="0"></a></td>
					  <?php echo $del ?> </tr>
					<?php  } ?>
					</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>				
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td>Rang Undang-undang Berkaitan Dengan KKM</td>
		<td><strong>:</strong></td>
		<td>
			<input type="radio" name="sahRangUndang" value="1" <?php if($sahRangUndang > 0) print "checked"; ?> onClick="showMe('div5', this)">Ada
			<input type="radio" name="sahRangUndang" value="0" <?php if($sahRangUndang < 1) print "checked"; ?> onClick="hideMe('div5', this)">Tiada
		</td>
	</tr>
 	<tr>
		<td colspan="3">
		<div id="div5" style="display:<?php echo $isVisibleRU?> ">
		<table width="100%">
		<tr>
			<td><input type="button" value="Maklumat Rang Undang-Undang" name="rangUndang" class="button" onClick="NewWindow('LapSub_ru.php?pid=<?php echo $id; ?>','ru',900,450,true)"></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">
				<!--Table maklumat rang undang-undang -->
				<table border="1" width="95%">
				<tr>
					<td width="665" class="kalendar">Ahli Yang Berhormat </td>
					<td width="61" class="kalendar">Kawasan</td>
					<td width="78" class="kalendar">Terperinci?</td>
					<?php echo ($sys_acl==1)?"<td class=\"kalendar\">Hapus ?</td>":""?>
				</tr>
					<?php
					$sql	= "SELECT *
								FROM kal_lapdwn_ru AS ru
								WHERE ru.Kal_lapdwn_id = '$id'
								ORDER BY Kal_lapdwn_ru_id";
					$rs		= mysql_query($sql) or die(mysql_error()); 
					while($row = mysql_fetch_array($rs)){
					$recId	= $row['Kal_lapdwn_ru_id'];
					$del = ($sys_acl==1)? "<td align=\"center\"><a href='' onClick=\"return delDoc('kalLapDewan_ru','".$row['Kal_lapdwn_ru_id']."','".$id."')\"><img src=\"../images/del.gif\" border=0></a></td>":"";	
					?>
				<tr>
					<td><?php echo $row['NamaYB']?></td>
					<td><?php echo $row['Kawasan']?></td>
					<td align="center"><a href="javascript: NewWindow('LapSub_ru.php?id=<?php echo $recId;?>&pid=<?php echo $id; ?>','ru',900,450,true)"><img src="images/bt_edit.png" width="14" height="14" border="0"></a></td>
					<?php echo $del ?> 
				</tr>
				<?php 
				 } 
				?>
				</table>
			</td>
		</tr>
		</table>
		</div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>	
</table>
</fieldset>
<br>
<table border=0 width="100%" style="margin-left:10;">
    <tr>
	  <td>
		<input type="submit" value="SIMPAN" name="simpanLap" class="button" <?php if(!$isCalUser) echo 'disabled' ?>/> 
		<input type="button" value="CETAK LAPORAN PEGAWAI (PDF)" name="cetakRingkasan" class="button" onClick="NewWindow('pdf_pegawai.php?mesyuarat_id=<?php echo $id; ?>&sesi=<?php echo $sesi; ?>','pdf_pegawai',800,600,true)" <?php if(!$isCalUser) echo 'disabled'; ?>>
		<input type="button" name="delete" value="HAPUS LAPORAN DEWAN" onClick="delDoc('kalLapDewan','<?php echo $id;?>')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/>
	  </td>
		<td width="10">&nbsp;</td>
	</tr>
</table>
<?php }
}?>
</form>
