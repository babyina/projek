<script language="javascript">
	var perkara = 1;
	var jaw = 1;
	var mt = 1;
</script>
<?php
//-------------------------------------------------- VIEW SESI BAHAS --------------------------------------------------------
include("query_bahas.php");
include("../js/FCKeditor/fckeditor.php");

	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	$isPengurusan = checkOfficer($_SESSION['userid'],4,$conn);
	$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);

if($_GET['action']=='detailsbahas' && $_GET['id']){	
	$id = $_GET['id'];
	$qry = "select * from sesi_bahas where id='$id'";
	$result = mysql_query($qry,$conn) or die("error query");
	$row = mysql_fetch_array($result);
	$status = $row['status'];
	$penyemak = $row['penyemak'];
	$TMula = DisplayDate($row['tkh_mula']);		
	$TAkhir = DisplayDate($row['tkh_akhir']);
	$TGulung = DisplayDate($row['tkh_gulung']);
	?>
	<br />
	<div align="right"><font class="fs">Status : <?php echo $doc_status2[$status] ?>&nbsp;&nbsp;&nbsp;</font></div>
	<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div><br/>
	<fieldset><legend><b>Butir-butir Persidangan</b></legend>
	<div class="sub">
	<form method="post" name="bahas_form" action="index.php?id=<?php echo $id ?>&action=newsub">
	<table width="100%" border="0">
		<tr><td width="3%">&nbsp;</td><td width="36%">Tajuk</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $row['tajuk'] ?></td>
		</tr>
		<tr><td width="3%">&nbsp;</td><td width="36%">Sesi Dewan</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $row['sesi'] ?></td>
		</tr>
		<tr><td width="3%">&nbsp;</td><td width="36%">Mesyuarat</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $row['mesyuarat'] ?></td>
		</tr>
		<tr><td width="3%">&nbsp;</td><td width="36%">Penggal</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $row['penggal'] ?></td>
		</tr>
		<tr><td width="3%">&nbsp;</td><td width="36%">Parlimen</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $row['parlimen'] ?></td>
		</tr>
		<tr><td width="3%">&nbsp;</td><td width="36%">Tarikh Mula</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $TMula ?></td>
		</tr>
		<tr><td width="3%">&nbsp;</td><td width="36%">Tarikh Akhir</td>
		<td width="3%">:</td>
		<td width="58%"><?php echo $TAkhir ?></td>
		</tr>
		<?php 
		$isPegawai = checkOfficer($_SESSION['userid'],2,$conn);	
		if(!$isPegawai)
		{ ?>
		<tr><td width="3%">&nbsp;</td><td width="36%">Tarikh Penggulungan/Ucapan Penangguhan</td>
		<td>:</td><td width="58%"><?php echo $TGulung ?></td>
		</tr>
		<?php } ?>
		<tr><td width="3%">&nbsp;</td><td width="36%">Nama Menteri /Timbalan Menteri</td>
		<td>:</td><td width="58%"><?php echo stripslashes($row["menteri"]) ?></td>
		</tr>		
	</table><br/>
		<?php 
		if($sys_acl==1  && $isHEK){?>
		<input type="submit" value="HAPUS" class="button" name="deleteDoc" onClick="return verify()"/>
		<?php
		}
		if($status<3 || ($status==21 || $status==22)){ 
			if($sys_acl<3  && $isHEK){?>
			<input type="submit" value="KEMASKINI" class="button" name="EditBahas" />&nbsp;
			<?php
			}
			if($sys_acl<4  && $isHEK){?>
			<input type="submit" value="PERKARA BERBANGKIT" name="TambahPerkaraBerbangkit" class="button"/>
			<input type="hidden" name="SesiDewan" value="<?php echo $row['sesi'] ?>"/>
			<?php 
			}
		}  ?>
		

	</form>

	<br/>
	<form  name="bahas" method="post" action="index.php?&id=<?php echo $id ?>">
	<div class="box">	
	<?php
		$qry2 = "SELECT ref_no,bahas_id,tajuk,yb,tkh_dibahas,agensi FROM sesi_bahas_detail WHERE bahas_id='$id' ORDER BY tkh_dibahas ASC";
		$result = mysql_query($qry2) or die (mysql_error());
		if(mysql_num_rows($result)>0){
	?>
		&nbsp;<strong>Perkara Berbangkit</strong><br/><br/>
		<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" width="100%">
		<tr bgcolor="#ff66ff"><th>Bil</th><th>Tarikh</th><th>Tajuk</th><th>Agensi</th><?php echo ($sys_acl==1)?"<th>Hapus ?</th>":""?></tr>
	<?php	
			
			while($rows = mysql_fetch_array($result)){
				$agensi = displayAgensiShort($rows['agensi'],$conn);
				$del = $rows['ref_no'];
				$del = ($sys_acl==1)?"<td align=\"center\"><a href='' onClick=\"return deleteDoc($del)\"><img src=\"../images/del.gif\" border=\"0\"></a></td>":"";
				$rcolor = ($i%2)?'#E7EFFF':'#B2DFEE';
				?>			
				<tr bgcolor="<?php echo $rcolor ?>">
				<td align="center"><?php echo ($i+1) ?></td>
				<td align="center"><a href="index.php?action=detailsbahas&cid=<?php echo $rows['ref_no'] ?>"><?php echo DisplayDate($rows['tkh_dibahas']) ?></a></td>
				<td align="center"><?php echo $rows['tajuk'] ?></td><td align="center"><?php echo $agensi ?></td><?php echo $del ?></tr>
				<?php
			$i++;
			}
		?></table></div><br />

	</fieldset>	


<?php if($status >1 && !$isPegawai)
{
 ?>
 <br/><br/>
<fieldset class="<?php echo highlight($status==3||$status==5||$status==7||$status==8) ?>"><legend><b>Hal Ehwal Korperat</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr><td width=231>Nama </td>
		<td width=30>:</td>
		<td width="681"><?php echo $row['korperat_nama'] ?></td>
		</tr>
		<tr><td width=231>Jawatan</td>
		<td width=30>:</td>
		<td><?php echo $row['korperat_jawatan'] ?></td></tr>
		<tr><td width=231>Tarikh</td>
		<td width=30>:</td>
		<td><?php echo DisplayDate($row['korperat_tarikh']) ?></td></tr>
	<?php if($status==4 || $status==5){ ?>		
		<tr>
		  <td width=231>Untuk Semakan</td>
		  <td width=30>:</td>
		  <td><?php echo displaySalinan($penyemak) ?></td>
		</tr>
	  <?php } ?>		
	</table>	
	<?php
		/*
		//NORMAL : tak bypass
		if(($status==3  && $isHEK)||($status==5  && $isHEK)||($status==7  && $isHEK)||($status==22  && $isHEK)||($status==21  && $isHEK)||($status==10  && $isHEK)){
			echo "<br><a href=\"\" onClick=\"edit_korperat_bahas($id);return(false);\" >[ Kemaskini Jawapan ] </a>";
		}
		
		if($status==8 && $isHEK){			
			echo "<br><a href=\"\" onClick=\"edit_final_bahas($id);return(false);\" >[ Kemaskini Jawapan Akhir] </a>";
		}
		*/
		
		// TAK NORMAL : Bypass pengesahan; HEK boleh set status jawapan akhir.
		if(($status==3  && $isHEK)||($status==5  && $isHEK)||($status==7  && $isHEK)||($status==22  && $isHEK)||($status==21  && $isHEK)||($status==10  && $isHEK) || ($status==8 && $isHEK)){
			echo "<br><a href=\"\" onClick=\"edit_final_bahas($id);return(false);\" >[ Kemaskini Jawapan Akhir] </a>";
		}
//------------------------------------------------------ Pengurusan:4 -------------------------------------------------------------------- 		
?>
	<input type="hidden" name="cid" value="<?php echo $cid ?>"/>

</div>
</fieldset>	
<?php
}

// hanya selected pengurusan allowed to edit
$atasan_valid = "false";
$penyemak_jwtn = explode("+", $penyemak);
//echo $_SESSION['jawatan'];
foreach($penyemak_jwtn as $key)
{
	if($key == $_SESSION['jawatan'])
		$atasan_valid = "true";
}



if(($status==4|| $status==5|| $status==6|| $status==7 || $status==8 || $status==9) && !$isPegawai)
{ ?>
<br /><br />
<fieldset class="<?php echo highlight($status==4) ?>"><legend><b>Bahagian Pengurusan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr><td width=235>Nama</td>
		<td width=24>:</td>
		<td width=419><?php echo $row['pengurusan_nama'] ?></td>
		<td width=80>Tarikh</td>
		<td width=11>:</td>
	    <td width="157"><?php echo Reverse($row['pengurusan_tarikh'])?>		  </td><td width="0"></td></tr>		
		<tr><td width=235>Jawatan</td>
		<td width=24>:</td>
		<td colspan=4><?php echo $row['pengurusan_jawatan']?></td></tr>
		<tr>
		  <td>Catatan Pengurusan</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['pengurusan_catatan'] ?></td>
	  </tr>
	<?php if($status==6 || $status==7){ ?>
		<tr>
		  <td>Untuk Semakan</td>
		  <td>:</td>
		  <td colspan=4><?php echo displaySalinan($penyemak) ?> </td>
	  </tr>
	  <?php } ?>	  
	  
	</table>

	<?php
		if(($status==4) && $isPengurusan && ($atasan_valid=="true")){	//pengurusan
			echo "<br><a href=\"\" onClick=\"edit_pengurusan_bahas();return(false);\" >[ Semakan Jawapan ] </a>";
		}
//------------------------------------------------------ Pengesahan:6  ----------------------------------------------------- 		
		
	?>
</div>
</fieldset>
<?php } ?> 

<br/><br/>
<?php
if(($status==6|| $status==7 || $status==8|| $status==9) && ($isPengesahan || $isHEK))
{ ?>
<fieldset class="<?php echo highlight($status==6) ?>"><legend><b>Bahagian Pengesahan</b></legend>
<div class="sub">
	<table border=0 width="100%">
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr><td width=235>Nama</td><td width=24>:</td><td width=418><?php echo $row['pengesahan_nama'] ?></td>
		<td width=81>Tarikh</td>
		<td width=11>:</td><td width="157"><?php echo Reverse($row['pengesahan_tarikh'])?>		  </td><td width="0"></td></tr>
		<tr><td width=235>Jawatan</td><td width=24>:</td><td colspan=4><?php echo $row['pengesahan_jawatan']?></td></tr>
		<tr>
		  <td>Catatan Pengesahan</td>
		  <td>:</td>
		  <td colspan=4><?php echo $row['pengesahan_catatan'] ?></td>
	  </tr>
	</table>

	<?php
		if(($status==6) && $isPengesahan && ($atasan_valid=="true")){	//pengurusan
			echo "<br><a href=\"\" onClick=\"edit_pengesahan_bahas();return(false);\" >[ Pengesahan Jawapan ] </a>";
		}
	?>

</div>
</fieldset>	
<?php } ?> 
	</div>

<input type="hidden" name="del" value=""/>
<input type="hidden" name="bahas_id" value="<?php echo $_GET['id'] ?>"/>
<input type="hidden" name="salinan" value="<?php echo $row['salinan'] ?>"/>
<input type="hidden" name="jawapan_id" value=""/>
<input type="hidden" name="status_id" value=""/>
<div style="visibility:hidden">
  <input type="submit" value="Edit Korperat" name="EditKorperatBahas"/>
	<input type="submit" value="Edit Pengurusan" name="EditPengurusanBahas"/>
	<input type="submit" value="Edit Pengesahan" name="EditPengesahanBahas"/>
    <input type="submit" value="Edit Final" name="EditFinalBahas"/>
    <input type="submit" value="HapusPP" name="deletePP"/>
</div>
	</form>
		
	<?php
	if(mysql_num_rows($result)>0){
			if($sys_acl==1  && $isHEK){
	?>
	<form name="pdf" method="post" action="fpdf_bahas.php" target="_blank">
			<input type="submit" value="CETAKAN PDF" class="button" />
			<input type="hidden" name="id" value="<?php echo $id ?>"/>
	</form>
	<?php
	//echo "<form><a href=\"pdf_bahas.php?id=$id\" target=\"_blank\"><img src=\"../images/pdf.jpg\" />Cetakan PDF</a></form>";
			}
		}
	}
}

