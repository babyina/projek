<?php
//ACCESS DENIED kepada capaian tahap 5 dan bukan pengguna kalendar
if($sys_acl==5 || !($isCalUser)){
	echo $acl_denied;
}

$id 	= $_GET['id'];
		
$qry 	= "SELECT 
				m.Kal_mesyuarat_id,
				m.Parlimen,
				m.Penggal,
				m.Mesyuarat,
				m.TarikhMulaDR, 
				m.TarikhAkhirDR,
				m.TarikhMulaDN, 
				m.TarikhAkhirDN,
				DATEDIFF(m.TarikhAkhirDR,m.TarikhMulaDR) AS beza
			FROM kal_mesyuarat AS m WHERE m.Kal_mesyuarat_id ='$id'";

$result = mysql_query($qry,$conn) or die(mysql_error());
$row 	= mysql_fetch_array($result);

$mesyuarat 	= $row['Mesyuarat'];
$penggal 	= $row['Penggal'];
$parlimen 	= $row['Parlimen'];
$tarikhMulaDR = $row['TarikhMulaDR'];
$tarikhAkhirDR= $row['TarikhAkhirDR'];
$tarikhMulaDN = $row['TarikhMulaDN'];
$tarikhAkhirDN= $row['TarikhAkhirDN'];

?>

<form id="entry_form" name="entry_form" method="post">
<br>
<table border=0 width="100%">
	<tr align="right">
		<td>
			<input type="submit" value="KEMASKINI" name="KalEdit" class="button" style="width:80" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
			<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onclick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
		<?php /* <input type="button" value="JADUAL HTML" name="cetakJadual2" class="button" style="width:100px" onclick="NewWindow('prt_kalendar.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',1070,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>> */ ?>
			<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
			<input type="button" value="HAPUS" name="delete" class="button" title="Hapus Kalendar Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" <?php if($sys_acl!=1) echo 'disabled' ?>/>
		</td>
	</tr>
</table>
<fieldset>
<legend>Takwim Pegawai Bertugas</legend>
	<br>
	<table width=100%>
		<tr>
		  <td width="165">Mesyuarat</td>
		  <td width="3">:</td>
		  <td width="1046"><?php echo $mesyuarat ?></td>
	</tr>
		<tr>
          <? //php echo $_GET['id'] ?>
          <td>Penggal</td>
          <td>:</td>
          <td> <?php echo $row['Penggal'] ?></td>
    </tr>
		<tr>
          <td>Parlimen</td>
          <td>:</td>
          <td><?php echo $row['Parlimen'] ?></td>
    </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
	    <td colspan="3" style="padding-left:0">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="3"><strong>DEWAN RAKYAT </strong></td>
            <td colspan="3"><strong>DEWAN NEGARA </strong></td>
          </tr>
          <tr>
            <td width="146">Tarikh Mula</td>
            <td width="4">:</td>
            <td width="300"><?php echo DisplayDate($tarikhMulaDR) ?></td>
            <td width="133">Tarikh Mula </td>
            <td width="4">:</td>
            <td width="391"><?php echo DisplayDate($tarikhMulaDN) ?></td>
          </tr>
          <tr>
            <td>Tarikh Akhir</td>
            <td>:</td>
            <td><?php echo DisplayDate($tarikhAkhirDR) ?></td>
            <td>Tarikh Akhir </td>
            <td>:</td>
            <td><?php echo DisplayDate($tarikhAkhirDN) ?></td>
          </tr>
        </table></td>
      </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
    </tr>
 	</table>
  <?php include("inc_kalPegawaiBtugas.php"); ?>
</fieldset>

<table border=0 width="100%">
	<tr align="right">
		<td>
			<input type="submit" value="KEMASKINI" name="KalEdit" class="button" style="width:80" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
			<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onclick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
		<?php /*	<input type="button" value="JADUAL HTML" name="cetakJadual2" class="button" style="width:100px" onclick="NewWindow('prt_kalendar.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>','pdf_tugas',1070,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>> */ ?>
			<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
			<input type="button" name="delete" value="HAPUS" title="Hapus Kalendar Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/>
		</td>
	</tr>
</table>
</form>
