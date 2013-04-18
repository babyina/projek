<?php	
session_start();
include("../js/FCKeditor/fckeditor.php");
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
	
	function displaySalinan($salinan){
		if($salinan==null) return null;
		$salinan_id = explode("+",$salinan);
		foreach($salinan_id as $key){
			$temp = $temp .$sap . $key;
			$sap = ", ";
		}	
		return $temp;
	}
?>
<script language="javascript">
	var soalan = 1;
	var state_agensi = 1;
	var jaw_hek = 1;
</script>
<?php	
	$id = $_GET['id'];
	
	//----------------------------- get file name - for carian ------------------------------------------------------------------
	//$lampiran_id = $_GET['lampiran'];
	//$query = "SELECT nama_fail FROM parlimen_lampiran WHERE lampiran_id='$lampiran_id'";
	//$re = mysql_query($query,$conn) or die(mysql_error());
	//$row2 = mysql_fetch_array($re);
	//$nama_fail = $row2['nama_fail'];	
	//----------------------------------------------------------------------------------------------------------------------------
	
	$qry = "SELECT parlimen.status,parlimen.sesi_dewan,parlimen,penggal,mesyuarat,
			tkh_mula_bersidang,tkh_akhir_bersidang,ahli_parlimen.nama AS nama_yb,agensi,	
			kawasan.nama as kawasan,negeri.nama as negeri,bentuk_soalan,no_soalan,soalan, parti.nama_pendek as parti,parlimen.tkh_bentang_jawapan,
			parlimen.tkh_jawab, parlimen.perkara, penyemak, 
			pengurusan_nama, pengurusan_jawatan, pengurusan_tarikh,pengurusan_catatan, pengesahan_nama, pengesahan_jawatan,
			pengesahan_tarikh,pengesahan_catatan, korperat_nama,korperat_jawatan,
			korperat_tarikh,korperat_jawapan,korperat_tambahan,created_by,created_on,parlimen.salinan FROM parlimen
			LEFT JOIN negeri ON negeri.id = parlimen.negeri 
			LEFT JOIN kawasan ON kawasan.id = parlimen.kawasan_id
			LEFT JOIN ahli_parlimen ON parlimen.ahli_dewan_id = ahli_parlimen.id
			LEFT JOIN parti ON parti.id = parlimen.parti_id
			WHERE parlimen.id ='$id'" ;
			
	$result = mysql_query($qry,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	$penyemak = $row['penyemak'];
	$bentuk_soalan = $row['bentuk_soalan'];	
	if($bentuk_soalan=="Lisan"){
		$pdf = "fpdf_parlimen.php";
		if($isPegawai){
		$pdf = "fpdf_parlimen_agensi.php";}
		}
	else {
		$pdf = "fpdf_parlimen2.php";
		if($isPegawai){
		$pdf = "fpdf_parlimen2_agensi.php";
		}
	}
	$jawapan = $row['korperat_jawapan'];
	$maklumat_tamb = $row['korperat_tambahan'];
	
	//if(!empty($row['korperat_tambahan']))
		//$jawapan .= "<br><br><b>Maklumat Tambahan</b></br><br><br>".$row['korperat_tambahan'];		
	
	$soalan = stripslashes($row['soalan']);

?>

<br />
<div style="width:250px; background-color:#CCCCFF; text-align:right; padding:3; float:right;">
	<strong>Status:<?php echo $doc_status[$status].$status ?></strong><br>
	Tarikh Soalan Dibentang : <?php echo Reverse($row['tkh_bentang_jawapan']) ?><br>
	Jawab Sebelum/Pada : <?php echo Reverse($row['tkh_jawab'])?>
</div>
<body>
<div class="subheader1"><center><img src="../images/dot.gif"/> SOAL JAWAB PARLIMEN <img src="../images/dot.gif"/></center></div><br/>
<?php 
/* 
if (isset($nama_fail))
{
	echo "<div>";
	echo "&nbsp;&nbsp;&nbsp;<font class=\"fs\">Keputusan carian ditemui dalam fail :</font> <a href=\"lampiran/$nama_fail\">$nama_fail</a>";
	echo "</div>";
}
 
if(isset($lampiran)){
	$query = "SELECT lampiran_id, nama_fail FROM parlimen_lampiran WHERE lampiran_id='6'";
	$result = mysql_query($query,$conn) or die(mysql_error());
	$row = mysql_fetch_array($result);
	$nama_fail = $row['nama_fail'];
	//echo $nama_fail;
	echo "Carian ditemui dalam fail lampiran "."<a href=\"../parlimen/lampiran/".$nama_fail.'">'.$nama_fail."</a><br><br>";
}*/

if($status==0)
	include("view_rekodlama.php");

if($status >0)
{ 
$sesi	= $row['sesi_dewan'];
$area = ($row['sesi_dewan']==1)?$row['kawasan']:$row['negeri'];
$area = empty($area)?"Tiada":$area;
$wakil =empty($row['parti'])?"Tiada":$row['parti'];
$soalan = stripslashes($row['soalan']);
?>

<br>
<form name="detail" method="post">
<fieldset><legend><b>Butir-butir Persidangan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=209><br />Sesi</td><td width=10><br />:</td>
		<td width=752><br />
		  <?php echo ($row['sesi_dewan']==1)?"Dewan Rakyat":"Dewan Negara"; ?></td>
		</tr>
		<tr>
		  <td>  Mesyuarat</td>
		  <td>  :</td>
		  <td>		      <?php echo $row['mesyuarat']?></td>
	  </tr>
		<tr><td width=209>Penggal</td><td width=10>:</td>
		<td width=752><?php echo $row['penggal'] ?></td>
		</tr>
		<tr>
		  <td>Parlimen</td>
		  <td>:</td>
		  <td><?php echo $row['parlimen'] ?></td>
	  </tr>
		<tr>
		  <td width=209>Tarikh Mula Persidangan</td><td width=10>:</td>
		<td width=752><?php echo Reverse($row['tkh_mula_bersidang']) ?></td>
		</tr>
		<tr>
		  <td>Tarikh Akhir Persidangan </td>
		  <td>:</td>
		  <td><?php echo Reverse($row['tkh_akhir_bersidang']) ?></td>
	  </tr>
	</table>
</div>
</fieldset>
<br/><br/>
<fieldset><legend><b>Butir-butir Soalan</b></legend>
	<table border=0 width=100%>
		<tr><td width=204><br />Bentuk Soalan</td><td width=7><br />:</td>
		<td width=401><br />
		  <?php echo $row['bentuk_soalan']?></td>
		<td width=94>&nbsp;</td>
		<td width=19>&nbsp;</td>
		<td width=205>&nbsp;</td>
		</tr>
		<?php
		if($sesi=='1'){
		?>
		<tr>
		  <td>No. Soalan</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['no_soalan']?></td>
	  </tr>
		<tr>
		  <td>Kawasan Parlimen</td>
		  <td>:</td>
		  <td colspan=4><?php echo $area; ?></td>
		</tr>
		<?php }?>
		<tr><td width=204>Nama Y.B</td><td width=7>:</td><td colspan=4><?php echo $row['nama_yb'] ?></td></tr>
		<?php
		if($sesi=='2'){
		?>
		<tr>
		  <td>Negeri</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['negeri'] ?></td>
		</tr>
		<?php }?>
		<tr><td width=204>Wakil</td><td width=7>:</td><td colspan=4><?php echo $wakil; ?></td></tr>
		
		<?php 
		if($isHEK)
		{ ?>
		<tr>
		  <td width=204>Tarikh Soalan Dibentangkan</td>
		  <td width=7>:</td>
		<td colspan=4><?php echo Reverse($row['tkh_bentang_jawapan']) ?></td></tr>
			<?php } ?>
		<tr><td width=204><strong>Perkara </strong></td>
	    <td width=7>:</td><td colspan=4 bgcolor="FFFFFF"><?php echo $row['perkara']?></td></tr>
		<tr>
		  <td width=204 valign=top><strong>Soalan</strong></td>
		  <td valign="top" width=7>:</td>
		 <td colspan="4">
		  	
			 <?php createRTF($sBasePath, 'Soalan', $soalan);?>
		    
		  </td>
		</tr>
		
		<tr>
		  <td><strong>Lampiran</strong></td>
		  <td>:</td>
		  <td colspan=4><?php //display the attachments if any	
		$qry = "SELECT * FROM soalan_lampiran WHERE parlimen_id='$id'";
		$res = mysql_query($qry,$conn);
		while($row2 = mysql_fetch_array($res)){
			$nama_fail = $row2['nama_fail'];
			$path = "../parlimen/lampiran/$nama_fail";
			echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";
		}
		?></td>
	  </tr>
		<tr><td width=204>Jawab Sebelum/Pada</td><td width=7>:</td><td colspan=4><?php echo Reverse($row['tkh_jawab']) ?></td></tr>
		<tr><td width=204>Untuk Tindakan </td>
		<td width=7>:</td><td colspan=4><?php echo displayAgensi($row['agensi'],$conn) ?></td></tr>
		<tr>
		  <td width=204>Salinan Kepada </td>
		  <td width=7>:</td><td colspan=4><?php echo displaySalinan($row['salinan']) ?></td>
		</tr>
	</table>
</fieldset>
<br/><br/>

<font color="#27408B"><i>&nbsp;&nbsp;Disediakan oleh <?php echo $row['created_by'] ?> pada <?php echo DisplayDateTime($row['created_on']); ?></i></font><br />
<br />

<?php if($status >1 || $status ==22)
{
 ?>
<br />

<?php
//$view = "true";
$header = true;
include("jawapan_agensi.php");

//------------------------------------------------------ HEK:3 -------------------------------------------------------------------- 		
//if(!$isPegawai || $isHEK || $isPengurusan ||$isPengesahan)
//{

$penyemak_jwtn = explode("+", $penyemak);
$untuk_semakan = implode(",", $penyemak_jwtn);
?>

<br/><br/>
<?php if($isHEK || $isPengurusan ||$isPengesahan){?>

<fieldset class="<?php echo highlight($status==3||$status==5||$status==7||$status==8) ?>"><legend><b>Hal Ehwal Korperat</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr><td width=215>		  Nama </td>
		<td width=10>		  :</td>
		<td width="721">		    <?php echo $row['korperat_nama'] ?></td>
		</tr>
		<tr><td width=215>Jawatan</td><td width=10>:</td>
		<td><?php echo $row['korperat_jawatan'] ?></td></tr>
		<tr><td width=215>Tarikh</td><td width=10>:</td>
		<td><?php echo Reverse($row['korperat_tarikh']) ?></td></tr>		

		<?php 
		if(!empty($jawapan))
		{
		?>
		<tr valign="top">
		<td width=211>		  <strong>Jawapan</strong></td>
		<td width=10>:</td>
		<td width="721">
			<div class="scroll">
			<?php 
				echo $jawapan;
			?>
			</div>
		</td>
		</tr>
		<tr valign="top">
		<td width=211>		 <strong>Maklumat Tambahan</strong></td>
		<td width=10>:</td>
		<td width="721">
			<div class="scroll">
			<?php 
				echo $maklumat_tamb;
			?>
			</div>
		</td>
		</tr>
		<tr>
		  <td colspan="3">
		  	<div id="div_hek" name="div_hek" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Jawapan_HEK', $jawapan);?>
		    </div>		  </td>
	  </tr>
		<tr><td width=211>Lampiran</td><td width=10>:</td>
		<td>
			<?php //display the attachments if any				
			$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row4 = mysql_fetch_array($res)){
				$nama_fail = $row4['nama_fail']; 
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}
		?>		</td></tr>
		<?php 
		}
		
		if($status==4 || $status==5){ ?>
		<tr>
		  <td>Untuk Semakan</td>
		  <td>:</td>
		  <td><?php echo displaySalinan($penyemak) ?></td>
	  </tr>
	  <?php } ?>
		<tr><td width=211>&nbsp;</td>
		  <td width=10>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
	</table>
		
	<?php
		/*
		if(($status==3  && $isHEK)||($status==5  && $isHEK)||($status==7  && $isHEK)||($status==10  && $isHEK)||($status==22  && $isHEK)){
			echo "<br><a href=\"\" onClick=\"edit_korperat($id);return(false);\" >[ Semak 1](pengurusan)</a>";		
		}
		
		if(($status==3  && $isHEK)||($status==6  && $isHEK)||($status==7  && $isHEK)||($status==10  && $isHEK)||($status==22  && $isHEK)){
			echo "<br><a href=\"\" onClick=\"edit_pengurusan4($id);return(false);\" >[ Semak 11 ](pengesahan) </a>";		
		}
		*/
		
		if(($status==3  && $isHEK)||($status==6  && $isHEK)||($status==7  && $isHEK)||($status==8 && $isHEK)||($status==10  && $isHEK)||($status==22  && $isHEK )){			
			echo "<br><a href=\"\" onClick=\"edit_final($id);return(false);\" >[ Kemaskini Jawapan Akhir] </a>";
		}
//------------------------------------------------------ Pengurusan:4 -------------------------------------------------------------------- 		
	?>
</div>
</fieldset>

<?php
}

$atasan_valid = "true";
/*
// OPTIONAL : SEKIRANYA PEGAWAI YG SEMAK SOALAN ADALAH MESTI DARIPADA NAMA JAWATAN YG DIISI SEMASA CREATE SOALAN
// atasan_valid = flag utk tentukan sama ada jawatan user yg login sama dengan jawatan pegawai yg perlu semak (bhg pengurusan) soalan
// hanya selected pengurusan allowed to edit
$atasan_valid = "false";
$penyemak_jwtn = explode("+", $penyemak);
//echo $_SESSION['jawatan'];
foreach($penyemak_jwtn as $key)
{
	if($key == $_SESSION['jawatan'])
		$atasan_valid = "true";
}
*/


if(($status==4|| $status==5|| $status==6|| $status==7 || $status==8 || $status==9) && ($isPengesahan || $isPengurusan || $isHEK))
{ ?>
<br/><br/><br/>
<fieldset class="<?php echo highlight($status==4) ?>"><legend><b>Bahagian Pengurusan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=221><br />
		  Nama</td><td width=10><br />
		  :</td><td width=410><br />
		    <?php echo $row['pengurusan_nama'] ?></td><td width=65><br />
		      Tarikh</td><td width=11><br />
		        :</td><td width="130"><br />
		      <?php echo Reverse($row['pengurusan_tarikh']) ?></td><td width="79"></td>
		</tr>		
		<tr><td width=221>Jawatan</td>
		<td width=10>:</td>
		<td colspan=5><?php echo $row['pengurusan_jawatan']?></td></tr>
		<tr>
		  <td>Catatan Pengurusan</td>
		  <td>:</td>
		  <td colspan=5><?php echo $row['pengurusan_catatan']?></td>
	  </tr>
		<?php if($status==6 || $status==7){ ?>
		<tr>	<?php 	if (!($row['pengurusan_tarikh'])){ ?>
		  <td>Untuk Semakan</td>
		  <td>:</td>
		  <td colspan=5><?php echo displaySalinan($penyemak) ?></td>
	  </tr>
	  <?php } }?>	  
	</table><br />

	<?php
		if(($status==4 || $status==7) && ($isPengurusan) && (!$isHEK) && ($atasan_valid=="true")){	//pengurusan
			echo "<br><a href=\"\" onClick=\"edit_pengurusan();return(false);\" >[ Semakan Jawapan ] </a>";
		}
//------------------------------------------------------ Pengesahan:6 -------------------------------------------------------------------- 		
		
	?>
</div>
</fieldset>
<?php } 

if(($status==6|| $status==7 || $status==8|| $status==9) && ($isPengesahan || $isHEK))
{ ?>
<br/><br/><br/>
<fieldset class="<?php echo highlight($status==6) ?>"><legend><b>Bahagian Pengesahan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr><td width=221><br />
		  Nama</td><td width=10><br />
		  :</td><td width=411><br />
		  <?php echo stripslashes($row['pengesahan_nama']) ?></td><td width=66><br />
		    Tarikh</td><td width=10><br />
		      :</td><td width="135"><br />
		    <?php echo Reverse($row['pengesahan_tarikh']) ?></td><td width="73"></td>
		</tr>
		<tr><td width=221>Jawatan</td>
		<td width=10>:</td>
		<td colspan=5><?php echo $row['pengesahan_jawatan']?></td></tr>
		<tr>
		  <td>Catatan Pengesahan</td>
		  <td>:</td>
		  <td colspan=5><?php echo $row['pengesahan_catatan']?></td>
	  </tr>
	</table>

	<?php
		if(($status == 6) && ($isPengesahan) && (!$isHEK) && (!$isPengurusan) && ($atasan_valid=="true")){	//pengesahan
		
			echo "<br><a href=\"\" onClick=\"edit_pengesahan();return(false);\">[ Pengesahan Jawapan ] </a>";
		}
	?>
</div>
</fieldset>
<?php } ?> 

<input type="hidden" name="parlimen_id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="salinan" value="<?php echo $row['salinan'] ?>"/>
<input type="hidden" name="jawapan_id" value=""/>
<input type="hidden" name="status_id" value=""/>
<div style="visibility:hidden">
	<input type="submit" value="Edit Jawapan" name="EditJawapan" />
	<input type="submit" value="Edit Korperat" name="EditKorperat"/>
	<input type="submit" value="Edit Pengurusan" name="EditPengurusan"/>
	<input type="submit" value="Edit Pengurusan4" name="EditPengurusan4"/>
	<input type="submit" value="Edit Pengesahan" name="EditPengesahan"/>
    <input type="submit" value="Edit Final" name="EditFinal"/>
</div>

<?php } } 