//-------------------------------------------------- VIEW PERKARA BERBANGKIT  -----------------------------------------------------


elseif($action=='detailsbahas' && $_GET['cid']){
	$cid = $_GET['cid'];
	$qry = "select * from sesi_bahas,sesi_bahas_detail where sesi_bahas_detail.ref_no='$cid' AND sesi_bahas.id = sesi_bahas_detail.bahas_id";
	$result = mysql_query($qry,$conn) or die(mysql_error());	
	$row = mysql_fetch_array($result);
	$sesi_dewan = $row['sesi'];
	$status = $row['status'];
	$bahas_id = $row['bahas_id'];
	$perkara = $row['perkara'];
	$jwpn = $row['jawapan'];
	$mt = $row['maklumat_tambahan'];
	$id = $row['id'];


	?>
	<br/>
	<form name="perkara_berbangkit" method="post" style="padding:5px">
	<div class="subheader1"><center><img src="../images/dot.gif"/> SESI PERBAHASAN <img src="../images/dot.gif"/></center></div>
	<br>&nbsp;&nbsp;<a href="index.php?action=detailsbahas&id=<?php echo $bahas_id ?>"><font class="fs">>> Kembali ke Butir-butir Persidangan</font></a>

	<br/>


	<div class="box">
	<br/>
	
<fieldset><legend><b>Perkara Berbangkit</b></legend>
<div class="sub">
	<table width="100%" border="0">

<tr><td>&nbsp;&nbsp;</td><td>
<table width="100%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="30%"><?php echo $sesi_dewan=='Dewan Negara'?"Nama Y.B Senator":"Ahli Yang Berhormat" ?></td>
    <td width="2%">:</td>
    <td width="68%"><?php echo $row['yb'] ?></td>
  </tr>
    <tr>
    <td width="30%">Tarikh Dibahas </td>
    <td width="2%">:</td>
    <td width="68%"><?php echo Reverse($row['tkh_dibahas']) ?></td>
    </tr>
	    <tr>
    <td width="30%">Jawab Sebelum/Pada</td>
    <td width="2%">:      </td>
    <td width="68%"><?php echo Reverse($row['tkh_jwb']) ?></td>
  </tr>
      <tr>
      <td>Untuk Tindakan </td>
      <td>:</td>
      <td><?php echo displayAgensi($row['agensi'],$conn) ?></td>
    </tr>
    <tr>
    <td width="30%">Salinan Kepada </td>
    <td width="2%">:</td>
    <td width="68%"><?php echo displaySalinan($row['salinan']) ?></td>
  </tr>
    <tr>
      <td><strong>Tajuk</strong></td>
      <td>:</td>
      <td><?php echo $row['tajuk'] ?></td>
    </tr>
    <tr>
    <td><br />
      <strong>Perkara Yang Dibangkitkan</strong> </td>
    <td>&nbsp;</td>
    <td><br /><a href="" onclick="perkara=collapse(perkara,div_perkara,img_collapse);return false;"><img id="img_collapse" name="img_collapse" src="../images/expand.gif" border="0"/></a></td>
    </tr>
	
	    <tr>
	      <td colspan="3">
		  	<div id="div_perkara" name="div_perkara" style="padding:5px;width:100%;display:none">
			 <?php createRTF($sBasePath, 'Perkara', $perkara);?>
			 </div>		  </td>
	      </tr>
		  
	<?php 
	if(!empty($jwpn))
	{
	?>		  
	    <tr>
    <td>
      <strong>Jawapan	</strong></td>
    <td>&nbsp;</td>
    <td><a href="" onclick="jaw=collapse(jaw,div_jaw,img_collapsej);return false;"><img id="img_collapsej" name="img_collapsej" src="../images/expand.gif" border="0"/></a></td>
    </tr>
    <tr>
      <td colspan="3">
		<div id="div_jaw" name="div_jaw" style="padding:5px;width:100%;display:none">
 			<?php createRTF($sBasePath, 'JawapanHEK', $jwpn);?>	
		</div>		  </td>
          </tr>
	<?php 
	}
 
	if(!empty($mt))
	{
	?>	
    <tr>	
    <td><strong>Maklumat Tambahan	</strong></td>
    <td>&nbsp;</td>
    <td><a href="" onclick="mt=collapse(mt,div_mt,img_collapsemt);return false;"><img id="img_collapsemt" name="img_collapsemt" src="../images/expand.gif" border="0"/></a></td>
    </tr>
		
	      <tr>
	        <td colspan="3">
		  <div id="div_mt" name="div_mt" style="padding:5px;width:100%;display:none">
 			<?php createRTF($sBasePath, 'Tambahan_Butir', $mt);?>	
		</div>			</td>
	        </tr>
	<?php 
	}
	?>
		 <tr>
    <td><strong><br />Lampiran<br /><br /></strong></td>
    <td><br />:</td>
    <td><br /><?php //display the attachments if any	
		$qry = "SELECT * FROM bahas_lampiran WHERE jawapan_id=0 AND bahas_id='$cid'";
		$res = mysql_query($qry,$conn);
		while($row3 = mysql_fetch_array($res)){
			$nama_fail = $row3['nama_fail'];
			$path = "../parlimen/lampiran/$nama_fail";
			echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">$nama_fail</a><br>";
		}
	?></td>
    </tr>
</table>  
</td></tr>
</table>
</div>
</fieldset>
	<?php
	
	$qry2 = "select status from sesi_bahas where id='$bahas_id'";
	$result2 = mysql_query($qry2,$conn) or die("error query");
	$row = mysql_fetch_array($result2);
	$status = $row['status'];
	
	if(($status==1||$status==21||$status==22||$status==10) && $isHEK){ 
	echo "<br/><br/>&nbsp;&nbsp;<input type=\"submit\" name=\"EditPerkaraBerbangkit\" value=\"KEMASKINI\" class=\"button\"/><br/>";
	}
	?>
	<input type="hidden" name="SesiDewan" value="<?php echo $sesi_dewan ?>"/>
	<br />
	</form>	
<?php include("jawapan_agensi_bahas.php"); ?>
<br>

<div style="visibility:hidden">
	<input type="submit" value="Edit Jawapan" name="EditJawapanBahas" />
</div>



<?php } ?>