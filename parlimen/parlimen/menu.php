<html>
<head>
<!--script type="text/javascript" src="../parlimen/js/jQuery/jquery-latest.pack.js"></script>
<link rel="stylesheet" href="../parlimen/js/jQuery/jquery.datepick.css" type="text/css" media="screen" charset="utf-8" />

<script type="text/javascript" src="../parlimen/js/jQuery/jquery.datepick.pack.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	//configure the date format to match mysql date
	$('#date').datepick({dateFormat: 'dd-mm-yy'});
});
-->
<script type="text/javascript" src="popcalendar.js"></script>
<script type="text/javascript">
function pilih_carian(val)
{
//alert(val);
if(val=="C4")
{
document.getElementById("carian_2").style.display='';
document.getElementById("carian_1").style.display='none';
document.getElementById("date").value='';
document.getElementById("carian").value='';
document.getElementById('flag_lap').value=val;
}
else if((val=="C3") ||(val=="C2"))
{
document.getElementById("carian_2").style.display='none';
document.getElementById("carian_1").style.display='';
document.getElementById("date").value='';
document.getElementById("carian").value='';
document.getElementById('flag_lap').value=val;
}
else
{
document.getElementById("carian_2").style.display='none';
document.getElementById("carian_1").style.display='none';
}
}


</script>

<?php
//include("query_soalan.php");

function getKeywordpar($category,$default,$conn){
		$qry = "SELECT kod,butiran FROM konfigurasi WHERE kategori = '$category' ORDER BY kod";
		$result = mysql_query($qry,$conn) or die(mysql_error());		
		while($row = mysql_fetch_array($result)){
			$item = $row['butiran'];
			$kod=$row['kod'];
			$selected = ($kod == $default)?"selected":"";
			echo "<option $selected value=".$kod.">".$item."</option>";
		}
		
	}
$cari_par=$_GET['title'];
$cari_tajuk=$_GET['Carian'];

