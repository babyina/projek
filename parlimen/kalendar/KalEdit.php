<?php
//Hanya HEK sahaja yang boleh masukkan data
if($sys_acl==4 || !($isCalHek)){
//if($sys_acl==4 || !($isCalUser)){
	echo $acl_denied;
}else{ 
	//Start content
	if($_GET['action']!='newdocKal'){
		$id = $_GET['id'];	
		
		$qry = "SELECT 
					m.Kal_mesyuarat_id,
					m.Parlimen,
					m.Penggal,
					m.Mesyuarat,
					TarikhMulaDR,
					TarikhAkhirDR,
					TarikhMulaDN,
					TarikhAkhirDN
				FROM kal_mesyuarat AS m WHERE m.Kal_mesyuarat_id ='$id'";
		
		$result = mysql_query($qry,$conn) or die(mysql_error());
		$row = mysql_fetch_array($result);					
	}

	$mesyuarat 	= ($_POST['mesyuarat'])?$_POST['mesyuarat']:$row['Mesyuarat'];
	$penggal 	= ($_POST['penggal'])?$_POST['penggal']:$row['Penggal'];
	$parlimen 	= ($_POST['parlimen'])?$_POST['parlimen']:$row['Parlimen'];	
	$tarikhMulaDR = $row['TarikhMulaDR'];
	$tarikhAkhirDR= $row['TarikhAkhirDR'];
	$tarikhMulaDN = $row['TarikhMulaDN'];
	$tarikhAkhirDN = $row['TarikhAkhirDN'];
	
	?>
	<style type="text/css">
		.style1 {color: #FF0000}
	</style>
	
	<script language="JavaScript"><!--
		function y2k(number) { return (number < 1000) ? number + 1900 : number; }
		
		function add_days(adate,days) {
			return new Date(adate.getTime() + (days * 86400000));
		}
	
		function format_date(adate) {
			return adate.getDate() + '/' + (adate.getMonth()+1) + '/' + y2k(adate.getYear());
		}
	
		function show_dates(str,addDay) {
			var bdate	= str2date(str);
			var then = add_days(bdate,addDay);    	// move date forward 
			var nDate   = format_date(then); 			// format date
			return nDate;
		}
		
		function str2date(str){
			ddate = str.split("/");
			adate = new Date(ddate[2],ddate[1]-1,ddate[0]);
			return adate;
		}
		
		
	//--></script>
	<form id="frm_kal" name="frm_kal" method="post" onSubmit="return validateForm(this)">
	<br>
	<table border=0 width="100%">
		<tr align="right">
			<td>
			<input type="submit" value="SIMPAN" name="KalSimpan" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
			<?php if($_GET['action']!='newdocKal'){?>
				<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onclick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="HAPUS" name="delete" class="button" title="Hapus Takwim Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" <?php if($sys_acl!=1) echo 'disabled' ?>/>
			<?php } ?>		
			</td>
		</tr>
	</table>
	<fieldset>
	<legend>Takwim Pegawai Bertugas</legend>
	<table width=100%>
	  <tr><td>Mesyuarat</td><td>:</td><td><select name="mesyuarat"><?php getKeyword("Mesyuarat Parlimen",$mesyuarat,$conn) ?></select></td></tr>
	  <tr><td width="167">Penggal</td><td width="3">:</td><td width="1044"><select name="penggal"><?php getKeyword("Penggal Parlimen",$penggal,$conn) ?></select></td></tr>
	  <tr><td>Parlimen</td><td>:</td><td><p><select name="parlimen"><?php getKeyword("Sesi Parlimen",$parlimen,$conn) ?></select></p></tr>	  
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
	  <tr>
	    <td colspan="3" style="padding-left:0"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="3"><strong>DEWAN RAKYAT </strong></td>
            <td colspan="3"><strong>DEWAN NEGARA </strong></td>
          </tr>
          <tr>
            <td width="15%">Tarikh Mula <span class="style1">*</span> </td>
            <td width="1%">:</td>
            <td width="37%"><input name="tarikhMulaDR" class="txt" value="<?php echo DisplayDate($tarikhMulaDR) ?>" size="15" />
            <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar1" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhMulaDR, "dd/mm/yyyy");return false' style="cursor:pointer "></td>
            <td width="10%">Tarikh Mula <span class="style1">*</span></td>
            <td width="1%">:</td>
            <td width="36%"><input name="tarikhMulaDN" class="txt" value="<?php echo DisplayDate($tarikhMulaDN) ?>" size="15"/>
            <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar3" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhMulaDN, "dd/mm/yyyy");return false' style="cursor:pointer "></td>
          </tr>
          <tr>
            <td>Tarikh Akhir <span class="style1">*</span> </td>
            <td>:</td>
            <td><input name="tarikhAkhirDR" class="txt" value="<?php echo DisplayDate($tarikhAkhirDR) ?>" size="15" onFocus="tarikhMulaDN.value=show_dates(this.value,4)"/>
                <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar2" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhAkhirDR, "dd/mm/yyyy"); return false' style="cursor:pointer "></td>
            <td>Tarikh Akhir <span class="style1">*</span> </td>
            <td>:</td>
            <td><input name="tarikhAkhirDN" class="txt" value="<?php echo DisplayDate($tarikhAkhirDN) ?>" size="15"/>
                <img src="../images/calendar.gif" align="absmiddle" name="imgCalendar4" border="0" alt="" onClick='popUpCalendar(this, frm_kal.tarikhAkhirDN, "dd/mm/yyyy");return false' style="cursor:pointer "></td>
          </tr>
        </table></td>
      </tr>
	  <tr><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td></tr><br>
	</table>
	<br>
	<?php include("inc_kalPegawaiBtugas.php"); ?>
	</fieldset>
	<table border=0 width="100%">
		<tr align="right">
			<td>
			<input type="submit" value="SIMPAN" name="KalSimpan" class="button" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; } ?> />
			<?php if($_GET['action']!='newdocKal'){?>
				<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onclick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" name="delete" value="HAPUS" title="Hapus Takwim Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/>
			<?php }?>		
			</td>
		</tr>
	</table>
	</form>
<?php 
}?>