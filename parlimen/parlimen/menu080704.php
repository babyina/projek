<?php
	function menu($title,$url,$param,$name,$img){			
		$class = ($param == $name)?"highlight":"";
		if($class == "")
			return "<img src=\"$img\"/><a class=\"$class\" href=\"index.php?$url\">$title</a>";			
		else
			return "<img src=\"$img\"/><font class=\"highlight\">$title</font>";
	}
	
	function checkUTSoalJawab($conn,$agensiId,$isPegawai,$isHEK,$isPengurusan,$isPengesahan,$isBoth){
		//Check ada tak list Untuk Tindakan
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
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.agensi, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen_agensi.status_pindaan  
			FROM parlimen, ahli_parlimen, parlimen_agensi
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND parlimen.id=parlimen_agensi.parlimen_id 
			AND (parlimen.status = 21 OR parlimen.status=22 OR (parlimen.status=10 AND parlimen_agensi.nama_pegawai='$nama_pegawai' AND parlimen_agensi.status_pindaan=0))
			AND parlimen.agensi LIKE '%$Pegawai_Agensi%' ORDER BY parlimen.id";
			
		elseif($isHEK)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 3 OR parlimen.status=5 OR parlimen.status = 7 OR parlimen.status=8) ORDER BY parlimen.id";
		
		elseif($isPengesahan)	
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6) AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";
	
		elseif($isPengurusan)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak 
			FROM parlimen, ahli_parlimen 
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 4)  AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";	

		elseif($isBoth)
			$checkUT = "SELECT parlimen.id,parlimen.perkara,DATE_FORMAT(parlimen.tkh_bentang_jawapan,'%d/%m/%Y') AS Tarikh,parlimen. bentuk_soalan AS BentukSoalan,ahli_parlimen.nama AS AhliDewan,
			parlimen.ahli_dewan_id, parlimen.no_soalan AS NoSoalan,parlimen.status, parlimen.penyemak  
			FROM parlimen, ahli_parlimen
			WHERE parlimen.ahli_dewan_id=ahli_parlimen.id AND (parlimen.status = 6 OR parlimen.status = 4) AND (parlimen.penyemak LIKE '$Jawatan') ORDER BY parlimen.id";

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
	$isPengesahan = checkOfficer($_SESSION['userid'],5,$conn);
	$isAngPentadbiran = checkOfficer($_SESSION['userid'],11,$conn);

	if($isPengurusan && $isPengesahan)
		$isBoth = true;
?>

<table width=100% cellspacing="0" border=1 id="menu">
	<tr>
		<td class="level1">Soal Jawab Parlimen</td>
	</tr>
  	<?php
	if(($isHEK) || ($isPengurusan) || ($isPengesahan) || ($isPegawai)){ ?>
		<tr>
			<td>
				<?php echo menu("Untuk Tindakan","action=list&view=perhatianSoal","perhatianSoal",$_GET['view'],"../images/b4.gif")?>
				<?php if(checkUTSoalJawab($conn,$row2['agensi_id'],$isPegawai,$isHEK,$isPengurusan,$isPengesahan,$isBoth)){?>
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
	 ?>
	
  	<?php
	if((!$isHEK) && (!$isPengurusan) && (!$isPengesahan) && (!$isAngPentadbiran)){ ?>
		<tr><td>&nbsp;</td></tr>
		<tr><td class="level2">Senarai Data</td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh Soalan","action=list&view=bydate","bydate",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nombor Soalan","action=list&view=byno","byno",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama Y.B","action=list&view=byyb","byyb",$_GET['view'],"../images/list.gif")?></td></tr>	
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><?php echo menu("Senarai Jawapan Akhir","action=list&view=byJwpnAkhirSoal","byJwpnAkhirSoal",$_GET['view'],"../images/b1.gif")?></td></tr>
		<tr><td><?php echo menu("Senarai Imbasan Rekod","action=list&view=imbasan","imbasan",$_GET['view'],"../images/b1.gif")?></td></tr>
	<?php
	} else{?>
		<tr><td>&nbsp;</td></tr>
		<tr><td class="level2">Senarai Data</td></tr>
			
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Tarikh Soalan","action=list&view=bydate","bydate",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nombor Soalan","action=list&view=byno","byno",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Nama Y.B","action=list&view=byyb","byyb",$_GET['view'],"../images/list.gif")?></td></tr>
		<tr><td><img src="../images/blank.gif"/><?php echo menu("Mengikut Status","action=list&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr>
		<!-- <tr><td><img src="../images/blank.gif"/><?php echo menu("Test View Baru","action=listRizal&view=bystatus","bystatus",$_GET['view'],"../images/list.gif")?></td></tr> -->
		<tr><td>&nbsp;</td></tr>
		<tr><td><?php echo menu("Senarai Jawapan Akhir","action=list&view=byJwpnAkhirSoal","byJwpnAkhirSoal",$_GET['view'],"../images/b1.gif")?></td></tr>
		<tr><td><?php echo menu("Senarai Imbasan Rekod","action=list&view=imbasan","imbasan",$_GET['view'],"../images/b1.gif")?></td></tr>
  	<?php
	}?>

	<?php
	if($isHEK)
	{ ?>	
	<tr><td>&nbsp;</td></tr>
	<tr><td>
	<?php echo menu("Rekod Imbasan Soal Jawab ","action=olddoc","olddoc",$_GET['action'],"../images/b1.gif")?><br/>
	<?php echo menu("Parlimen","action=olddoc","olddoc",$_GET['action'],"../images/blank.gif")?><br/>
	</td></tr>

	<tr><td>
	<?php echo menu("Status Jawapan Pertanyaan","action=laporanStatus","laporanStatus",$_GET['action'],"../images/b1.gif")?><br/>
	</td></tr>	
	<?php
	}
	?>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td>
		<form name="search" action="redirect.php" method="post">	
			<div>
				<input type="text" name="Carian" class="txt" value="" size="20"/>
				<img src="../images/search.gif"/>
				<br /><input name="rekod" type="radio" value="1" <?php if($_GET['rekod'] == 1){?>checked="checked"<?php } ?> /> Rekod Lama<br />&nbsp;&nbsp;&nbsp&nbsp;- <font size="-8" color="#0000CC">Tahun 2008 Ke Bawah</font> 		
				<br /><input name="rekod" type="radio" value="0" <?php if($_GET['rekod'] == 0 or $_GET['rekod'] == ''){?>checked="checked"<?php } ?>  /> Rekod Baru<br />&nbsp;&nbsp;&nbsp&nbsp;- <font size="-8" color="#0000CC">Tahun 2009 Ke Atas</font>
			</div>
		<!-- <center><img src="../images/search.gif"/><a href="index.php?action=CarianLengkap">Carian Lengkap</a></center><br /> -->
		</form>
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
	*/?>
</table>
<br>
-->