<?php
session_start();
$bahas_id = $_POST['bahas_id'];

if(checkACL($_SESSION['userid'],5,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$bahas_id = $_POST['bahas_id'];
		
	if($_POST['EditPengesahanBahas'])
	{	
	$qry = "SELECT pengesahan_catatan FROM sesi_bahas WHERE id='$bahas_id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<br /><div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>

	<form name="edit_jawapan" method="post" onSubmit="if(toValidate) return validateFormPengesahan(this)">
	<fieldset><legend><b>Bahagian Pengesahan</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>            
		  </tr>
			<tr><td width=180>Nama Pegawai</td>
			<td width=28>:</td>
			<td><?php echo $_SESSION['nama']?></td></td></tr>
			<tr><td width=180>Jawatan</td>
			<td width=28>:</td>
			<td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
			<tr>
			  <td width=180>
			  Pindaan/Pertanyaan</td>
			  <td width=28>:</td>
			  <td width="704">
			  <input type="radio" name="Pengesahan_Status" value="0">Ya
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input type="radio" name="Pengesahan_Status" value="1">Tidak
			  </td><td width="26"></td>
			</tr>
			<tr><td width=180>Catatan</td>
			<td width=28>:</td>
			<td><textarea name="Pengesahan_Catatan" rows=6 cols=60><?php echo $row2['pengesahan_catatan'] ?></textarea></td></tr>
		</table>	
	</div>
	</fieldset><br /><br />
	<input type="hidden" name="bahas_id" value="<?php echo $bahas_id ?>"/>&nbsp;&nbsp;
	<input class="button" name="SimpanPengesahanBahas" type="submit" value="SIMPAN" onClick="toValidate=false"/>
	<input class="button" name="SimpanHantarPengesahanBahas" type="submit" value="SIMPAN & HANTAR" onClick="toValidate=true"/>
	</form><center>
<?php 
	}
	if($_POST['SimpanPengesahanBahas'])
	{
	$bahas_id = $_POST['bahas_id'];
	$pengesahan_catatan = addslashes($_POST['Pengesahan_Catatan']);
	$pengesahan_nama = addslashes($_SESSION['nama']);
	$pengesahan_jawatan = $_SESSION['jawatan'];
	$date = MysqlDate(date("d/m/Y"));
	
	$qry = "UPDATE sesi_bahas SET pengesahan_catatan = '$pengesahan_catatan', 
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh= '$date' 
			WHERE sesi_bahas.id = '$bahas_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	$msg = "<center><br/>Rekod telah disimpan.";
	echo $msg;
	echo "<br><br><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a></center>";
	}
	if($_POST['SimpanHantarPengesahanBahas'])
	{
		
	$bahas_id = $_POST['bahas_id'];
	$pengesahan_catatan = $_POST['Pengesahan_Catatan'];
	$pengesahan_status = $_POST['Pengesahan_Status'];
	$pengesahan_nama = $_SESSION['nama'];
	$pengesahan_jawatan = $_SESSION['jawatan'];
	$date = MysqlDate(date("d/m/Y"));	
	$perkara = getInfo("sesi_bahas", $bahas_id,"tajuk");
	$subject = $nama_sistem." : ".$perkara."\n";
	$url = $link_bahas.$bahas_id; 	
	$message = "Sila klik URL untuk maklumat lanjut\n\n$url";	
	
	if($pengesahan_status == "1"){
		$next_status = "8"; // jawapan akhir HEK after meeting
		$msg2 = "<center><br/>Rekod telah disimpan.";
		if($msg = sendHEK($conn,"modul1",$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}		
		
	}else{
		$next_status = "7"; // pindaan HEK
		$msg2 = "<center><br>Rekod perlu dipinda semula.";
		if($msg = sendHEK($conn,"modul1",$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}		
	}
	
	$qry = "UPDATE sesi_bahas SET status=$next_status, pengesahan_catatan = '$pengesahan_catatan', 
			pengesahan_nama = '$pengesahan_nama', pengesahan_jawatan = '$pengesahan_jawatan', pengesahan_tarikh= '$date'
			WHERE sesi_bahas.id = '$bahas_id' LIMIT 1";
	
	mysql_query($qry,$conn) or die(mysql_error());
	
	echo $msg2;
	echo "<br><br><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a></center>";
	}

} ?>
