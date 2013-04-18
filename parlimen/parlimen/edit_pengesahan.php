<script language="javascript" type="text/javascript">

function Radioksp(val)
{
var tr_pindaksp = document.getElementById("pindaksp");
//var tr_semakksp = document.getElementById("semakksp");

	if (val=="1"){
	edit_jawapan2.KSP_Status2.checked=false;
	tr_pindaksp.style.display = '';
	//tr_semakksp.style.display = 'none'; 
	
	}
	
	if (val=="2"){
	edit_jawapan2.KSP_Status1.checked=false;
	tr_pindaksp.style.display = 'none';
	//tr_semakksp.style.display = '';
	
	}
}
</script>

<?php
session_start();
$parlimen_id = $_POST['parlimen_id'];

if(checkACL($_SESSION['userid'],8,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$parlimen_id = $_POST['parlimen_id'];
			
	$qry = "SELECT pengesahan_catatan, no_soalan FROM parlimen WHERE id='$parlimen_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	$soalan_row=$row2['no_soalan'];
	?><br/>
	<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
    <?php include("inc_butirSoalan.php"); ?>	
	<br><br>
	<?php include("jawapan_agensi.php"); ?>
	<br><br>
	<form name="edit_jawapan2" id="edit_jawapan2" method="post" onSubmit="if(toValidate) return validateFormPengesahan(this)">
	<fieldset>
	<legend><strong>Semakan KSP</strong></legend>
	<div class="sub">
		<table border=0 width="100%">

			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>            
		  </tr> <?php $nama_sah = $_SESSION['nama'] ?>
			<tr><td width=200>Nama Pegawai</td><td width=10>:</td>
			<td><?php echo stripslashes($nama_sah)?></td></td></tr>
			<tr><td width=200>Jawatan</td><td width=10>:</td>
			<td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
			<tr>
			  <td width=200>
			  Pindaan/Pertanyaan</td>
			  <td width=10>
		      :</td><td width="731">
		        <input type="radio" name="KSP_Status1" value="0" onclick="Radioksp(1)">
			  Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <input type="radio" name="KSP_Status2" value="1" onclick="Radioksp(2)">
			    Tidak</td><td width="26"></td></tr>			
				<tr id="pindaksp" style="display:none;" valign="top" >
			      <td width=200>Catatan sekiranya Ada Pindaan </td>
			      <td width=10>:</td>
			<td><textarea name="Pengesahan_Catatan" rows=6 cols=60><?php echo $row2['pengesahan_catatan'] ?></textarea></td></tr>
		</table>	
	</div>
	</fieldset><br /><br />
	<?php //echo "idagen2".$_SESSION['agensi_id']; ?>
	<input type="hidden" name="parlimen_id" value="<?php echo $parlimen_id ?>"/>
	<input type="hidden" name="no_soalan" value="<?php echo $soalan_row ;?>"/> 
	<input type="hidden" name="agen" value="<?php echo $_SESSION['agensi_id'];?>"/>		 		
	<!--<input class="button" name="SimpanPengesahan" type="submit" value="SIMPAN" onClick="toValidate=false"/>-->
	<input class="button" name="SimpanDanHantarPengesahan" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>
	</form>
<?php } ?>
