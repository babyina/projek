<?php
	//UNTUK BUTIR-BUTIR SOALAN 
	$id = $_GET['id'];
	$qry = "SELECT parlimen.status,parlimen.sesi_dewan,parlimen,penggal,mesyuarat,
			tkh_mula_bersidang,tkh_akhir_bersidang,ahli_parlimen.nama AS nama_yb,agensi,	
			kawasan.nama as kawasan,negeri.nama as negeri,bentuk_soalan,no_soalan,soalan, parti.nama_pendek as parti,parlimen.tkh_bentang_jawapan,
			parlimen.tkh_jawab, parlimen.perkara, penyemak, 
			pengurusan_nama, pengurusan_jawatan, pengurusan_tarikh,pengurusan_catatan, pengesahan_nama, pengesahan_jawatan,
			pengesahan_tarikh,pengesahan_catatan, korperat_nama,korperat_jawatan,
			korperat_tarikh,korperat_jawapan,korperat_tambahan,created_by,created_on,parlimen.salinan FROM parlimen
			LEFT JOIN negeri ON negeri.id = parlimen.negeri 
			LEFT JOIN kawasan ON kawasan.id = parlimen.kawasan_id
			LEFT JOIN ahli_parlimen ON parlimen.ahli_dewan_id = ahli_parlimen.id
			LEFT JOIN parti ON parti.id = parlimen.parti_id
			WHERE parlimen.id ='$id'" ;
			
	$result	= mysql_query($qry,$conn) or die(mysql_error());
	$row 	= mysql_fetch_array($result);
	$soalan	= stripslashes($row['soalan']);
	$wakil =empty($row['parti'])?"Tiada":$row['parti'];
	$sesi	= $row['sesi_dewan'];
		$_SESSION['no_soalan'] = $row['no_soalan'];
	$_SESSION['perkara'] = $row['perkara'];
	//echo "lalalmmm".$_SESSION['no_soalan'].$_SESSION['perkara'];
	
	//END BUTIR2 SOALAN
?>

<script language="javascript">
	var soalan = 1;
</script>

<fieldset><legend><b>Butir-butir Soalan</b></legend>
	<table border=0 width=100%>
		<tr><td width=204><br />Bentuk Soalan</td><td width=10><br />:</td>
		<td width=417><br />
		  <?php echo $row['bentuk_soalan']?></td>
		<td width=95>&nbsp;</td>
		<td width=18>&nbsp;</td>
		<td width=215>&nbsp;</td>
		</tr>
		<?php
		if($sesi=='1'){
		?>
		
	  <tr>
		  <td>No. Soalan</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['no_soalan']?></td>
	  </tr>
		<tr>
		  <td>Kawasan Parlimen</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['kawasan']; ?></td>
		</tr>
		<?php }?>
		<?php
		if($sesi=='2'){
		?>
		<tr>
		  <td>No. Soalan</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['no_soalan']?></td>
	  </tr>
		<tr>
		  <td>Negeri</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['negeri'] ?></td>
		</tr>
		<?php }?>
		<tr><td width=204>Nama Y.B</td><td width=10>:</td><td colspan=4><?php echo $row['nama_yb'] ?></td></tr>

		<tr><td width=204>Wakil</td><td width=10>:</td><td colspan=4><?php echo $wakil; ?></td></tr>
		
		<?php 
		if($isHEK)
		{ ?>
		<tr>
		  <td width=204>Tarikh Soalan</td><td width=10>:</td>
		<td colspan=4><?php echo Reverse($row['tkh_bentang_jawapan']) ?></td></tr>
			<?php } ?>
		<tr><td width=204><strong>Perkara</strong></td>
	    <td width=10>:</td><td colspan=4><?php echo $row['perkara']?></td></tr>
		<tr>
		  <td width=204 valign=top><strong>Soalan</strong></td>
		  <td valign="top" width=10>:</td>
		  <td colspan=4>
			<div class="scroll">
			<?php 
				echo stripslashes($row['soalan']);
			?>
			</div>
		  </td>
		</tr>
		<!--<tr>
		  <td><strong>Lampiran</strong></td>
		  <td>:</td>
		  <td colspan=4><?php //display the attachments if any	
		//$qryLamp = "SELECT * FROM soalan_lampiran WHERE parlimen_id='$id'";
		//$rsLamp = mysql_query($qryLamp,$conn);
		//while($rowLamp = mysql_fetch_array($rsLamp)){
			//$nama_fail = $rowLamp['nama_fail'];
			//$path = "../parlimen/lampiran/$nama_fail";
			//echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";
		//}
		?></td>
	  </tr>-->
		<tr>
	  <td width=204>Jawapan hendaklah sampai ke Urus Setia Penyelarasan Parlimen KKM sebelum</td>
	  <td width=10>:</td><td colspan=4><?php echo Reverse($row['tkh_jawab']) ?></td></tr>
	</table>
</fieldset>