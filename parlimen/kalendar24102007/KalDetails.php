<?php
$id 	= $_GET['id'];
		
$qry 	= "SELECT m.Kal_mesyuarat_id,m.Parlimen,m.Penggal,m.Sesi,m.Mesyuarat,m.TarikhMula, m.TarikhAkhir,
			DATE_FORMAT(m.TarikhMula,'%d/%m/%Y') AS TMula, 
			DATE_FORMAT(m.TarikhAkhir,'%d/%m/%Y') AS TAkhir,
			DATEDIFF(m.TarikhAkhir,m.TarikhMula) AS beza
			FROM kal_mesyuarat AS m WHERE m.Kal_mesyuarat_id ='$id'";

$result = mysql_query($qry,$conn) or die(mysql_error());
$row 	= mysql_fetch_array($result);

$sesi = $row['Sesi'];
$sesi_dewan = ($sesi == '1')? "Dewan Rakyat":"Dewan Negara";
$mesyuarat = $row['Mesyuarat'];
$penggal = $row['Penggal'];
$parlimen = $row['Parlimen'];

//$sesi	= ($row['Sesi']=='1')? "Dewan Rakyat":"Dewan Negara";

?>
<form id="entry_form" name="entry_form" method="post">
<div class="tajuk">&nbsp;</div>
<fieldset>
<legend>Maklumat Persidangan</legend>
	<br>
	<table width=100%>
		<tr>
		  <td>Mesyuarat</td>
		  <td>:</td>
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
		  <td width=165>Sesi</td>
		  <td width=3>:</td>
		  <td><?php echo $sesi_dewan?></td>
		</tr>
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
            <td width="17%">Tarikh Mula</td>
            <td width="1%">:</td>
            <td width="29%"><?php echo $row['TMula'] ?></td>
            <td width="15%">Tarikh Mula </td>
            <td width="0%">:</td>
            <td width="38%">&nbsp;</td>
          </tr>
          <tr>
            <td>Tarikh Akhir</td>
            <td>:</td>
            <td><?php echo $row['TAkhir'] ?></td>
            <td>Tarikh Akhir </td>
            <td>:</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
    </tr>
  </table>
</fieldset>

<?php include("inc_kalPegawaiBtugas.php"); ?>
<br>
	<table border=0 width="100%" style="margin-left:10;">
		<tr>
			<td>
				<input type="submit" value="KEMASKINI" name="KalEdit" class="button" style="width:80" <?php if(($sys_acl==3) || ($sys_acl==4)){ echo 'disabled'; }?>/>
				<input type="button" value="JADUAL TUGAS" name="cetakJadual" class="button" style="width:100px" onclick="NewWindow('pdf_jadual.php?mesyuarat=<?php echo $mesyuarat; ?>&penggal=<?php echo $penggal; ?>&parlimen=<?php echo $parlimen; ?>&mesyuarat_id=<?php echo $id; ?>&sesi=<?php echo $sesi; ?>','pdf_tugas',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" value="RINGKASAN LAPORAN PEGAWAI" name="cetakRingkasan" class="button" style="width:210px" onClick="NewWindow('pdf_takwim.php?mesyuarat_id=<?php echo $id; ?>&sesi=<?php echo $sesi; ?>','pdf_ringkasan',800,600,true)" <?php if(!$isCalUser) echo 'disabled' ?>>
				<input type="button" name="delete" value="HAPUS" title="Hapus Kalendar Pegawai Bertugas" onClick="delDoc('kalMesyuarat','<?php echo $id;?>','')" class="button_del" <?php if($sys_acl!=1) echo 'disabled' ?>/>
			</td>
		</tr>
	</table>
</form>
