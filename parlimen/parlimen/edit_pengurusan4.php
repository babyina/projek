<?php
session_start();
include("../js/FCKeditor/fckeditor.php");
require("query_soalan.php");

$parlimen_id = $_POST['parlimen_id'];

$current_time = date("d-m-Y G:i:s",time()+(8*3600));
if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	
	$qry = "SELECT status,korperat_jawapan,korperat_tambahan,korperat_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row = mysql_fetch_array($result);
	$status = $row['status'];

	
//----- azila try (pengurusan)-----------------------------	
/*if(checkACL($_SESSION['userid'],4,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	$date = MysqlDate(date("d/m/Y"));
	*/
	//---------------------------------------------
	$qry = "SELECT pengesahan_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	
	$qry1 = "SELECT catatan FROM parlimen_agensi WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row3 = mysql_fetch_array($result);
	?>
	
	<br />
	
<script language="javascript">

	var state_jaw = 1;
	var state_tamb = 1;
	
</script>


	<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div>
	<p><br/>
	    <?php include("inc_butirSoalan.php"); ?>
	    <br>
		<?php 
	     
		 	//include("edit_korperat_bypass.php"); 
			include("jawapan_agensi.php");


			?>
  </p>
	<p>
	
	
    </p>
	
		<form name="edit_jawapann" method="post"  id="edit_jawapann" onSubmit="if(toValidate) return validateFormPengurusan(this)">
	<fieldset><legend><b>Edit Jawapan Hal Ehwal Korperat</b></legend>
	<div class="sub">
	
		<?php
		$view = "false";
	
#--------------------------------------------------------- status = 3,21,22,10  -----------------------------------------------------------		
		if($status == 3||$status == 10||$status == 21||$status == 23||$status==7) //utk view portion agensi
		{ 
		
		//if($status==3){
		?>
		<br />
		<?php } 
		
		 ?>
<table border=0 width="100%">
		<tr>
			<td width=219>Jawapan</td>
			<td width=3>:</td>
			<td> <?php createRTF($sBasePath, 'Korperat_Jawapan', $row['korperat_jawapan']);?> </td>
		</tr>
		
		<tr>
			<td width=219>Maklumat Tambahan</td>
			<td width=3>:</td>
			<td>
				
				 <?php createRTF($sBasePath, 'Korperat_Tambahan', $row['korperat_tambahan']);?>
						</td>
		</tr>
		
		<?php if($status == 3) { ?>
			
		  <?php } ?>	
			<tr><td width=219>Lampiran</td><td width=3>:</td>
			<td><input id="my_file_element" type="file" name="file_1" /></td>
			</tr>
          <tr>
            <td width=219></td>
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
            <td>
              <?php //display the attachments if any	
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row3 = mysql_fetch_array($res)){
				$nama_fail = $row3['nama_fail'];
				echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a><br>";
			}
			?></td>
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
	
	
	<fieldset><legend><b>Bahagian Pengesahan</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>
			<tr><td width=200>Nama Pegawai</td><td width=10>:</td><td colspan="2"><?php echo $_SESSION['nama']?></td><td width="29"></td></tr>
			<tr><td width=200>Jawatan</td><td width=10>:</td><td colspan="2"><?php echo $_SESSION['jawatan'] ?></td></td></tr>
		  
			<tr>
			  <td width=200>
			  Pindaan/Pertanyaan</td>
			  <td width=10>:</td>          
			  <td>
		      <input type="radio" name="Pengesahan_Status1" value="0" onclick="RadioPengurusan(1)" />Ya</td>
			  <td>
			  <input type="radio" name="Pengesahan_Status2" value="1" onclick="RadioPengurusan(2)" />Tidak</td>
			</tr>			

			<tr>
			  <td width=200>Untuk Semakan</td><td width=10>:</td>			  
			  <td width="156"><?php getAgensiPindaan($Agensi, $conn, $id); ?>
			  <td width="568"><?php
//=====================================================================================================
//      get the list for semakan pengurusan from table konfigurasi. Keyword - Pengesahan Parlimen	
//=====================================================================================================
			//	<input type="checkbox" name="salinan[]" value="KSU" disabled="disabled" />KSU 
			//	<input type="checkbox" name="salinan[]" value="TKSU(O)" disabled="disabled" />TKSU(O)
			//	<input checked type="checkbox" name="salinan[]" value="SUB(O)" disabled="disabled" />SUB(O)</td><td width="0"></td></tr>
		
				$cat = "Pengesahan Parlimen";
				getSemakanParlimen($conn,$cat);					
		?>    
		    <tr valign="top">
			  <td width=200>Catatan Sekiranya Ada Pindaan </td>
			  <td width=10>:</td><td id="Catatan_Pindaan"colspan="2"><textarea name="Catatan_Pindaan" rows=6 cols=60><?php echo $row3['catatan'] ?></textarea></td></td></tr>      
			<tr valign="top">
			  <td width=200>&nbsp;</td>
			  <td width=10>&nbsp;</td>
			  <td colspan="2">&nbsp;</td>
			  </td></tr>
		</table>
<br />
	</div>
	</fieldset><br /><br />
	
	
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input type="hidden" name="status" value="<?php echo $status ?>"/>
	<?php //<input class="button" name="SimpanKorperat" type="submit" value="SIMPAN" onclick="toValidate=false"/> ?>
<?php } ?>
	
	<?php 
	//if($status==3){
	//if($status==3||$status==5||$status==7||$status==8){
	?>
   <?php // <input class="button" name="SimpanDanHantarKorperat" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>	?>
	<?php //} ?>
	
	<input type="hidden" name="pengesahan_status" value=""/>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input type="hidden" name="pengurusan_tarikh" value="<?php echo $date ?>"/>&nbsp;&nbsp;&nbsp;
	<input class="button" name="SimpanPengurusanKoperat" type="submit" value="SIMPAN" onClick="toValidate=false"/>
	<input class="button" name="SimpanDanHantarPengurusanKoperat" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>
	
	
	
	</form>
