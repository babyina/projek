<?php
session_start();

if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
			
	$qry = "SELECT korperat_jawapan,korperat_tambahan,catatan_final FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<form name="edit_jawapan" method="post">
	<fieldset><legend><b>Edit Jawapan Hal Ehwal Korperat - Jawapan Akhir</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr><td width=120>Nama Pegawai</td><td width=5>:</td><td><?php echo $_SESSION['nama']?></td></td></tr>
			<tr><td width=120>Jawatan</td><td width=5>:</td><td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
		</table>
		<table border=0 width="100%">
			<tr><td width=120>Jawapan</td><td width=5>:</td><td><textarea name="Jawapan_Final" rows=5 cols=35><?php echo $row2['korperat_jawapan'] ?></textarea></td></tr>
			<tr><td width=120>Maklumat Tambahan</td><td width=5>:</td><td><textarea name="Korperat_Tambahan" rows=5 cols=35><?php echo $row2['korperat_tambahan'] ?></textarea></td></tr>
			<tr><td width=120>Catatan</td><td width=5>:</td><td><textarea name="Catatan_Final" rows=5 cols=35><?php echo $row2['catatan_final'] ?></textarea></td></tr>
			<tr><td width=120>Lampiran</td><td width=5>:</td><td>
			<?php //display the attachments if any
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND jawapan_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a><br>&nbsp;&nbsp;";
			}
			?>
			</td></tr>
		</table>
	</div>
	</fieldset>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input class="button" name="SimpanJawapanAkhir" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanHantarJawapanAkhir" type="submit" value="TEKS AKHIR"/>
	</form>

		<form name="pdf" method="post" action="fpdf_parlimen.php" target="_blank">		
		<img src='../images/pdf.jpg'/><input type="submit" value="Cetakan PDF" class="pdf"/>
		<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
		</form>		
<?php } ?>