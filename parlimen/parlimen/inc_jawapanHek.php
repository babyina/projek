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
	//END BUTIR2 SOALAN

?>

<script language="javascript">
	var soalan = 1;
</script>

<fieldset><legend><b>Jawapan HEK</b></legend>
	<table border=0 width=100%>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  	<td width=199>Tarikh </td><td width=10>:</td>
			<td width="762"><?php echo Reverse($row['korperat_tarikh']) ?></td>
		</tr>
		<tr>
		  <td width=199 valign=top>Jawapan</td>
		  <td valign="top" width=10>:</td>
		  <td>
			<div class="scroll">
			<?php 
				echo stripslashes($row['korperat_jawapan']);
			?>
			</div>
		  </td>
		</tr>
		<tr>
		  <td width=199 valign=top>Maklumat Tambahan</td>
		  <td valign="top" width=10>:</td>
		  <td>
			<div class="scroll">
			<?php 
				echo stripslashes($row['korperat_tambahan']);
			?>
			</div>
		  </td>
		</tr>
		<tr>
		  <td>Lampiran</td>
		  <td>:</td>
		  <td>
            <?php //display the attachments if any				
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row4 = mysql_fetch_array($res)){
				$nama_fail = $row4['nama_fail']; 
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
		?>
          </td>
	  </tr>
	</table>
</fieldset>