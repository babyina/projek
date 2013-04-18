<br/>
<?php
session_start();
$parlimen_id = $_POST['parlimen_id'];

if(checkACL($_SESSION['userid'],4,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "SELECT pengurusan_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div>
	<p><br/>
	    <?php include("inc_butirSoalan.php"); ?>
	    <br>
		<? 
	     
		 	include("edit_korperat_bypass.php"); 
			// include("inc_jawapanHek.php"); 
		?>
  </p>
	<p>
	
	<br>
	  <br>
    </p>
	<form name="edit_jawapann" method="post"  id="edit_jawapann" onSubmit="if(toValidate) return validateFormPengurusan(this)">
	<fieldset><legend><b>Bahagian Pengurusan</b></legend>
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
			  <td width=200>Untuk Semakan</td><td width=10>:</td>			  <td width="156">
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
			  <td width=200>Catatan Pengurusan </td>
			  <td width=10>:</td><td colspan="2"><textarea name="Pengurusan_Catatan" rows=6 cols=60><?php echo $row2['pengurusan_catatan'] ?></textarea></td></td></tr>
		</table>
<br />
	</div>
	</fieldset><br /><br />
	
	<input type="hidden" name="pengesahan_status" value=""/>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>	
	<input type="hidden" name="status" value="<?php echo $status ?>"/>
	<input class="button" name="SimpanKorperat" type="submit" value="SIMPAN" onclick="toValidate=false"/>
	
	<?php 
	//if($status==3){
	if($status==3||$status==5||$status==7||$status==8){
	?>
    <input class="button" name="SimpanDanHantarKorperat" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>	
	<?php } ?>
	
	<input type="hidden" name="pengesahan_status" value=""/>
	<input type="hidden" name="pengurusan_tarikh" value="<?php echo $date ?>"/>&nbsp;&nbsp;&nbsp;
	<input class="button" name="SimpanPengurusan" type="submit" value="SIMPAN" onClick="toValidate=false"/>
	<input class="button" name="SimpanDanHantarPengurusan" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>
	</form>
<?php } ?>