echo "<table width=\"200\" border=\"0\">";
echo "<tr>";

if(($sys_acl<3 && $isHEK) && $status==1) {
	//edit
	echo "<td>";
	echo "<input type=\"submit\" value = \"KEMASKINI\" name=\"EditSoalan\" class=\"button\"/>";
	echo "</td>";
	echo "</form>";
}else	
	echo "</form>";	

if($sys_acl==1 && $isHEK){
	echo "<td><form name=\"delete\" method=\"post\" action=\"index.php\" onSubmit=\"return verify()\">";
	echo "<input type=\"submit\" value = \"HAPUS\" name=\"HapusRekod\" class=\"button\"/>";
	echo "<input type=\"hidden\" name=\"id\" value=\"$id\"/>";
	echo "</form><td>";
}

//if(($sys_acl==1 && $isHEK) && $status<>0) { ?>	
<td>
<?php
if(!$isPegawai && ($status<>0)){
?>
<form name="pdf" method="post" action="<?php echo $pdf ?>" target="_blank">
  <input type="submit" value="CETAKAN" class="button"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
</form>	<?php //} ?>
</td>
<?php  } else {?>

<?php //if($isPegawai  && ($status<>0)){?>
<form name="pdf" method="post" action="<?php echo $pdf ?>" target="_blank">
  <input type="submit" value="CETAKAN" class="button"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="agensi_id" value="<?php echo $isPegawai ?>"/>
</form>	<?php //} ?>
</td>
<?php  } ?>
</tr>
</table>

</body>
	
