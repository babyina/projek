<?php
session_start();

require("query_soalan.php");

if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	
	$qry = "SELECT status,korperat_jawapan,korperat_tambahan,korperat_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	?>
	<form name="edit_jawapann" enctype="multipart/form-data" method="post">
	<fieldset><legend><b>Edit Jawapan Hal Ehwal Korperat</b></legend>
	<div class="sub">
	<br>
		<?php
#--------------------------------------------------------- status = 3,2,10  --------------------------------------------------------------------		
		if($status == 3||$status == 10||$status == 2) //utk view portion agensi
		{ 
		
		include("jawapan_agensi.php");
		if($status==3){
		?>
		<table border=0 width="100%">		
			<tr><td colspan="3">&nbsp;</td></tr>
						<tr>
						  <td width=120>Pindaan/Kuiri</td>
						  <td width=5>:</td><td width="829">
			<input type="radio" name="Pengesahan_Status1" value="0" onClick="RadioSelect(1)">Ya
			<input type="radio" name="Pengesahan_Status2" value="1" onClick="RadioSelect(2)">Tidak</td>
			</tr>
			<tr>
			<td width=120>Untuk Tindakan</td><td width=5>:</td><td>
			<table width="727" border="1" color="#006699">
			  <tr><td width="220"><p><center>
				<input type="checkbox" name="Salinan" value="sub" checked disabled>SUB 
				<input type="checkbox" name="Salinan" value="tksuo" disabled>TKSU(O) 
				<input type="checkbox" name="Salinan" value="kpsu" disabled>KPSU                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
			  </td><td width="491"><? getAgensiPindaan($Agensi, $conn, $id); ?></td></tr>
			</table>		    
			</td>
			</tr>
		</table>
		<? } }
#--------------------------------------------------------- status = 5,7,8 --------------------------------------------------------------------		
		
		 ?>
		<table border=0 width="100%">
			<tr><td colspan="3">&nbsp;</td>
			<tr><td width=120>Nama Pegawai</td><td width=5>:</td><td colspan="2"><?php echo $_SESSION['nama']?></td></tr>
			<tr><td width=120>Jawatan</td><td width=5>:</td><td colspan="2"><?php echo $_SESSION['jawatan'] ?></td></tr>
			<tr><td width=120>Jawapan</td><td width=5>:</td><td><textarea name="Korperat_Jawapan" rows=5 cols=35><?php echo $row['korperat_jawapan'] ?></textarea></td></tr>
			<tr><td width=120>Maklumat Tambahan</td><td width=5>:</td><td><textarea name="Korperat_Tambahan" rows=5 cols=35><?php echo $row['korperat_tambahan'] ?></textarea></td></tr>
			<tr><td width=120>Catatan</td><td width=5>:</td><td><textarea name="Korperat_Catatan" rows=5 cols=35><?php echo $row['korperat_catatan'] ?></textarea></td></tr>
			<tr><td width=120>Lampiran</td><td width=5>:</td><td>
			<?php //display the attachments if any	
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a><br>&nbsp;&nbsp;";
			}
			?>		
			</td></tr>
		    <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input id="my_file_element" type="file" name="file_1" >
        &nbsp;</td>
          </tr>
          <tr>
            <td width=120></td>
            <td width=5></td>
            <td><!-- This is where the output will appear -->
                <div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 3 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td>
          </tr>
        </table>
		<br><br>
	</div>
	</fieldset>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input type="hidden" name="status" value="<?php echo $status ?>"/>	
	<input class="button" name="SimpanKorperat" type="submit" value="SIMPAN"/>&nbsp;&nbsp;&nbsp;&nbsp;
	<? if($status==3){
		?>
    <input class="button" name="SimpanDanHantarKorperat" type="submit" value="SIMPAN & HANTAR"/>	
	<? } ?>
    </form>
	<? } ?>
  