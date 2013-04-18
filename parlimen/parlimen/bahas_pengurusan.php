<?php
session_start();
$bahas_id = $_POST['bahas_id'];

if(checkACL($_SESSION['userid'],4,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$bahas_id = $_POST['bahas_id'];
	$date = MysqlDate(date("d/m/Y"));
	
if($_POST['EditPengurusanBahas'])
	{
	$qry = "SELECT pengurusan_catatan FROM sesi_bahas WHERE id='$bahas_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<br /><div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>

	<form name="edit_jawapann" method="post"  id="edit_jawapann" onSubmit="if(toValidate) return validateFormPengurusan(this)">
	<fieldset><legend><b>Bahagian Pengurusan</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			  <td colspan="4">&nbsp;</td>
		  </tr>
			<tr><td width=209>Nama Pegawai</td><td width=13>:</td><td colspan="2"><?php echo $_SESSION['nama']?></td></td></tr>
			<tr><td width=209>Jawatan</td><td width=13>:</td><td colspan="2"><?php echo $_SESSION['jawatan'] ?></td></td></tr>
		  
			<tr>
			  <td width=209>
			  Pindaan/Pertanyaan</td>
			  <td width=13><br />:</td><td width="143">
			<input type="radio" name="Pengesahan_Status1" value="0" onclick="RadioPengurusan(1)" />Ya
			</td>
			  <td width="569"><input name="Pengesahan_Status2" type="radio" value="1" onclick="RadioPengurusan(2)" />
Tidak</td>
			</tr>			
			<tr><td width=209>Untuk Tindakan</td><td width=13>:</td><td>&nbsp;</td>
			  <td><?php
//=====================================================================================================
//      get the list for semakan pengurusan from table konfigurasi. Keyword - Pengesahan Parlimen	
//=====================================================================================================
			//	<input type="checkbox" name="salinan[]" value="KSU" disabled="disabled" />KSU 
			//	<input type="checkbox" name="salinan[]" value="TKSU(O)" disabled="disabled" />TKSU(O)
			//	<input checked type="checkbox" name="salinan[]" value="SUB(O)" disabled="disabled" />SUB(O)</td><td width="0"></td></tr>
		
				$cat = "Pengesahan Parlimen";
				getSemakanParlimen($conn,$cat);					
		?></td>
			  <td width="0"></td></tr>
			<tr><td width=209>Catatan</td><td width=13>:</td><td colspan="2"><textarea name="Pengurusan_Catatan" rows=6 cols=60><?php echo $row2['pengurusan_catatan'] ?></textarea></td></td></tr>
		</table>
	</div>
	</fieldset><br />
	<input type="hidden" name="pengesahan_status" value=""/>
	<input type="hidden" name="bahas_id" value="<?php echo $bahas_id ?>"/>	
	<input type="hidden" name="Pengurusan_tarikh" value="<?php echo $date ?>"/>&nbsp;&nbsp;
	<input class="button" name="SimpanPengurusanBahas" type="submit" value="SIMPAN" onClick="toValidate=false"/>
	<input class="button" name="SimpanHantarPengurusanBahas" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>
	</form>
<?php 
}elseif($_POST['SimpanPengurusanBahas'])
{
	$bahas_id = $_POST['bahas_id'];
	$pengurusan_catatan = addslashes($_POST['Pengurusan_Catatan']);
	$pengurusan_nama = addslashes($_SESSION['nama']);
	$pengurusan_jawatan = $_SESSION['jawatan'];
	$pengurusan_tarikh = $_POST['Pengurusan_tarikh'];
	
	$msg22 = "Rekod telah disimpan.";
	$qry = "UPDATE sesi_bahas SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan', pengurusan_catatan='$pengurusan_catatan', pengurusan_tarikh='$pengurusan_tarikh' WHERE id='$bahas_id' LIMIT 1";
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo $msg;
	//send mail
	echo "<br><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a>";
	
}elseif($_POST['SimpanHantarPengurusanBahas'])
{
	$pengesahan_status = $_POST['pengesahan_status'];
	$pengurusan_nama = $_SESSION['nama'];
	$pengurusan_jawatan = $_SESSION['jawatan'];
	$bahas_id = $_POST['bahas_id'];
	$pengurusan_catatan = $_POST['Pengurusan_Catatan'];
	$pengurusan_tarikh = $_POST['Pengurusan_tarikh'];
	$salinan = is_array($_POST['salinan'])?implode("+",$_POST['salinan']):$_POST['salinan'];
	$penyemak = $salinan;

	$perkara = getInfo("sesi_bahas", $bahas_id,"tajuk");
	$subject = $nama_sistem." : ".$perkara."\n";
	//$link_parlimen="http://192.168.105.173/parlimen/login.php?action=detailsbahas&id=";
	$url = $link_bahas.$bahas_id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	
	if($pengesahan_status == "2"){
		$next_status = "6"; //pengesahan
		$msg2 = "<br><center>Rekod telah disimpan.";
		$salinan= explode("+",$salinan);
		if($msg = sendSalinan($conn,$salinan,$subject,$message)){
				echo "<center><font class=subheader1><br/> Salinan emel telah dihantar kepada</font><br/><br/>";
				echo $msg."</center><br>";
		}		
		
	}else{
		$next_status = "5"; //pindaan HEK
		$msg2 = "<br><center>Rekod perlu dipinda semula.";
		if($msg = sendHEK($conn,"modul1",$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}			
	}
	
	$qry = "UPDATE sesi_bahas SET pengurusan_nama='$pengurusan_nama', pengurusan_jawatan = '$pengurusan_jawatan',
		 pengurusan_catatan='$pengurusan_catatan', pengurusan_tarikh='$pengurusan_tarikh', status = '$next_status', penyemak = '$penyemak' 
	 	 WHERE id='$bahas_id' LIMIT 1";
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo $msg2;
	//send mail
	echo "<br><br><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a>";

}
}
 ?>
