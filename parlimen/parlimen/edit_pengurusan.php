<script language="javascript" type="text/javascript">

function RadioPengurusantksp(val)
{
var tr_pindatksp = document.getElementById("pindatksp");
var tr_semakksp = document.getElementById("semakksp");

	if (val=="1"){
	edit_jawapann.Pengesahan_Status2.checked=false; 
	tr_pindatksp.style.display = '';
	tr_semakksp.style.display = 'none';
	
	}
	
	if (val=="2"){
	edit_jawapann.Pengesahan_Status1.checked=false;
	tr_pindatksp.style.display = 'none';
	tr_semakksp.style.display = '';
	
	}
}
</script>
<br/>

<?php
session_start();
include("qry_comfirm.php");
$parlimen_id = $_POST['parlimen_id'];

//if(checkACL($_SESSION['userid'],4,null,$conn) == false){
if(checkACL($_SESSION['userid'],4,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "SELECT penyemak,pengurusan_catatan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	$smktksp=$row2['penyemak'];
	
	?>
	<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div>
	<p><br/>
	    <?php include("inc_butirSoalan.php"); ?>
	    <br>
		<? 
	     
		 	//include("edit_korperat_bypass.php"); jawapan_agensi.php
			// include("inc_jawapanHek.php");  asal pada 16 /11/2009
			include("jawapan_agensi.php");
			
		?>
  </p>
	<p>
	
	<br>
	  <br>
    </p>
	<form name="edit_jawapann" method="post"  id="edit_jawapann" onSubmit="if(toValidate) return validateFormPengurusan(this)">
	<fieldset>
	<legend><b>Semakan Peringkat TKSP - <?php echo "  ".$smktksp;?></b></legend>
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
		      <input type="radio" id="radio_pil" name="Pengesahan_Status1" value="0" onclick="RadioPengurusantksp(1)" />Ya
		      <input type="radio" id="radio_pil" name="Pengesahan_Status2" value="1" onClick="RadioPengurusantksp(2)" />
		      Tidak </td>
			  <td>&nbsp;</td>
			</tr>												

			<tr id="pindatksp" style="display:none;">
			  <td valign="top">Catatan Sekiranya ada pindaan</td>
			  <td valign="top">:</td>
			  <td valign="top" id="Pengurusan_Catatan"><textarea name="Pengurusan_Catatan" rows=6 cols=60><?php echo $row2['pengurusan_catatan'] ?></textarea>            
			  <td>            
		 <!-- <tr  >
		    <td width=200>Pindaan/Pertanyaan</td><td width=10>:</td>			  
		    <td width="156">		                  
		    <td width="568">
			</tr> -->
  	    <tr id="semakksp" style="display:none;" >
			  <td width=200>Untuk Semakan</td>
			  <td width=10>:</td><td colspan="2"><?php
//=====================================================================================================
//      get the list for semakan pengurusan from table konfigurasi. Keyword - Pengesahan Parlimen	
//=====================================================================================================
			//	<input type="checkbox" name="salinan[]" value="KSU" disabled="disabled" />KSU 
			//	<input type="checkbox" name="salinan[]" value="TKSU(O)" disabled="disabled" />TKSU(O)
			//	<input checked type="checkbox" name="salinan[]" value="SUB(O)" disabled="disabled" />SUB(O)</td><td width="0"></td></tr>
		
				$cat = "Pengesahan Parlimen";
				getSemakanParlimen2($conn,$cat);	 			 	
		?></td></td></tr>
		</table>
<br />
	</div>
	</fieldset><br /><br />
	<input type="hidden" name="pengesahan_status" value=""/>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
	<input type="hidden" name="agensi_id" value="<?php echo $agensi_id ?>"/>		
	<input type="hidden" name="pengurusan_tarikh" value="<?php echo $date ?>"/>&nbsp;&nbsp;&nbsp;
	<!--<input class="button" name="SimpanPengurusan" type="submit" value="SIMPAN" onClick="toValidate=false"/>-->
	<input class="button" name="SimpanDanHantarPengurusan" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true;"/>
	</form>
<?php } ?>
