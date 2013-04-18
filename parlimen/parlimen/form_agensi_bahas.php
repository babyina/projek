<script language="javascript">
	var jawapan = 1;
	var tamb = 1;
	var ket = 1;
</script>
<?php
	$qry = "SELECT agensi_id,nama_pegawai,jawapan,tambahan,keterangan_tambahan,penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan 
			FROM bahas_agensi WHERE id='$jawapan_id'";
	$result = mysql_query($qry,$conn);
	$row3 = mysql_fetch_array($result);
	
	$nama = $_SESSION['nama'];
	$agensi_id = $row3['agensi_id'];

	?>
<style type="text/css">
<!--
.style1 {color: #0080C0}
-->
</style>
<br />
	<form name="edit_jawapanb" enctype="multipart/form-data" method="post">
	<fieldset>
	<legend><b>Jawapan Agensi </b></legend>
	<div class="sub">
		<table border=0 width="100%">
	
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288><br />
			Bahagian/Agensi Kementerian Kesihatan </td>
			  <td width=22><br />
		      :</td><td width="613"><br />
		        <font class="fs">
		        <?php echo $_SESSION['agensi'] ?></font></td></tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Disediakan Oleh</td>
			<td width=22>:</td>
			<td> <input class="txt" type="text" name="penyedia_nama" size="35" value="<?php echo $row3['penyedia_nama'] ?>"> 
			<font class="fs">&nbsp;&nbsp;&nbsp;(jika ada)</font></td>
			</tr>
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Jawatan</td>
			<td width=22>:</td>
			<td> <input class="txt" type="text" name="penyedia_jawatan" size="35" value="<?php echo $row3['penyedia_jawatan'] ?>"></td></tr>
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Disahkan Oleh</td>
			<td width=22>:</td>
			<td> <input class="txt" type="text" name="pengesah_nama" size="35" value="<?php echo $row3['pengesah_nama'] ?>">
			 <font class="fs">&nbsp;&nbsp;&nbsp;(jika ada)</font></td>
			</tr>
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Jawatan</td>
			<td width=22>:</td>
			<td> <input class="txt" type="text" name="pengesah_jawatan" size="35" value="<?php echo $row3['pengesah_jawatan'] ?>"></td></tr>

			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Jawapan</td>
			<td width=22>:</td>
			<td><a href="" onclick="jawapan=collapse(jawapan,div_jaw2,img_collapsejaw);return false;"><img id="img_collapsejaw" name="img_collapsejaw" src="../images/expand.gif" border="0"/></a>			  </td></tr>
			<tr>
			  <td colspan="4">
		  	<div id="div_jaw2" name="div_jaw2" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Jawapan', $row3['jawapan']);?>
			 </div>			  </td>
		  </tr>
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Maklumat Tambahan</td>
			<td width=22>:</td>
			<td><a href="" onclick="tamb=collapse(tamb,div_tamb,img_collapse2);return false;"><img id="img_collapse2" name="img_collapse2" src="../images/expand.gif" border="0"/></a></td></tr>
			<tr>
			  <td colspan="4">
		  	<div id="div_tamb" name="div_tamb" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Tambahan', $row3['tambahan']);?>
			 </div></td>
		  </tr>
		  	<?php if ($status==10){  // view keterangan tambahan pd mode pindaan HEK sahaja  ?>
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Keterangan Tambahan</td>
			<td width=22>:</td>
			<td><a href="" onclick="ket=collapse(ket,div_ket,img_collapse3);return false;"><img id="img_collapse3" name="img_collapse3" src="../images/expand.gif" border="0"/></a></td></tr>
	
			<tr>
			  <td colspan="4">
		  	<div id="div_ket" name="div_ket" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Keterangan_Tambahan', $row3['keterangan_tambahan']);?>
			 </div>			  </td>
		  </tr>
			<?php } ?> 		  
			<tr>
			  <td width=15>&nbsp;</td>
			  <td width=288>Lampiran</td>
			<td width=22>:</td>
			<td><input id="my_file_element" type="file" name="file_1" /></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>
		      <?php //display the attachments if any				
			$qry = "SELECT * FROM bahas_lampiran WHERE jawapan_id='$jawapan_id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
			?></td>
			</tr>
			  <tr>
			    <td width=15></td>
			    <td width=288></td>
			  <td width=22></td>
			  <td>
			  
				<!-- This is where the output will appear -->
				<div id="files_list"></div>
				<script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td></tr>
			
			<tr><td colspan="4"></td></tr>
			 <tr><td colspan="4">
			 <p><br> <font class="current_user">Nama Pegawai Bertugas : <?php echo $nama."  ".$current_time ?></font> </p>			 <br>
			 </td></tr>		 
		</table>		
		
	</div>
	</fieldset>
	
	<input type="hidden" name="agensi_id" value="<?php echo $agensi_id ?>" />
	<input type="hidden" name="jawapan_id" value="<?php echo $jawapan_id ?>" />
	<input type="hidden" name="nama_pegawai" value="<?php echo $_SESSION['nama']?>" />
	<input type="hidden" name="ketua_jabatan" value="<?php echo $row2['ketua_jabatan'] ?>" />
	<input type="hidden" name="no_telefon" value="<?php echo $row2['no_telefon'] ?>" />
	<input type="hidden" name="bahas_id" value="<?php echo $bahas_id ?>"/>
	<input type="hidden" name="status" value="<?php echo $status ?>"/>	
	
	<input class="button" name="SimpanJawapanBahas" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanDanHantarJawapanBahas" type="submit" value="SIMPAN & HANTAR"/>
	</form>