//echo "sdsdsdsd".$_SESSION['userid2'] ;
	function menu($title,$url,$param,$name,$img){			
		$class = ($param == $name)?"highlight":"";
		if($class == "")
			return "<img src=\"$img\"/><a class=\"$class\" href=\"index.php?$url\">$title</a>";			
		else
			return "<img src=\"$img\"/><font class=\"highlight\">$title</font>";
	}
	
	function checkUTSoalJawab($conn,$agensiId,$isPegawai,$isHEK,$isPengurusan,$isBoth,$isKSP,$isMK){
		//Check ada tak list Untuk Tindakan
				
		//in future get butiran from katakunci where kod=KSU
		///////////////start here
	    $findme    = 'pa';
	 $findme2 = array("tksp (p)","tksp (d)","tksp (s&k)","tksp(p)","tksp(d)","tksp (s&k)","tksp (s & k)");
	    // $findme2='tksp (p)';
	  // $findme3    = '(d)';
	   //$findme4    = '&';
	  $ut	= false; 
	$Pegawai_Agensi = $_SESSION['agensi_id'];
	$nama_pegawai = $_SESSION['nama'];
	$Jawatan = $_SESSION['jawatan'];
	$tahun = date('Y');
	
	if($Jawatan == "Ketua Setiausaha")
		$Jawatan = "$Jawatan%";
	else
		$Jawatan = "%$Jawatan%";
		
	$pos1 = stristr($Jawatan, $findme);
	//$pos2= stristr($Jawatan, $findme2);
	//$pos3= stristr($Jawatan, $findme3);
	//$pos4= stristr($Jawatan, $findme4);
	
	//$findme2 = explode(',',$findme2);
	
	//if ($pos1 == false) {
    //echo "The string '$findme' was not found in the string '$mystring1'";
//}

	if ($pos1 != false) {
	

while(list( ,$value) = each($findme2)){
	 $pos2= stristr($Jawatan,$value);
	  if ($pos2 != false)
	 {
	  $Jawatan=$value;
	 $Jawatan = "%$Jawatan%";
	
	 }
}

}

	
	///end here
	
	
	
		if($isPegawai)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.agensi, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen_agensi.status_pindaan  
			FROM parlimen, ahli_parlimen, parlimen_agensi
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
			 AND (parlimen.status = 21 OR parlimen.status=22 OR parlimen.status=15 OR parlimen.status=18 OR ( parlimen.status=12 AND (parlimen_agensi.status = 1 OR parlimen_agensi.status = 0))OR (parlimen.status = 10 AND parlimen_agensi.nama_pegawai='$nama_pegawai' AND parlimen_agensi.status_pindaan=0)) 
			AND parlimen.agensi LIKE '%$Pegawai_Agensi%' AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun'
			 ORDER BY parlimen.id";
			
		elseif($isHEK)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 3 OR parlimen.status=5 OR  parlimen.status = 7 OR parlimen.status=8  OR parlimen.status=25) 
			AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun'
			ORDER BY parlimen.id";
		
		elseif($isPengesahan)	
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6) AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";
	
		elseif($isPengurusan)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 4 
			OR parlimen.status =14 OR parlimen.status =41  OR parlimen.status =42) 
			AND  (parlimen.penyemak LIKE '%+$Jawatan' OR parlimen.penyemak LIKE '$Jawatan+%' OR parlimen.penyemak LIKE '%+$Jawatan+%' OR parlimen.penyemak LIKE '$Jawatan')
			AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY parlimen.id";	
		   
		elseif($isBoth)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6 OR parlimen.status = 4) AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";
		
		elseif($isKSP)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 13 OR parlimen.status =17  OR parlimen.status =43)   
			AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY tkh_bentang_jawapan desc"; 

      elseif($isMK)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status AS status, parlimen.penyemak 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 16 OR parlimen.status =19 )   
			AND YEAR(parlimen.tkh_bentang_jawapan) = '$tahun' ORDER BY tkh_bentang_jawapan desc"; 

   
		//echo $checkUT;
		$rsCheckUT	= mysql_query($checkUT) or die('Error :'.mysql_error()); 
		$numRowsUT	= mysql_num_rows($rsCheckUT);
		
		if($numRowsUT != '0')
			$ut	= true;
		
		return $ut;
	}
	
	//CHECK UTK TINDAKAN BAHAS
	function checkUTBahas($conn,$agensiId,$isPegawai,$isHEK,$isPengurusan,$isPengesahan,$isBoth){
		$ut	= false;
		$Pegawai_Agensi	= $_SESSION['agensi_id'];
		$nama_pegawai	= $_SESSION['nama'];
		$Jawatan		= $_SESSION['jawatan'];
		
		//in future get butiran from katakunci where kod=KSU
		if($Jawatan == "KSP")
			$Jawatan = "$Jawatan%";
		else
			$Jawatan = "%$Jawatan%";		

		if($isPegawai)
			$checkUT = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas, bahas_agensi 
			WHERE sesi_bahas.id=bahas_agensi.main_id 
			AND (sesi_bahas.status = 21 OR sesi_bahas.status=22 OR (sesi_bahas.status=10 AND bahas_agensi.nama_pegawai='$nama_pegawai' AND bahas_agensi.status_pindaan=0)) 
			AND bahas_agensi.agensi_id='$Pegawai_Agensi' ORDER BY sesi_bahas.id";
			
		elseif($isHEK)
			$checkUT = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
			WHERE (sesi_bahas.status = 3 OR sesi_bahas.status=5 OR sesi_bahas.status = 7 OR sesi_bahas.status=8) ORDER BY sesi_bahas.id";
	
		elseif($isPengurusan)
			$checkUT = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
			WHERE (sesi_bahas.status = 4) AND (sesi_bahas.penyemak LIKE '$Jawatan') ORDER BY sesi_bahas.id";
			
		elseif($isPengesahan)	
			$checkUT = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
			WHERE (sesi_bahas.status = 6) AND (sesi_bahas.penyemak LIKE '$Jawatan') ORDER BY sesi_bahas.id";

		elseif($isBoth)
			$checkUT = "SELECT sesi_bahas.id,sesi_bahas.tkh_mula AS Tarikh, sesi_bahas.sesi AS Sesi, sesi_bahas.tajuk AS Tajuk FROM sesi_bahas
			WHERE (sesi_bahas.status = 4 OR sesi_bahas.status = 6) AND (sesi_bahas.penyemak LIKE '$Jawatan') ORDER BY sesi_bahas.id";

		//echo $checkUT;
		$rsCheckUT	= mysql_query($checkUT) or die('Error :'.mysql_error());
		$numRowsUT	= mysql_num_rows($rsCheckUT);
		
		if($numRowsUT != '0')
			$ut	= true;
		
		return $ut;
	}
?>


