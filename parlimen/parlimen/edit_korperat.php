 <script language="javascript">

	var state_jaw = 1;
	var state_tamb = 1;
</script>
<?php
session_start();
include("../js/FCKeditor/fckeditor.php");
require("query_soalan.php");
$current_time = date("d-m-Y G:i:s",time()+(8*3600));
if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	
	$qry = "SELECT status,korperat_jawapan,korperat_tambahan,korperat_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	?>
	<br />
<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>

	<form name="edit_jawapann" enctype="multipart/form-data" method="post" onSubmit="if(toValidate) return validateFormKorperat(this)">
	
	<br>
	<?php include("inc_butirSoalan.php"); ?>
	<br>
		<?php
		$view = "false";
		include("jawapan_agensi.php");
#--------------------------------------------------------- status = 3,21,22,10  -----------------------------------------------------------		
		if($status == 3||$status == 5 ||$status == 7 || $status == 10||$status == 21||$status == 22 ||$status == 23) //utk view portion agensi
		{ 
		
		//if($status==3){
		?>
		<br />
		
		<fieldset><legend><b>Edit Jawapan Hal Ehwal Korperat</b></legend>
	<div class="sub">
		<table border=0 width="100%">		
			<tr><td colspan="4">&nbsp;</td></tr>
			<tr>
			  <td width="219">Jawapan</td>
			  <td width="3">:</td>
			  <td colspan="2"><?php createRTF($sBasePath, 'Korperat_Jawapan', $row['korperat_jawapan']);?>              </td>
		  </tr>
			<tr>
			  <td width="219">Maklumat Tambahan</td>
			  <td width="3">:</td>
			  <td colspan="2"><?php createRTF($sBasePath, 'Korperat_Tambahan', $row['korperat_tambahan']);?>              </td>
		  </tr>
			<tr>
			  <td>Lampiran</td>
			  <td>:</td>
			  <td colspan="2"><input id="my_file_element" type="file" name="file_1" /></td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td colspan="2"><?php //display the attachments if any	
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a><br>";
			}
			?>
			
			<!-- This is where the output will appear -->
                <div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script>			</td>
		  </tr>
			<tr>
				<td width=219>Pindaan/Pertanyaan</td>
				<td width=3>:</td><td width="195">
			<input type="radio" name="Pengesahan1" value="0" onClick="RadioKorperat(1)">Ya
			</td>
		      <td width="550">&nbsp;</td>
			</tr>
			<tr>
			  <td>Untuk Tindakan/Semakan</td>
			  <td>&nbsp;</td>
			  <td><?php getAgensiPindaan($Agensi, $conn, $id); ?></td>
			  <td>&nbsp;</td>
		  </tr>
			<tr>
			  <td>Catatan Sekira Ada Pindaan</td>
			  <td>&nbsp;</td>
			  <td><textarea id="Korperat_Catatan" name="Korperat_Catatan" rows=5 cols=45><?php echo $row['korperat_catatan'] ?></textarea></td>
		      <td>&nbsp;</td>
		  </tr>
		</table>
		<?php } //}
		
		 ?>
		<table border=0 width="100%">
		<tr>
		  <td>Pindaan/Pertanyaan</td>
		  <td>&nbsp;</td>
		  <td width="958"><input type="radio" name="Pengesahan2" value="1" onclick="RadioKorperat(2)" />
Tidak</td>
	  </tr>
		<tr>
		  <td>Untuk Semakan </td>
		  <td>&nbsp;</td>
		  <td><?php
			  //	<input type="checkbox" name="salinan[]" value="KPSU" disabled>KPSU<br />
			  //	<input type="checkbox" name="salinan[]" value="TKSU(O)" disabled>TKSU(O)<br />
				//<input type="checkbox" name="salinan[]" value="SUB(O)" checked disabled>SUB(O) <br />			 
//=====================================================================================================
//      get the list for semakan pengurusan from table konfigurasi. Keyword - Pengurusan Parlimen	
//=====================================================================================================
				$cat = $keyword[16];
				getSemakanParlimen($conn,$cat);		
			
			?></td>
	  </tr>
		
		<?php if($status == 3|| $status == 22) { ?>		  
			<tr>
			  <td width=237>&nbsp;</td>
			  <td width=3>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
		  <?php } ?>	
			<tr><td width=237>&nbsp;</td><td width=3>&nbsp;</td>
			<td>&nbsp;</td>
			</tr>
          <tr>
            <td width=237></td>
            <td width=3></td>
            <td><!-- This is where the output will appear -->
                <div id="files_list"></div>
                <script>
				<!-- Create an instance of the multiSelector class, pass it the output target and the max number of files -->
				var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 20 );
				<!-- Pass in the file element -->
				multi_selector.addElement( document.getElementById( 'my_file_element' ) );
				</script></td>
          </tr>
		    <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>		  
		  <tr>
		    <br>
		    <td colspan="3"><br>
	          <font class="current_user">Nama Pegawai Bertugas : <?php echo  $_SESSION['nama']."  ".$current_time ?></font></td>
		  </tr>
      </table>
		<br><br>
	</div>
	</fieldset>
	<input type="hidden" name="pengesahan_status" value=""/>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input type="hidden" name="status" value="<?php echo $status ?>"/>	
	<input class="button" name="SimpanKorperat" type="submit" value="SIMPAN" onClick="toValidate=false"/>&nbsp;
	
	<?php 
	//if($status==3){
	if($status==3||$status==5||$status==7||$status==8 || $status == 23){
	?>
    <input class="button" name="SimpanDanHantarKorperat" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>	
	<?php } ?>
    </form>
	<?php } ?>
  