
<script language="javascript" type="text/javascript">

function edit_pppb()

{
var td_pindapppb = document.getElementById("pindapbb"); 
var td_hantarpppb = document.getElementById("hantarpppb"); 
td_pindapppb.style.display = '';
td_hantarpppb.style.display = '';

}
function Radiomk(val)
{
var tr_pindamk = document.getElementById("pindamk");
var td_pindahref= document.getElementById("pindahref");
var td_simpanmk= document.getElementById("simpanmk");
//var tr_semakksp = document.getElementById("semakksp");

	if (val=="1"){
	detail.mk_Status2.checked=false;
	tr_pindamk.style.display = '';
	td_pindahref.style.display = 'none';
	td_simpanmk.style.display = '';
	//tr_semakksp.style.display = 'none';
	
	}
	
	if (val=="2"){
	detail.mk_Status1.checked=false;
	tr_pindamk.style.display = 'none';
	td_pindahref.style.display = '';
	//tr_semakksp.style.display = '';
	td_simpanmk.style.display = 'none';
	
	}
}
</script>


<?php	
session_start();
include("qry_comfirm.php");
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
	
	$isMK= checkOfficer($_SESSION['userid'],5,$conn);
	//echo "status ler".$isMK;
	$edit = checkModulList($conn,"modul1",$_SESSION['userid']);
	//echo "cc".$edit;
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
	
	$qry = "SELECT parlimen.status,parlimen.sesi_dewan,parlimen,penggal,mesyuarat,nama_pppb,jawatan_pppb,no_soalan,tarikh_pppb,
			tkh_mula_bersidang,tkh_akhir_bersidang,ahli_parlimen.nama AS nama_yb,agensi,	
			kawasan.nama as kawasan,negeri.nama as negeri,bentuk_soalan,no_soalan,soalan, parti.nama_pendek as parti,parlimen.tkh_bentang_jawapan,
			parlimen.tkh_jawab, parlimen.perkara, penyemak,penyemak2, 
			pengurusan_nama, pengurusan_jawatan, pengurusan_tarikh,pengurusan_catatan, pengesahan_nama, pengesahan_jawatan,
			pengesahan_tarikh,pengesahan_catatan, korperat_nama,korperat_jawatan,catatan_pppb,
			korperat_tarikh,korperat_jawapan,korperat_tambahan,created_by,created_on,parlimen.salinan FROM parlimen
			LEFT JOIN negeri ON negeri.id = parlimen.negeri 
			LEFT JOIN kawasan ON kawasan.id = parlimen.kawasan_id
			LEFT JOIN ahli_parlimen ON parlimen.ahli_dewan_id = ahli_parlimen.id
			LEFT JOIN parti ON parti.id = parlimen.parti_id
			WHERE parlimen.id ='$id'" ;
			
	$result = mysql_query($qry,$conn) or die(mysql_error());
	//echo $qry ;
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	$status_pinda=$row['status'];
	$status_urus = $status;
	$status_sah = $status;
	$penyemak = $row['penyemak'];
	$penyemak2 = $row['penyemak2'];
	$bentuk_soalan = $row['bentuk_soalan'];
	$agensiarea=$row['agensi'];
	$question=$row['no_soalan'];
	//$_SESSION['no_soalan'] = $row['no_soalan'];
	//$_SESSION['perkara'] = $row['perkara'];
	//echo "lalal".$_SESSION['no_soalan'].$_SESSION['perkara'];
		
	if($bentuk_soalan=="Lisan"){
		$pdf = "fpdf_parlimen2.php";
		//$pdf = "fpdf_parlimen.php";
		if($isPegawai && ($status <> 9)){
		//$pdf = "fpdf_parlimen_agensi.php";
		//$pdf = "fpdf_parlimen2_agensi.php"; asal pad 18022010
		$pdf = "fpdf_parlimen2.php";
		}
		}
	else {
		$pdf = "fpdf_parlimen2.php";
		if($isPegawai && ($status <> 9)){
		//$pdf = "fpdf_parlimen2_agensi.php"; asal pada 18022010
		$pdf = "fpdf_parlimen2.php";
		}
	}
	$jawapan = $row['korperat_jawapan'];
	$maklumat_tamb = $row['korperat_tambahan'];
	
	//if(!empty($row['korperat_tambahan']))
		//$jawapan .= "<br><br><b>Maklumat Tambahan</b></br><br><br>".$row['korperat_tambahan'];		
	
	$soalan = stripslashes($row['soalan']);