<?php
	//echo 'pegawai='.$isPegawai = checkACL($_SESSION['userid'],2,$agensiId,$conn);	
	//echo 'hek='.$isHEK = checkOfficer($_SESSION['userid'],3,$conn);	
	//echo 'pengurusan='.$isPengurusan = checkOfficer($_SESSION['userid'],4,$conn);
	//echo 'pengesahan='.$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);
	//echo 'ang ptbir='.$isAngPentadbiran = checkOfficer($_SESSION['userid'],11,$conn);

	$isPegawai = checkACL($_SESSION['userid'],2,$agensiId,$conn);
	$isHEK = checkOfficer($_SESSION['userid'],3,$conn);
	$isPengurusan = checkOfficer($_SESSION['userid'],4,$conn);
	//$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);
	$isKSP = checkOfficer($_SESSION['userid'],8,$conn);
	$isMK = checkOfficer($_SESSION['userid'],5,$conn);
	$isAngPentadbiran = checkOfficer($_SESSION['userid'],11,$conn);

	if($isPengurusan && $isPengesahan)
		$isBoth = true;
?>
</head>
<body>
<table width=100% cellspacing="0" border=1 id="menu"> 
	<tr>
		<td class="level1">Soal Jawab Parlimen</td>
	</tr>
  	<?php
	//if(($isHEK) || ($isPengurusan) || ($isPengesahan) || ($isPegawai)||($isKSP) ||($isMK)){ 
	if(($isHEK) || ($isPengurusan) || ($isPegawai)||($isKSP) ||($isMK)){ ?>
		<tr>
			<td>
				<?php echo menu("Untuk Tindakan","action=list&view=perhatianSoal","perhatianSoal",$_GET['view'],"../images/b4.gif")?>
				<?php if(checkUTSoalJawab($conn,$row2['agensi_id'],$isPegawai,$isHEK,$isPengurusan,$isBoth,$isKSP,$isMK)){?>
					&nbsp;&nbsp;<img src="../images/baru.gif"/>
				<?php }?>
			</td>
		</tr>
  	<?php
	}?>

  	<?php
	if($isHEK)
	{ ?>
	<tr><td>&nbsp;</td></tr>
	<tr><td><?php echo menu("Kemasukan Data","action=newdoc",$_GET['action'],"newdoc","../images/b1.gif")?></td></tr>
	<?php
	}
	 
	
  
	if((!$isHEK) && (!$isPengurusan) && (!$isPengesahan) && (!$isAngPentadbiran)&& (!$isKSP)){  ?> 
		<tr><td>&nbsp;</td></tr>
		<tr>
		  <td class="level2">Laporan</td>
		</tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh Soalan","action=list&view=bydate","bydate",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nombor Soalan","action=list&view=byno","byno",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama Y.B","action=list&view=byyb","byyb",$_GET['view'],"../images/list.gif")?></td></tr>	
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Soalan Lisan","action=list&view=bylisan","bylisan",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Soalan Bertulis","action=list&view=bybertulis","bybertulis",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><?php echo menu("Senarai Jawapan Akhir","action=list&view=byJwpnAkhirSoal","byJwpnAkhirSoal",$_GET['view'],"../images/b1.gif")?></td></tr>
		<tr><td><img src="../images/b1.gif"/><?php $path = "../parlimen/lampiran/manual_agensi-parlimen-v2.1.pdf";
			echo "<a href=\"\" onClick=\"window.open('$path');return(false);\">Download Manual SSJP</a><br>";?></td></tr>
		<!--<tr><td><?php echo menu("Senarai Imbasan Rekod","action=list&view=imbasan","imbasan",$_GET['view'],"../images/b1.gif")?></td></tr>-->
	<?php
	} 
	

	else if($isSUSK_PTTK)
	{ ?>	
	
	<tr><td><?php echo menu("Senarai Jawapan Akhir","action=list&view=byJwpnAkhirSoal","byJwpnAkhirSoal",$_GET['view'],"../images/b1.gif")?></td></tr>
	
	<?php
	}
	
	
	else{?>
		<tr><td>&nbsp;</td></tr>
		<tr>
		  <td class="level2">Laporan</td>
		</tr>
			
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh Soalan","action=list&view=bydate","bydate",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nombor Soalan","action=list&view=byno","byno",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama Y.B","action=list&view=byyb","byyb",$_GET['view'],"../images/list.gif")?></td></tr>
        <tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Bhg /Agensi","action=list&view=byagensi","byagensi",$_GET['view'],"../images/list.gif")?></td></tr>		
        <tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Soalan Lisan","action=list&view=bylisan","bylisan",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Soalan Bertulis","action=list&view=bybertulis","bybertulis",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>
		<?php  if ($isHEK) {?>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Isu","action=laporanbyrequest","laporanrequest",$_GET['action'],"../images/list.gif")?></td></tr>
		                                            
		<?php }?> 
		<tr><td>&nbsp;</td></tr> 
		<!--<tr><td><?php //echo menu("Senarai Draf Jawapan ","action=list&view=bydrafjwp","bydrafjwp",$_GET['view'],"../images/b1.gif")?></td></tr>-->
		<!--<tr><td><?php //echo menu("Senarai Draf Jawapan ","action=list&view=bydrafjwpagen","bydrafjwpagen",$_GET['view'],"../images/b1.gif")?></td></tr>-->
		<tr><td><?php echo menu("Senarai Jawapan Akhir","action=list&view=byJwpnAkhirSoal","byJwpnAkhirSoal",$_GET['view'],"../images/b1.gif")?></td></tr>
		<!--<tr><td><?php echo menu("Senarai Imbasan Rekod","action=list&view=imbasan","imbasan",$_GET['view'],"../images/b1.gif")?></td></tr>-->
  	<?php
	}?>

	<?php
	if($isHEK)
	{ ?>	
	<tr><td>&nbsp;</td></tr>
	<!--<tr><td>
	<?php echo menu("Rekod Imbasan Soal Jawab ","action=olddoc","olddoc",$_GET['action'],"../images/b1.gif")?><br/>
	<?php echo menu("Parlimen","action=olddoc","olddoc",$_GET['action'],"../images/blank.gif")?><br/>
	</td></tr>-->

	<tr><td>
	<?php echo menu("Status Jawapan Pertanyaan","action=laporanStatus","laporanStatus",$_GET['action'],"../images/b1.gif")?><br/>
	</td></tr>	
	
	<!--<tr><td>&nbsp;</td></tr>
	<tr><td>
	<?php //echo menu("Laporan By Request","action=laporanbyrequest","laporanrequest",$_GET['action'],"../images/b1.gif")?><br/>
	</td></tr>-->	
	
	<?php
	}
	?>
    
    
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td class="level1"><img src="../images/search.gif"/>Carian</td>
	</tr>
	<tr> <script language=JavaScript>
	
	         function checktajuk(form)
			 {
			 var tajuk2= document.getElementById('tajuk').value; 
			// alert(document.getElementById("carian").value);
			// alert(document.getElementById("date").value);
			 if((document.getElementById('tajuk').value)=="Sila Pilih")
			 {
			 alert("Sila Pilih Tajuk ")
			 document.getElementById('tajuk').focus()
			 return(false)
			 }
			 
			 /* if((document.getElementById('flag_lap').value=="" ))
			 {
			 alert("Sila Masukkan Katakunci_a")
			 //document.getElementById('carian').focus()
			 return(false)
			 }*/
			 
			 if((document.getElementById('carian').value=="" )&&(document.getElementById('date').value=="" ))
			 {
			 alert("Sila Masukkan Katakunci")
			 //document.getElementById('carian').focus()
			 return(false)
			 }
			   if((document.getElementById('flag_lap').value=="C2" )|| (document.getElementById('flag_lap').value=="C3" ) )
			  
			  {
			  if (document.getElementById('carian').value=="" )
			   {
			    alert("Sila Masukkan Katakunci")
			   return(false)
			   }
			  else
			   {
			    return (true)
			   }
			  }
			  
			   if(document.getElementById('flag_lap').value=="C4" )
			  
			  {
			  if (document.getElementById('date').value=="" )
			   {
			    alert("Sila Masukkan Katakunci")
			   return(false)
			   }
			    else
			   {
			    return (true)
			   }
			  }
			  
			 
			
			 return (true)
	           }
			   
			   
			   
			
	  </script>
	
	
		<td><div>
		  <form name="search" action="redirect.php" method="post" onSubmit="if(checktajuk(this)){return(true)} else {return(false)} ">
		  <br>
		   <select name="tajuk" id="tajuk" onChange="pilih_carian(this.value);">
		   <option value="Sila Pilih">Sila Pilih Tajuk</option>
		  <!-- <option value="2">Tahun Persidangan</option>
		   <option value="3" selected>Pelbagai</option> -->
		   <?php  getKeywordpar("Carian Parlimen",$cari_par,$conn)   ?>
		   </select>
		<!--<input type="text" name="tajuk" class="txt" value="" size="20"/>-->
        <div id="carian_1" <?php if($cari_par=='C2'||$cari_par=='C3' ) {?>style="display:" <?php }else {?>style="display:none"<?php }?> >
        <input type="text" name="Carian" id="carian" class="txt" value="<?php echo $cari_tajuk; ?>" size="20"/>
        </div>
         <div id="carian_2"  <?php if($cari_par=='C4') {?>style="display:" <?php }else {?>style="display:none"<?php }?>>
        <input type="text" name="Date" id="date" class="txt" onClick='popUpCalendar(this, search.Date, "dd/mm/yyyy");return false' value="<?php echo $cari_tajuk; ?>" size="20"/>
        </div>
		 <input type="hidden" name="flag_lap" id="flag_lap" value="<?php echo $cari_par;   ?>">
        <input  type="submit" value="cari" class="button"/>
          <!--<img src="../images/search.gif"/>--> <br />
		  <input name="rekod" type="radio" value="1" <?php if($_GET['rekod'] == 1){?>checked="checked"<?php } ?> />
		  Rekod Lama<br />
		  &nbsp;&nbsp;&nbsp;- <font size="-8" color="#0000CC">Tahun 2008 dan Sebelumnya </font> <br />
		  <input name="rekod" type="radio" value="0" <?php if($_GET['rekod'] == 0 or $_GET['rekod'] == ''){?>checked="checked"<?php } ?>>
		  Rekod Baru<br />
		  &nbsp;&nbsp;&nbsp;- <font size="-8" color="#0000CC">Tahun 2009 dan Selepasnya </font>
		  <!-- <input type="text" name="flag_lap" id="flag_lap" value="<?php echo $cari_par;   ?>">-->
		  <!-- <center><img src="../images/search.gif"/><a href="index.php?action=CarianLengkap">Carian Lengkap</a></center><br /> -->		</form> </div>
		
		  </td>
	</tr>
