<?php	

	function displayAgensi($agensi,$conn){
		if($agensi==null) return null;
		$agensi_id = explode("+",$agensi);
		$where =  "id=" . implode(" OR id=",$agensi_id);
		$qry = "SELECT nama FROM agensi WHERE ".$where;
		$result = mysql_query($qry,$conn);
		$temp;
		while($row = mysql_fetch_array($result)){
			$temp = $temp .$sap . $row['nama'];
			$sap = ", ";
		}
		return $temp;
	}
	
	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	$isPengurusan = checkOfficer($_SESSION['userid'],4,$conn);
	$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);
	
	$id = $_GET['id'];
	$qry = "SELECT parlimen.status,parlimen.sesi_dewan,parlimen,penggal,mesyuarat,
			tkh_mula_bersidang,tkh_akhir_bersidang,
			ahli_parlimen.nama AS nama_yb,agensi,	
			kawasan.nama as kawasan,bentuk_soalan,no_soalan,soalan, 
			parti.nama_pendek as parti,parlimen.tkh_bentang_jawapan, parlimen.jawapan, parlimen.perkara, 
			pengurusan_nama, pengurusan_jawatan, pengurusan_tarikh,pengurusan_catatan, pengesahan_nama, pengesahan_jawatan,
			pengesahan_tarikh,pengesahan_catatan, korperat_nama,korperat_jawatan,
			korperat_tarikh,korperat_jawapan,korperat_tambahan,parlimen.salinan FROM parlimen
			LEFT JOIN kawasan ON kawasan.id = parlimen.kawasan_id
			LEFT JOIN ahli_parlimen ON parlimen.ahli_dewan_id = ahli_parlimen.id
			LEFT JOIN parti ON parti.id = parlimen.parti_id
			WHERE parlimen.id ='$id'" ;
			
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];	
	
	if($status==9)
		$jawapan = $row['jawapan'];
	else
		$jawapan = $row['korperat_jawapan'];
	
?>
<div align="right">Status : <?php echo $status ?> </div>
<div style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin-top:10px;height:40px"><img src="../images/dot.gif"/>SOAL JAWAB PARLIMEN<img src="../images/dot.gif"/></div>

<form name="detail" method="post">
<fieldset><legend><b>Butir-butir Persidangan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=120>Sesi</td><td width=5>:</td><td width=250><?php echo ($row['sesi_dewan']==1)?"Dewan Rakyat":"Dewan Negara"; ?></td><td width=120>Mesyuarat</td><td width=5>:</td><td><?php echo $row['mesyuarat']?></td></td></tr>
		<tr><td width=120>Penggal</td><td width=5>:</td><td width=250><?php echo $row['penggal'] ?></td><td width=120>Parlimen</td><td width=5>:</td><td><?php echo $row['parlimen'] ?></td></td></tr>
		<tr><td width=120>Tarikh Persidangan</td><td width=5>:</td><td width=250><?php echo $row['tkh_mula_bersidang']?></td>
		<td width=120>Hingga</td><td width=5>:</td><td width=250><?php echo $row['tkh_akhir_bersidang']?></td></td></tr>
	</table>
</div>
</fieldset>
<br/>
<fieldset><legend><b>Butir-butir Soalan</b></legend>
	<table border=0 width=100%>
		<tr><td width=120>Bentuk Soalan</td><td width=5>:</td>
		<td width=250><?php echo $row['bentuk_soalan']?></td>
		<td width=120>No. Soalan </td><td width=5>:</td>
		<td><?php echo $row['no_soalan']?></td></tr>
		<tr><td width=120>Kawasan Parlimen</td><td width=5">:</td><td colspan=4><?php echo $row['kawasan']?></td></tr>
		<tr><td width=120>Nama Y.B</td><td width=5">:</td><td colspan=4><?php echo $row['nama_yb'] ?></td></tr>
		<tr><td width=120>Wakil</td><td width=5">:</td><td colspan=4><?php echo $row['parti'] ?></td></tr>
		<tr><td width=120>Tarikh Jawapan Dibentang</td><td width=5">:</td>
		<td colspan=4><?php echo $row['tkh_bentang_jawapan'] ?></td></tr>
		<tr><td width=120>Perkara</td><td width=5">:</td><td colspan=4><?php echo $row['perkara']?></td></tr>
		<tr><td width=120 valign=top>Soalan</td><td valign="top" width=5">:</td><td colspan=4><?php echo $row['soalan']?></td></tr>
		<tr><td width=120>Untuk Tindakan (Jabatan/Agensi)</td><td width=5">:</td><td colspan=4><?php echo displayAgensi($row['agensi'],$conn) ?></td></tr>
		<tr><td width=120>Salinan </td><td width=5">:</td><td colspan=4><?php echo $row['salinan']; ?></td></tr>
	</table>
</fieldset>
<br/>

