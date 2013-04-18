<?php
session_start();

if(checkACL($_SESSION['userid'],2,$_SESSION['agensi_id'],$conn) == false){
	echo "capaian tidak sah !";	
}else{
	$parlimen_id = $_POST['parlimen_id'];	
	$agensi_id = $_SESSION['agensi_id'];
	$userid = $_SESSION['userid'];
	
	//select pegawai agensi yang terlibat
	//$qry = "SELECT id,nama,agensi_id FROM pengguna
			//WHERE agensi_id = '$agensi_id' AND id = '$userid'";
			
	//$result = mysql_query($qry,$conn) or die(mysql_error());
	//$row2 = mysql_fetch_array($result);
	
	$qry = "SELECT agensi_id,nama_pegawai,jawapan,tambahan,keterangan_tambahan,penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan 
			FROM parlimen_agensi WHERE id='$jawapan_id'";
	$result = mysql_query($qry,$conn);
	$row3 = mysql_fetch_array($result);
	
	$nama = $_SESSION['nama'];

	?>
<style type="text/css">
<!--
.style1 {color: #0080C0}
-->
</style>

	<form name="edit_jawapan" enctype="multipart/form-data" method="post">
	<fieldset><legend><b>Edit Jawapan</b></legend>
	<div class="sub">
		<table border=0 width="100%">
		<? //echo $jawapan_id."<br>" ?>
			<tr><td width=120>Jabatan</td><td width=5>:</td><td><?php echo $_SESSION['agensi'] ?></td></tr>
			<tr><td width=120>Disediakan Oleh</td><td width=5>:</td><td> <input type="text" name="penyedia_nama" size="35" value="<? echo $row3['penyedia_nama'] ?>"></td></tr>
			<tr><td width=120>Jawatan</td><td width=5>:</td><td> <input type="text" name="penyedia_jawatan" size="35" value="<? echo $row3['penyedia_jawatan'] ?>"></td></tr>
			<tr><td width=120>Disahkan Oleh</td><td width=5>:</td><td> <input type="text" name="pengesah_nama" size="35" value="<? echo $row3['pengesah_nama'] ?>"></td></tr>
			<tr><td width=120>Jawatan</td><td width=5>:</td><td> <input type="text" name="pengesah_jawatan" size="35" value="<? echo $row3['pengesah_jawatan'] ?>"></td></tr>
		</table>
		<table border=0 width="100%">
			<tr><td width=120>Jawapan</td><td width=5>:</td><td><textarea name="Jawapan" rows=5 cols=35><?php echo $row3['jawapan'] ?></textarea></td></tr>
			<tr><td width=120>Maklumat Tambahan</td><td width=5>:</td><td><textarea name="Tambahan" rows=5 cols=35><?php echo $row3['tambahan'] ?></textarea></td></tr>
			
			<? if ($status==10){  // view keterangan tambahan pd mode pindaan HEK sahaja  ?>
			<tr><td width=120>Keterangan Tambahan</td><td width=5>:</td><td><textarea name="Keterangan_Tambahan" rows=5 cols=35><?php echo $row3['keterangan_tambahan'] ?></textarea></td></tr>
			<? } ?> 
			
			<tr><td width=120>Lampiran</td><td width=5>:</td><td>
			<?php //display the attachments if any				
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id='$jawapan_id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
			?>
			</td></tr>
			<tr><td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><input id="my_file_element" type="file" name="file_1" >&nbsp;</td></tr>
			  <tr><td width=120></td><td width=5></td><td>
			  
				<!-- This is where the output will appear -->
				<div id="files_list"></div>
				<script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 3 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td></tr>
			
			<tr><td colspan="3"></td></tr>
			 <tr><td width=120></td><td width=5></td><td>
			 <p><br><span class="style1">Nama Pegawai Bertugas : <? echo $nama ?></span> </p><br>
			 </td></tr>		 
		</table>		
		
	</div>
	</fieldset>
	
	<input type="hidden" name="agensi_id" value="<?php echo $agensi_id ?>" />
	<input type="hidden" name="jawapan_id" value="<?php echo $jawapan_id ?>" />
	<input type="hidden" name="nama_pegawai" value="<?php echo $_SESSION['nama']?>" />
	<input type="hidden" name="ketua_jabatan" value="<?php echo $row2['ketua_jabatan'] ?>" />
	<input type="hidden" name="no_telefon" value="<?php echo $row2['telefon'] ?>" />
	
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
		<input class="button" name="SimpanJawapan" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanDanHantarJawapan" type="submit" value="SIMPAN & HANTAR"/>
	</form>
<?php } ?>
