<?php
session_start();
$id=$_GET["id"];
if(checkACL($_SESSION['userid'],3,null,$conn) == false){
	echo "capaian tidak sah !";	
}else{	
	$bahas_id = $_POST['bahas_id'];

	if($_POST['EditFinalBahas'])
	{		
	$qry = "SELECT korperat_jawapan,korperat_tambahan,catatan_final FROM sesi_bahas WHERE id='$id'";
	$result = mysql_query($qry,$conn);
	$row2 = mysql_fetch_array($result);
	
	?>
	<br />
	<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>
	<form name="edit_jawapan" method="post">
	<fieldset><legend><b>Jawapan Akhir</b></legend>
	<div class="sub">
		<table border=0 width="100%">
			<tr><td width=155><br />
			  Nama Pegawai</td><td width=24><br />
			  :</td><td><br /><?php echo $_SESSION['nama']?></td><td width="0"></td></tr>
			<tr><td width=155>Jawatan</td><td width=24>:</td>
			<td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td width="759">&nbsp;</td>
		  </tr>
			<tr><td width=155>Jawapan</td><td width=24>:</td>
			<td><input name="jawapan"  class="button" type="button" value="KEMASKINI JAWAPAN" onclick="window.open('../parlimen/form_jawapan.php?action=jawapan&amp;id=<?php echo $id ?>','mywin');return(false);"/></td></tr>
			<tr>
			  <td>Status</td>
			  <td>:</td>
			  <td><select name="status_bahas">
              <option value="Selesai Digulung" selected="selected">Selesai Digulung</option>
              <option value="Tidak Sempat Digulung. Jawapan Bertulis telah dihantar">Tidak Sempat Digulung. Jawapan Bertulis telah dihantar</option>
            </select>
			</td>
		  </tr>
			<tr><td width=155>Catatan</td><td width=24>:</td>
			<td><textarea name="Catatan_Final" rows=5 cols=55><?php echo $row2['catatan_final'] ?></textarea><br /><br /></td></tr>
		</table>
	</div>
	</fieldset><br /><br />&nbsp;&nbsp;
	<input type="hidden" name="bahas_id" value="<?php echo $bahas_id ?>"/>	
	<input class="button" name="SimpanJawapanAkhirBahas" type="submit" value="SIMPAN"/>
	<input class="button" name="SimpanHantarJawapanAkhirBahas" type="submit" value="TEKS AKHIR"/>
	</form>

		<form name="pdf" method="post" action="fpdf_bahas.php" target="_blank">
		  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
		</form>		
<?php 
	}
	if($_POST['SimpanJawapanAkhirBahas'])
	{
		$bahas_id = $_POST['bahas_id'];
		$status_bahas = $_POST['status_bahas'];
		$korperat_nama = addslashes($_SESSION['nama']);
		$korperat_jawatan = $_SESSION['jawatan'];
		$korperat_jawapan = addslashes($_POST['Jawapan_Final']);
		$catatan = addslashes($_POST['Catatan_Final']);
		$korperat_tambahan = addslashes($_POST['Korperat_Tambahan']);

		$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
				korperat_jawapan = '$korperat_jawapan', korperat_tambahan = '$korperat_tambahan', catatan_final = '$catatan',  status_bahas='$status_bahas'
				WHERE sesi_bahas.id = '$bahas_id' LIMIT 1";
	
		mysql_query($qry,$conn) or die(mysql_error());
		$msg = "<br /><center>Jawapan Akhir telah disimpan.<br />";
		echo $msg;
		echo "<br><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a>";
		}
		
		if($_POST['SimpanHantarJawapanAkhirBahas'])
		{
		$bahas_id = $_POST['bahas_id'];
		$status_bahas = $_POST['status_bahas'];
		$korperat_nama = $_SESSION['nama'];
		$korperat_jawatan = $_SESSION['jawatan'];
		$jawapan = $_POST['Jawapan_Final'];
		$catatan = $_POST['Catatan_Final'];
		$korperat_tambahan = $_POST['Korperat_Tambahan'];

		$perkara = getInfo("sesi_bahas", $bahas_id,"tajuk");
		$subject = $nama_sistem." : ".$perkara."\n";
		$url = $link_bahas.$bahas_id; 	
		$message = "Sila klik URL untuk maklumat lanjut\n\n$url";

		$qry = "UPDATE sesi_bahas SET korperat_nama = '$korperat_nama',korperat_jawatan = '$korperat_jawatan',
				jawapan = '$jawapan', korperat_tambahan = '$korperat_tambahan', catatan_final = '$catatan',
				status = 9, status_bahas='$status_bahas'
				WHERE sesi_bahas.id = '$bahas_id' LIMIT 1";
	
		mysql_query($qry,$conn) or die(mysql_error());
		
			$cat = $keyword[22];
	//echo $cat;
		if($msg = sendTeksAkhir($conn,$cat,$subject,$message)){
			echo "<center><font class=subheader1><br/> Emel telah dihantar kepada</font><br/><br/>";
			echo $msg."</center><br>";
		}

		$msg = "<br /><center>Jawapan Akhir telah disimpan.<br />";
		echo $msg;
		echo "<br><a href=\"index.php?action=detailsbahas&id=".$bahas_id."\">kembali semula</a>";
	}
	
} ?>