?>
<!--jamlee edit-->
<br />
<div style="width:300px; background-color:#CCCCFF; text-align:right; padding:3; float:right;">
	<strong>Status:<?php echo $doc_status[$status]?></strong><br>
	Tarikh Jawab Soalan Di Parlimen: <?php echo Reverse($row['tkh_bentang_jawapan']) ?><br>
	Jawapan hendaklah sampai ke YB MKII sebelum : <?php echo Reverse($row['tkh_jawab'])?></div>
<style type="text/css">
<!--
.style3 {color: #0066CC; font-weight: bold; }
.style5 {color: #0099CC; font-weight: bold; }
.style25 {color:#FF0000; font-weight: bold; }
-->
</style>
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
 //echo "statusler".$status;
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
<form name="detail" method="post"   >
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
		<!--<tr><td width=204>Nama Y.B</td><td width=7>:</td><td colspan=4><?php echo $row['nama_yb'] ?></td></tr>-->
		<?php
		if($sesi=='2'){
		?>
		<tr>
		  <td>No. Soalan</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['no_soalan']?></td>
	  </tr>
		<tr>
		  <td>Negeri</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['negeri'] ?></td>
		</tr>
		<?php }?>
		<tr><td width=204>Nama Y.B</td><td width=7>:</td><td colspan=4><?php echo $row['nama_yb'] ?></td></tr>

		<tr><td width=204>Wakil</td><td width=7>:</td><td colspan=4><?php echo $wakil; ?></td></tr>
		
		<?php 
		if($isHEK || $isPegawai || $isPengurusan ||$isSub || $isKSP ||$isMK )
		{ ?>
		<tr>
		  <td width=204>Tarikh  Jawab Soalan Di Parlimen</td>
		  <td width=7>:</td>
		<td colspan=4><?php echo Reverse($row['tkh_bentang_jawapan']) ?></td></tr>
			<?php } ?>
		<tr><td width=204><strong>Perkara </strong></td>
	    <td width=7>:</td><td colspan=4 bgcolor="FFFFFF"><?php echo $row['perkara']?></td>
		</tr>
		<tr>
		  <td width=204 valign=top><strong>Soalan</strong></td>
		  <td valign="top" width=7>:</td>
		 <td colspan="4">
		  	
			 <?php createRTF($sBasePath, 'Soalan', $soalan);?>		  </td>
		</tr>
		
		<!--<tr>
		  <td><strong>Lampiran</strong></td>
		  <td>:</td>
		  <td colspan=4><?php //display the attachments if any	
		//$qry = "SELECT * FROM soalan_lampiran WHERE parlimen_id='$id'";
		//$res = mysql_query($qry,$conn);
		//while($row2 = mysql_fetch_array($res)){
			//$nama_fail = $row2['nama_fail'];
			//$path = "../parlimen/lampiran/$nama_fail";
			//echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";
		//}
		?></td>
	  </tr>-->
		<tr><td width=204>Jawapan hendaklah sampai ke YB MKII sebelum</td>
	  <td width=7>:</td><td colspan=4><?php echo Reverse($row['tkh_jawab']) ?></td></tr>
		<tr><td width=204>Untuk Tindakan </td>
		<td width=7>:</td><td colspan=4><?php echo displayAgensi($row['agensi'],$conn) ?></td></tr>
		
		<!--<tr>
		  <td width=204>Semakan Peringkat TKSP </td>
		  <td width=7>:</td><td colspan=4><?php echo $penyemak ?></td>
		</tr>
		<tr>
		  <td width=204>Semakan KSP </td>
		  <td width=7>:</td><td colspan=4><?php echo  $penyemak2 ?></td>
		</tr>-->
</table>
</fieldset>
<p>
  <?php if ($status ==25) { //akan dipaparkan bila status =25(soalan dipulangkan semula) 
?>
</p>
<p><font color="#27408B"><i>&nbsp;Disediakan oleh <?php echo $row['created_by'] ?> pada <?php echo DisplayDateTime($row['created_on']); ?></i></font></p>
<fieldset class="highlight"><legend width="326px">Jawapan Pegawai Perhubungan Parlimen Bahagian</legend>

<table width="100%" border="0">
  <tr>
    <td width=204>Catatan PPPB</td>
    <td >:<?php echo $row['catatan_pppb'] ?></span></td>
  </tr>
  <tr>
    <td>Nama PPPB</td>
    <td>:<?php echo $row['nama_pppb'] ?></span></td>
  </tr>
  <tr>
    <td>Jawatan PPPB</td>
    <td>:<?php echo $row['jawatan_pppb'] ?></span></td>
  </tr>
  <tr>
    <td>Tarikh PPPB</td>
    <td>:<?php echo date('j-n-Y-g:i:s A', strtotime($row['tarikh_pppb'])); //tukar format tarikh.edit 12/01/2010  ?></span></td>
  </tr>
</table>

</fieldset>
<?php }?>
<br/><br/>

<font color="#27408B"><i>&nbsp;</i></font><br />
<br />

<?php //if($status >1 || $status ==22) asal pada 13/07/2009
if($status >=1 || $status ==22)
{
 ?>
<br />

<?php
//$view = "true";
$header = true;
if(($status_pinda <> 25 )&&($status_pinda <> 1) )
{

//echo "pin".$status_pinda;
include("jawapan_agensi.php"); 
}
//------------------------------------------------------ HEK:3 -------------------------------------------------------------------- 		
//if(!$isPegawai || $isHEK || $isPengurusan ||$isPengesahan)
//{

$penyemak_jwtn = explode("+", $penyemak);
$untuk_semakan = implode(",", $penyemak_jwtn);
?>


<?php 
echo "<br>";
if(($isHEK)|| ($isPegawai) || ($isPengurusan) || ($isKSP) || ($isMK) || ($isSub)) 
{
//include("jawapan_pengurusan.php");

} 
echo "<br>";
            //echo "staff".$isPegawai;
			if(($status==21 || $status==22)&& ($isPegawai || (($isSub) && (!$edit))) && empty($jawapan_agensi)){ 
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
				         if( $status!=22)
						 {
                 echo "<br><a href=\"\" onClick=\"edit_pppb();return(false);\" >[ Hantar Semula Soalan ] </a>";
				  }
}
  elseif($status==15 && ($isPegawai || ($isSub && !$edit))){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			//}
			}elseif($status==18 && ($isPegawai || ( $isSub && !$edit))){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			}
			elseif($status==22&& ($isPegawai || ( $isSub && !$edit))){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";

			}
			
			elseif( $status== 23 && ($isPegawai || ($isSub && !$edit) ) && ($tkh_terima=="") && ($status_agensi==1 || $status_agensi == 0)){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
				
			}
			//elseif(($status==10) && $isPegawai && $editable && ($status_pindaan==0)){
			//elseif(($status==12) && ($isPegawai || ($isSub && (!$edit))) && $editable && ($status_pindaan==0)){ asal pada 18022010
			elseif(($status==12) && ($isPegawai || ($isSub && (!$edit))) &&  ($status_pindaan==0)){

				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			}
	


/*if($isHEK || $isPengurusan ||$isPengesahan || ($isPegawai && $status==9)){?> asal pada 28 jan 2009 */
/*if($isPengesahan || ($isPegawai && $status==9)){?>*/

//********************************************************************start here pada 13/jan/2010
//if(($isPengesahan || ($isKSP && $status==9) || $isPengurusan || ($isPegawai && $status==9) ||($isHEK && $status==9)||($isPegawaiview && $status==9)||($isAngPentadbiran && $status==9))&&($status_pinda <> 25) &&($status_pinda <> 4) 
//&&($status_pinda <> 1) &&($status_pinda <> 21) &&($status_pinda <> 22)  &&($status_pinda <> 12) &&($status_pinda <> 14)){
//echo "statuspinda".$status_pinda."status".$status;
//end here***********************************************************************
if(($isMK && $status==9) || ($isKSP && $status==9) || ($isPengurusan && $status==9) || ($isPegawai && $status==9)||($isHEK && $status==9)||($isPegawaiview && $status==9)
||($isMK && $status==16)  ||($isMK && $status==19) ||$isHEK)////**start code on 4/10/2010 by zaidi base on sop BCP
//if(($isMK))
{//


//if((!$edit) && (!$isPengurusan))	 { ?>   


<fieldset class="<?php echo highlight($status==3|| $status == 4 ||$status == 1 || $status==5||$status==7||$status==8||$status==23) ?>"><legend><b>Jawapan Akhir Diluluskan <?php if(($edit) && (!$isPengurusan)&&($status!=9)){ echo " - Belum Dimasukkan";} ?> </b></legend> 
<div class="sub">
<?php if((($edit) && ($status==9))||(!$edit))	
//if( ($status==9 ) &&  (!$edit) &&  (!$isMK ))
 { ?>  
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
	  <?php 
		if(!empty($jawapan))
		{
		?>
		<tr><td width=215>		  Nama </td> 
		<td width=10>		  :</td>
		<td width="721">		    <?php echo $row['korperat_nama'] ?></td>
		</tr>
		<tr><td width=215>Jawatan</td><td width=10>:</td>
		<td><?php echo $row['korperat_jawatan'] ?></td></tr>
		<tr><td width=215>Tarikh</td><td width=10>:</td>
		<td><?php echo Reverse($row['korperat_tarikh']) ?></td></tr>		
        
		<?php 
		}
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
		<!--<tr><td width=211>Lampiran</td><td width=10>:</td>-->
		<!--<td>-->
			<?php //display the attachments if any				
			/*$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id=0 AND parlimen_id='$id'";
			$res = mysql_query($qry,$conn);
			while($row4 = mysql_fetch_array($res)){
				$nama_fail = $row4['nama_fail']; 
				$path = "../parlimen/lampiran/$nama_fail";
				echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
			}*/
		?>		
		<!--</td></tr>-->
		<?php 
		}
		else if(!$isHEK)////**start code on 4/10/2010 by zaidi base on sop BCP
		{ ?>
		 <?php $nama_sah = $_SESSION['nama'] ?>
			<tr><td width=200>Nama Pegawai</td><td width=10>:</td>
			<td><?php echo stripslashes($nama_sah)?></td></td></tr>
			<tr><td width=200>Jawatan</td><td width=10>:</td>
			<td><?php echo $_SESSION['jawatan'] ?></td></td></tr>
		<tr>
			  <td width=200>
			  Pindaan/Pertanyaan</td>
			  <td width=10>
		      :</td><td width="731">
		        <input type="radio" name="mk_Status1" value="0" onClick="Radiomk(1)">
				<input type="hidden" name="agensik" value="<?php echo $agensiarea; ?>"/>
			  Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			    <input type="radio" name="mk_Status2" value="1" onClick="Radiomk(2)">
			    Tidak</td><td width="26"></td></tr>			
				<tr id="pindamk" style="display:none;" valign="top" >
			      <td width=200>Catatan sekiranya Ada Pindaan </td>
			      <td width=10>:</td>
				  <?php if((!$edit) && (!$isPengurusan)) {?>
			<td><textarea name="akhir_Catatan" rows=6 cols=60><?php //echo //$row2['pengesahan_catatan'] ?></textarea></td></tr>
			<?php }?>
		   <td width=300 id="pindahref" style="display:none;" ><?php  if((!$edit) && (!$isPengurusan))	echo "<br><a href=\"\" onClick=\"edit_final($id);return(false);\" >[ Penyediaan  Jawapan Akhir] </a>";?></td>
		  
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
	}
	
	  /*
		if(($status==3  && $isHEK)||($status==5  && $isHEK)||($status==7  && $isHEK)||($status==10  && $isHEK)||($status==23  && $isHEK)){
			echo "<br><a href=\"\" onClick=\"edit_korperat($id);return(false);\" >[ Semak 1](pengurusan)</a>";		
		}
		
		if(($status==3  && $isHEK)||($status==6  && $isHEK)||($status==7  && $isHEK)||($status==10  && $isHEK)||($status==23  && $isHEK)){
			echo "<br><a href=\"\" onClick=\"edit_pengurusan4($id);return(false);\" >[ Semak 11 ](pengesahan) </a>";		
		}

		*/
		 
		/*if(($status==3  && $isHEK)||($status==6  && $isHEK)||($status==7  && $isHEK)||($status==8 && $isHEK)||($status==10  && $isHEK)||($status==23  && $isHEK )){			
			echo "<br><a href=\"\" onClick=\"edit_final($id);return(false);\" >[ Kemaskini Jawapan Akhir] </a>";
			*/
			if(!empty($jawapan)||empty($jawapan))
		{
		//echo "poning".$status.$status_pinda;
		
		//**start code on 4/10/2010 by zaidi base on sop BCP
		// if(($status_pinda==3  && $isPengesahan)||($status_pinda==6  && $isPengesahan)||($status_pinda==7  && $isPengesahan)||($status_pinda==8 && $isPengesahan)||($status_pinda==10  && $isHEK)||($status_pinda==9  && $isHEK)||($status_pinda==23  && $isPengesahan)
		 // ||($isMK)){	
		  //**end code on 4/10/2010 by zaidi base on sop BCP
		  if($isHEK){	//change on 4/10/2010
		  
		//if(($status==9  && $isHEK)) {	
		//if(($status==3  && $isPengesahan)||($status==6  && $isPengesahan)||($status==7  && $isPengesahan)||($status==8 && $isPengesahan)||($status==10  && $isHEK)||($status==23  && $isPengesahan)  ){	
			//echo "per";
			if((!$edit) && (!$isPengurusan))	
			 
			echo "<br><a href=\"\" onClick=\"edit_final($id);return(false);\" >[ Penyediaan  Jawapan Akhir] </a>";
		}
		}
		
//------------------------------------------------------ Pengurusan:4 -------------------------------------------------------------------- 		
	?>

</div>
</fieldset>


<?php
}
else
//echo "test";
if( (!$isMK) &&($status==16 ||$status==19) )
{
//echo "cc".$status?>

<fieldset class="<?php echo highlight($status==3|| $status == 4 ||$status == 1 || $status==5||$status==7||$status==8||$status=23) ?>"><legend><b>Jawapan Akhir Diluluskan <?php  echo " - Belum Dimasukkan" ; ?> </b></legend> 
<div class="sub">

<?php
echo "</div>"."</fieldset>";
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

// start here on 28 jan 2009
/*if(($isPengesahan || $isPengurusan || $isHEK) && ($status_urus==4|| $status_urus==5|| $status_urus==6|| $status_urus==7 || $status_urus==8 || $status_urus==9))
{ ?>
<br/><br/><br/>
<fieldset class="<?php echo highlight($status_urus==4) ?>"><legend><b>Bahagian Pengurusan</b></legend>
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
  */       //echo "sta".$status_pinda;
       if(($status_pinda==4 || $status_pinda==14) && ($isPengurusan)) { //pengurusan
		//if((($status_pinda==4 ) && ($isPengurusan))){	//pengurusan
			echo "<br><a href=\"\" onClick=\"edit_pengurusan();return(false);\" >[ Semakan Jawapan ] </a>";
		}

       if((($status_pinda==13  || $status_pinda==17) && ($isKSP))){	//pengurusan
			echo "<br><a href=\"\" onClick=\"edit_pengesahan();return(false);\" >[ Semakan Jawapan ] </a>";
		}
		
		 if($isMK){	//pengurusan
			//echo "<br><a href=\"\" onClick=\"edit_pengesahan();return(false);\" >[ jawapan akhir ] </a>";
		//echo "dddd".$isMK;
		}
		
		//echo "dddd".$isMK;
/*		
/*		


//------------------------------------------------------ Pengesahan:6 -------------------------------------------------------------------- 		
		
	?>
</div>
</fieldset>
<?php } */

/*if(($status_sah==6|| $status_sah==7 || $status_sah==8|| $status_sah==9) && ($isPengesahan || $isHEK))
{ ?>
<br/><br/><br/>
<fieldset class="<?php echo highlight($status_sah==6) ?>"><legend><b>Bahagian Pengesahan</b></legend>
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
	//echo $status_sah;
		if((($status_sah == 6) && ($isPengesahan)) && (!$isHEK) && ($isPengurusan) && ($atasan_valid=="true")){	//pengesahan
		
			echo "<br><a href=\"\" onClick=\"edit_pengesahan();return(false);\">[ Pengesahan Jawapan ] </a>";
		}
	?>
</div>
</fieldset>
<?php }  until here on 28 jan 2009*/?> 

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

//if(($sys_acl<3 && $isHEK) && $status==1) {  asal
//echo $sys_acl."sta".$status;
if(($sys_acl<3 && $isHEK) && ($status_pinda==25 ||$status_pinda==1)) {
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
<!--<td>-->
<?php
//if((!$isPegawai && ($status <>0)) || ($isPegawai && ($status == 9)) ){
?>
<!--
<form name="pdf" method="post" action="<?php echo $pdf ?>" target="_blank">
 <input type="submit" value="CETAKAN" class="button"/>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/> 
</form>	<?php //} ?>
</td>-->
<?php // } else {?>

<?php //if(!$isPegawai && ($status <>9)){
//if(($status_pinda <>12  && $isPegawai)||($status_pinda <>9 && $isPegawai))
//echo "statusatas".$status_pinda;
//$status_pinda=15;  

if(($status_pinda!=15) &&($status_pinda!=13)  &&($status_pinda!=9) &&($status_pinda!=14) && ($status_pinda!=18) && ($status_pinda!=19)&& ($status_pinda!=17) && ($status_pinda!=25)  && (!$isPengurusan )&& (!$isKSP) && (!$isMK))
 {
  if(($status_pinda!=12) && (!$isPengurusan )&& (!$isKSP) && (!$isMK)) {
   if(($status_pinda!=22) && (!$isPengurusan )&& (!$isKSP) && (!$isMK)) {
   if(($status_pinda!=4) && (!$isPengurusan )&& (!$isKSP) && (!$isMK)) {
    if(($isPegawai) ||($isSub ) ){
	//if(($isSub )){
///echo  "fff".$status_pinda."peg".$isPegawai
//echo "status".$status_pinda;

 ?> 

<form name="postback" method="post">
<td id="pindapbb" style="display:none;" >
<fieldset><legend><b>Catatan PPPB</b></legend>

<table border=0 width=100%>
<tr>

			 
 <td valign="top" id="pppb_catatan"><textarea name="pppb_catatan" rows=6 cols=60></textarea>            
			  

</tr>
</table>
</fieldset>
</td>
<tr>
<td id="hantarpppb" style="display:none;">
<input type="submit" name="hantar_kembali" value="HANTAR KEMBALI" class="button" onClick="return komfirm()"/>
</form>
</td>
</tr>

<?php }
}
} 
}
}
//}
?>
<td>
<form name="pdf" method="post" action="<?php echo $pdf ?>" target="_blank">
<? if ($status!=0){?>
<input type="submit" value="CETAKAN" class="button"/>
<? }?>
<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="agensi_id" value="<?php echo $isPegawai ?>"/>
</form>
</td>
<?php //} ?>
</td>
<?php //} ?>

<td id="simpanmk" style="display:none;"> 
<form name="drafakhir" method="post"   onSubmit="if(toValidate) return validateFormdrafakhir(this)">
<input type="hidden" name="drafakhirjawapan"/>
<input type="hidden" name="parlimen_id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="agensip" value="<?php echo $agensiarea; ?>"/>
<input type="hidden" name="no_soalan" value="<?php echo $question; ?>"/>
<?php  if((!$edit) && (!$isPengurusan)) {?>
<input  class="button" type="submit" name="SimpanDandrafakhir" value="SIMPAN & HANTAR" onClick="toValidate=true"/>
<?php } ?>
</form>
</td> 
</tr>
</table>
<!-- jamlee edited -->
</body>