<?php if($status >1){ ?>

<div>Jawapan Agensi</div>
<?php include("jawapan_agensi.php") 
//------------------------------------------------------ HEK:3 -------------------------------------------------------------------- 		

?>

<br/>

<fieldset class="<?php echo highlight($status==3||$status==5||$status==7||$status==8) ?>"><legend><b>Hal Ehwal Korperat</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=120>Nama </td><td width=5>:</td><td><?php echo $row['korperat_nama'] ?></td></tr>
		<tr><td width=120>Jawatan</td><td width=5>:</td><td><?php echo $row['korperat_jawatan'] ?></td></tr>
		<tr><td width=120>Tarikh</td><td width=5>:</td><td><?php echo $row['korperat_tarikh']?></td></tr>		
	</table>
	<table border=0 width="100%">
		<tr><td width=120>Jawapan</td><td width=5>:</td><td><?php echo $jawapan ?></td></tr>
		<tr><td width=120>Maklumat Tambahan</td><td width=5>:</td><td><?php echo $row['korperat_tambahan'] ?></td></tr>
		<tr><td width=120>Lampiran</td><td width=5>:</td><td>
		<?php //display the attachments if any				
		$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id=$id";
		$res = mysql_query($qry,$conn);
		while($row4 = mysql_fetch_array($res)){
			$nama_fail = $row4['nama_fail'];
			echo "<a href=\"lampiran/$nama_fail\">$nama_fail</a>&nbsp;&nbsp;<br>";
		}
		?>
		</td></tr>
	</table>	
	<?php
		if(($status==3  && $isHEK)||($status==5  && $isHEK)||($status==7  && $isHEK)||($status==2  && $isHEK)||($status==10  && $isHEK)){
			echo "<a href=\"\" onClick=\"edit_korperat($id);return(false);\" >[ Edit Jawapan ] </a>";
		}
		
		if($status==8 && $isHEK){			
			echo "<a href=\"\" onClick=\"edit_final($id);return(false);\" >[ Edit Jawapan Akhir] </a>";
		}
//------------------------------------------------------ Pengurusan:4 -------------------------------------------------------------------- 		
	?>
</div>
</fieldset>

<br/>
<fieldset class="<?php echo highlight($status==4) ?>"><legend><b>Bahagian Pengurusan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=120>Nama</td><td width=5>:</td><td width=250><?php echo $row['pengurusan_nama'] ?></td><td width=120>Tarikh</td><td width=5>:</td><td><?php echo $row['pengurusan_tarikh']?></td></td></tr>		
		<tr><td width=120>Jawatan</td><td width=5>:</td><td colspan=2><?php echo $row['pengurusan_jawatan']?></td></tr>
	</table>
	<table border=0 width="100%">
		<tr><td width=120>Catatan</td><td width=5>:</td><td><?php echo $row['pengurusan_catatan']?></td></tr>
	</table>
	<?php
		if($status==4 && $isPengurusan){	//pengurusan
			echo "<a href=\"\" onClick=\"edit_pengurusan();return(false);\" >[ Edit Jawapan ] </a>";
		}
//------------------------------------------------------ Pengesahan:6 -------------------------------------------------------------------- 		
		
	?>
</div>
</fieldset>

<br/>
<fieldset class="<?php echo highlight($status==6) ?>"><legend><b>Bahagian Pengesahan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=120>Nama</td><td width=5>:</td><td width=250><?php echo $row['pengesahan_nama'] ?></td><td width=120>Tarikh</td><td width=5>:</td><td><?php echo $row['pengesahan_tarikh']?></td></td></tr>
		<tr><td width=120>Jawatan</td><td width=5>:</td><td colspan=2><?php echo $row['pengesahan_jawatan']?></td></tr>
	</table>
	<table border=0 width="100%">		
		<tr><td width=120>Catatan</td><td width=5>:</td><td><?php echo $row['pengesahan_catatan']?></td></tr>
	</table>
	<?php
		if($status==6 && $isPengesahan){	//pengurusan
			echo "<a href=\"\" onClick=\"edit_pengesahan();return(false);\" >[ Edit ] </a>";
		}
	?>
</div>
</fieldset>

<input type="hidden" name="parlimen_id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="salinan" value="<?php echo $row['salinan'] ?>"/>
<input type="hidden" name="jawapan_id" value=""/>
<input type="hidden" name="status_id" value=""/>
<div style="visibility:hidden">
	<input type="submit" value="Edit Jawapan" name="EditJawapan" />
	<input type="submit" value="Edit Korperat" name="EditKorperat"/>
	<input type="submit" value="Edit Pengurusan" name="EditPengurusan"/>
	<input type="submit" value="Edit Pengesahan" name="EditPengesahan"/>
    <input type="submit" value="Edit Final" name="EditFinal"/>
</div>
<?php } else {
	//edit
	echo "<input type=\"submit\" value = \"EDIT\" name=\"EditSoalan\" />";
}
?>
</form>

<!--<form name="pdf" method="post" action="fpdf_parlimen.php" target="_blank">-->
<form name="pdf" method="post" action="fpdf_parlimen2.php" target="_blank">		
<img src='../images/pdf.jpg'/><input type="submit" value="Cetakan PDF" class="pdf"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
</form>	
<!--jamlee edit-->