</table> 
<br>
<!--
<table width=100% cellspacing="0" border=1 id="menu">
	<tr><td class="level1">Daftar Sesi Perbahasan</td></tr>
  	<?php /*
	if(($isHEK) || ($isPengurusan) || ($isPengesahan) || ($isPegawai)){ ?>
		<tr><td class="m_item">
			<?php echo menu("Untuk Tindakan","action=listview&view=perhatian","perhatian",$_GET['view'],"../images/b4.gif")?>
			<?php if(checkUTBahas($conn,$row2['agensi_id'],$isPegawai,$isHEK,$isPengurusan,$isPengesahan,$isBoth)){?>
				&nbsp;&nbsp;<img src="../images/baru.gif"/>
			<?php }?>
		</td></tr>
	<?php } ?>
  	<?php
	if($isHEK)
	{ ?>	<tr><td>&nbsp;</td></tr>
	<tr>
	  <td><?php echo menu("Kemasukan Data","action=RekodBaru","RekodBaru",$_GET['action'],"../images/b1.gif")?></td>
  </tr>
	<?php
	}
	 ?>
  	<?php
	if((!$isHEK) && (!$isPengurusan) && (!$isPengesahan) && (!$isAngPentadbiran)){ ?>
	
		<tr><td>&nbsp;</td></tr>
		<tr><td><?php echo menu("Senarai Jawapan Akhir","action=listbahas&view=byJwpnAkhirBahas","byJwpnAkhirBahas",$_GET['view'],"../images/b1.gif")?></td></tr>
	<?php
	} else{?>
		<tr><td>&nbsp;</td></tr>
		<tr><td class="level2">Senarai Data</td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh","action=listbahas&view=bytarikh","bytarikh",$_GET['view'],"../images/list.gif")?></td></tr>	
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Sesi","action=listbahas&view=bysesi","bysesi",$_GET['view'],"../images/list.gif")?></td></tr>	
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=listbahas&view=bystatus2","bystatus2",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><?php echo menu("Senarai Jawapan Akhir","action=listbahas&view=byJwpnAkhirBahas","byJwpnAkhirBahas",$_GET['view'],"../images/b1.gif")?></td></tr>		
	<?php
	} ?>
	<?php
	if($isHEK)
	{ ?>	<tr>
	  <td><?php echo menu("Laporan Perkara Berbangkit ","action=laporanStatusBahas","laporanStatusBahas",$_GET['action'],"../images/b1.gif")?></td>
	</tr>
	<?php
	}
	*/ ?>
</table>
<br>
-->

</body>
</html>