<?php

//Hanya HEK sahaja yang boleh masukkan data
if($sys_acl==4 || !($isCalHek)){
//if($sys_acl==4 || !($isCalUser)){
	echo $acl_denied;
}else{ 
	//Start content
	if($_GET['action']!='newdocKal'){
		$id = $_GET['id'];	
		
		$qry = "SELECT m.Kal_mesyuarat_id,m.Parlimen,m.Penggal,m.Sesi,m.Mesyuarat,TarikhMula,TarikhAkhir,
				DATE_FORMAT(m.TarikhMula,'%d/%m/%Y') AS TkhMulaStd, 
				DATE_FORMAT(m.TarikhAkhir,'%d/%m/%Y') AS TkhAkhirStd
				FROM kal_mesyuarat AS m WHERE m.Kal_mesyuarat_id ='$id'";
		
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);					
	}

	$sesi 		= ($_POST['sesi'])?$_POST['sesi']:$row['Sesi'];
	$mesyuarat 	= ($_POST['mesyuarat'])?$_POST['mesyuarat']:$row['Mesyuarat'];
	$penggal 	= ($_POST['penggal'])?$_POST['penggal']:$row['Penggal'];
	$parlimen 	= ($_POST['parlimen'])?$_POST['parlimen']:$row['Parlimen'];
	$tkhMulaStd = ($_POST['tarikhMula'])?$_POST['tarikhMula']:$row['TkhMulaStd'];
	$tkhAkhirStd= ($_POST['tarikhAkhir'])?$_POST['tarikhAkhir']:$row['TkhAkhirStd'];
	
	$tarikhMula = $row['TarikhMula'];
	$tarikhAkhir= $row['TarikhAkhir'];
	
	?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

	<form id="frm_kal" name="frm_kal" method="post" onSubmit="return validateForm(this)">
	<div class="tajuk">&nbsp;</div>	
	<fieldset>
	<legend>Maklumat Persidangan </legend>
	<table width=100%>
	  <tr><td>Mesyuarat</td><td>:</td><td><select name="mesyuarat"><?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?></select></td></tr>
	  <tr><td width="167">Penggal</td><td width="3">:</td><td width="1044"><select name="penggal"><?php getKeyword("Penggal Parlimen",$penggal,$conn) ?></select></td></tr>
	  <tr><td>Parlimen</td><td>:</td><td><p><select name="parlimen"><?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?></select></p></tr>	  
	  <tr><td>Sesi</td><td>:</td><td><p><select name="sesi"><?php echo getSesiDewan($sesi) ?></select></p></td></tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td colspan="3" style="padding-left:0"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="3">DEWAN RAKYAT </td>
            <td colspan="3">DEWAN NEGARA </td>
          </tr>
          <tr>
            <td width="17%">Tarikh Mula <span class="style1">*</span> </td>
            <td width="1%">:</td>
            <td width="30%"><input name="tarikhMula" class="txt" value="<?php echo $tkhMulaStd ?>" size="15" />
            <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar1" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhMula, "dd/mm/yyyy");return false' style="cursor:pointer "></td>
            <td width="13%">Tarikh Mula </td>
            <td width="1%">:</td>
            <td width="38%"><input name="tarikhMulaDN" class="txt" value="<?php echo $tarikhAkhirDR ?>" size="15"/></td>
          </tr>
          <tr>
            <td>Tarikh Akhir <span class="style1">*</span> </td>
            <td>:</td>
            <td><input name="tarikhAkhir" class="txt" value="<?php echo $tkhAkhirStd ?>" size="15" onBlur="tarikhMulaDN.value=this.value;"/>
                <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar2" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhAkhir, "dd/mm/yyyy"); return false' style="cursor:pointer "></td>
            <td>Tarikh Akhir <span class="style1">*</span> </td>
            <td>:</td>
            <td><input name="tarikhAkhirDN" class="txt" value="<?php echo $tarikhAkhirDN ?>" size="15"/>
                <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar2" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhAkhirDN, "dd/mm/yyyy");return false' style="cursor:pointer "></td>
          </tr>
        </table></td>
      </tr>
	  <tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td></tr><br>
	</table>
	</fieldset>
<br>
	<?php include("inc_kalPegawaiBtugas.php"); ?>
	<table border=0 width="100%" style="margin-left:10;">
		<tr>
			<td>
			<input type="submit" value="SIMPAN" name="KalSimpan" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
			<?php if($_GET['action']!='newdocKal'){?>
				<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onclick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>&sesi=<?php echo $sesi; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>&sesi=<?php echo $sesi; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input name="deleteDoc" type="button" onClick="deleteDoc('kalMesyuarat','<?php echo $id ?>')" value="HAPUS" class="button_del"/>
			<?php }?>		
			</td>
		</tr>
	</table>
	</form>
<?php 
}?>