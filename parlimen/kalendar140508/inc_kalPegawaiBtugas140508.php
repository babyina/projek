<?php 
// inc_kalPegawaiBtugas.php adalah fail include yg memaparkan takwim (jadual) pegawai bertugas semasa persidangan.


if(!$id) echo "";
else{
if($_GET['action']=='detailsKal' || $_GET['action']=='newdocKal'){
	$dewan 		= $_GET['dwn'];
	if(!isset($dewan)){
		$countBelum	= lookup($conn, "kal_pegawaitugas", "COUNT(Kal_pegawaiTugas_id)", "Kal_mesyuarat_id='$id' AND Maklum_email='0'");
	}
	else{
		$countBelum	= lookup($conn, "kal_pegawaitugas", "COUNT(Kal_pegawaiTugas_id)", "Kal_mesyuarat_id='$id' AND Maklum_email='0' AND Dewan='$dewan'");
	}
	
	$sqlBelum	= "SELECT DISTINCT PegawaiBtugas,Agensi
					FROM 
						kal_pegawaitugas 
					WHERE 
						Kal_mesyuarat_id='$id'
						AND Maklum_email='0'
						AND PegawaiBtugas IS NOT NULL ";
	if(!empty($dewan)){
		$sqlBelum	.= "AND Dewan='$dewan'";
	}
	$sqlBelum	.= "ORDER BY PegawaiBtugas";
	
	$rsBelum	= mysql_query($sqlBelum);
	$countBelum	= mysql_num_rows($rsBelum);
	
	?>
	
	<script language="JavaScript" type="text/JavaScript">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ //v3.0
		  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		  if (restore) selObj.selectedIndex=0;
		}
		//-->
	</script>
	<br>	

	<table width=100% style="border-color:#C0C0C0" border="0" >
		<tr>
			<td align="left">Dewan 
				<select name="select" onChange="MM_jumpMenu('parent',this,0)">
				  <option value="index.php?action=detailsKal&id=<?php echo $id; ?>" <?php if($dewan=='') echo " selected" ?>>Semua</option>
				  <option value="index.php?action=detailsKal&id=<?php echo $id; ?>&dwn=rakyat" <?php if($dewan=='rakyat') echo " selected" ?>>Rakyat</option>
				  <option value="index.php?action=detailsKal&id=<?php echo $id; ?>&dwn=negara" <?php if($dewan=='negara') echo " selected" ?>>Negara</option>
				</select>
			</td>
		  <td align="right">
		  <?php if(($sys_acl!=3 || $sys_acl!=4 || $sys_acl!=5) || ($isCalHek)){?>
			<!-- <a href="Javascript:NewWindow('KalBelumMaklum.php?id=<?php echo $id; ?>&plm=<?php echo $parlimen; ?>&pgl=<?php echo $penggal; ?>&msyt=<?php echo $mesyuarat; ?>&dwn=<?php echo $dewan?>','kalMaklum',800,600,true)"> Senarai Kakitangan Belum Maklum (<?php echo $countBelum?>)||</a> //--> 
			  <?php if($isCalHek && ($_POST['KalEdit'])){ ?> 
			  <a href="Javascript:NewWindow('tambah.php?action=newdocKal&id=<?php echo $id; ?>&plm=<?php echo $parlimen; ?>&pgl=<?php echo $penggal; ?>&msyt=<?php echo $mesyuarat; ?>&dwn=<?php echo $dewan;?>','kalMaklum',800,600,true)"><img src="images/but_add.gif" border="0" align="absmiddle">Tambah Hari </a>
		  <?php } }?>
		  </td>
		</tr>
	</table>
	<table width=100%% class="listView" style="border-color:#C0C0C0" border="1" >
	  <tr>
		<th width="1">&nbsp;</th>
		<th width="42">Hari </th>
		<th width="81">Tarikh </th>
		 <?php //<th width="51">Sesi</th> ?>
		<th width="89">Agensi / Bahagian di Kementerian Kesihatan </th>
		<th width="267">Pegawai Bertugas</th>
		<th width="266">Pertanyaan Lisan / Isu Yang dibangkitkan </th>
		<?php if($isCalHek){?>
			<th width="65">Maklum?</th>
		<?php }?>
		<?php if($isCalHek && ($_POST['KalEdit'])){?>
			<th width="65">Tindakan</th>
		<?php }?>
	  </tr> 
		<?php 
		$sqlPgw	= "SELECT * 
					FROM kal_pegawaitugas 
					WHERE 
						Kal_mesyuarat_id='$id' ";
		if(isset($dewan)){ 
			$sqlPgw .= "AND	Dewan='$dewan' "; 
		}
		$sqlPgw .= "ORDER BY Tarikh ASC, Kal_pegawaiTugas_id ASC, Sesi ASC";
		
		//echo $sqlPgw; //debug
		
		$rsPgw	= mysql_query($sqlPgw) or die(mysql_error());
		$weekCounter = 0;
		$x = 0;
	  
	  while($rowPgw=mysql_fetch_array($rsPgw)){
		$idPgw		= $rowPgw['Kal_pegawaiTugas_id'];
		$currDewan	= $rowPgw['Dewan'];
		$currWeek	= findWeek($rowPgw['Tarikh']);
		$currDate	= date("d-M-Y",strtotime($rowPgw['Tarikh']));
		$maklumEmail= ($rowPgw['Maklum_email']=='0')? "<div style=\"background-color:#F79C8C\">BELUM": "SUDAH";		
		$hari		= findHari($rowPgw['Tarikh']);
		$namaPgw	= $rowPgw['PegawaiBtugas'];
		if(!empty($namaPgw)){
			$telOPgw	= lookup($conn, "pengguna", "telefon", "nama='$namaPgw'");
			$telHpPgw	= lookup($conn, "pengguna", "handphone", "nama='$namaPgw'");
			$emailPgw	= lookup($conn, "pengguna", "emel", "nama='$namaPgw'");		
		}
		$dplcateDewan = ($currDewan==$preDewan)? true:false;
		$dplcateWeek = ($currWeek==$preWeek)? true:false;
		$duplicate	= ($currDate==$preDate)? true:false;
		
		switch($rowPgw['Agensi']){
			case 'KWP' : $agen='kwp';break;
			case 'DBKL' : $agen='dbkl';break;
			case 'PERBADANAN PUTRAJAYA' : $agen='ppj';break;
			case 'PERBADANAN LABUAN' : $agen='pl';break;
		}
		?>
		
		<?php // add pd 9/1/2008
		//if ($_GET["Action"]=="padam")
	//delete($_GET["Id"]); 

/*{
	/*
	$msg = "Masuk delete";
	print '<script>';
	echo " alert(\"Status: $msg.$id\");";
	//echo "window.opener.location.reload();window.close()";
	//print '	window.close()';
	print '</script>';*/
	
/*	$query = "DELETE FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id' ";
	//echo $query;
	$result = mysql_query($query);
	if(!$result) error_message(sql_error());

	$msg = "Permohonan berjaya dipadam.";
	print '<script>';
	echo " alert(\"Status: $msg\");";
	//echo "window.location.reload()";
	//print '	window.close()';
	print '	window.location.href = "inc_kalPegawaiBtugas.php";';
	print '</script>';
	exit();
} */
		
	?>	
		
		
		<?php
		if (!$dplcateDewan){
			 ?>
			<tr>
				<td colspan="9" class="group1" style="background-color:#FFCCCC"><strong>DEWAN <?php echo strtoupper($currDewan)?></strong></td>
			</tr>
			<?php 
		}
		?>
	
		<?php
		if (!$dplcateWeek){
			$weekCounter++;
			 ?>
			<tr>
				<td colspan="9" style="padding-left:18 "><strong> Minggu <?php echo $rowPgw['Minggu']?></strong></td>
			</tr>
			<?php 
		}
		?>
		<?php if($rowPgw['Agensi']=='CUTI'){?> 
			<tr>
				<td>&nbsp;</td>
				<td class="cuti"><?php echo (!$duplicate)? $hari:""?></td>
				<td class="cuti"><?php echo (!$duplicate)?$currDate:""?></td>
				<td colspan="6" class="cuti"><?php echo $rowPgw['Agensi'];?></td>
			</tr>
		<?php }
		else{
			switch($rowPgw['Agensi']){
				case 'DBKL': $thisAgensiId=array(1); break;
				case 'KWP': $thisAgensiId=array(2,3); break;
				case 'PERBADANAN PUTRAJAYA': $thisAgensiId=array(4,5,6,7); break;
			}
			$a	= $_SESSION['agensi_id'];
			$isAgensiBertugas = false;
			foreach($thisAgensiId as $agensi){
				if($agensi == $a){ $isAgensiBertugas = true; }
			}
			?>
			<?php $alt = ((floor($x/4))%2)? "odd":"even"; ?>
			<tr>
				<td class=" <?php echo $alt; ?>" width="1px">&nbsp;</td>
				<td class=" <?php echo $alt; ?>">
				<?php echo (!$duplicate)? $hari :""?>
				<?php 
				if($isCalHek && ($_POST['KalEdit'])){
					if(!$duplicate){ ?>
						<img src="images/bt_edit.png" alt="Catatan Cuti/Tiada Bersidang" style="cursor:pointer" onClick="NewWindow('KalSub_hari.php?id=<?php echo $id;?>&tkh=<?php echo $rowPgw['Tarikh'];?>&agen=<?php echo $agen;?>&hari=<?php echo $hari;?>','editPegawai',650,400,true)">
						<img src="images/delete.gif" alt="Hapus hari ini" style="cursor:pointer" onClick="">
				<?php 
					}
				} ?>
				</td>
				<td class=" <?php echo $alt; ?>"><?php echo (!$duplicate)?$currDate:""?></td>
			<?php // azila hide	<td class=" <?php echo $alt; ?> <? //"><?php echo $rowPgw['Sesi']</td>?>
				<?php if($rowPgw['Agensi']==''){
					echo "<td class=\"".$alt."\" colspan=\"5\" align=\"center\">TIADA SIDANG PADA WAKTU PETANG</td>";
				 } else{?>
					<td class=" <?php echo $alt; ?>" width="89"><?php echo $rowPgw['Agensi'];?></td>
			  <td class=" <?php echo $alt; ?>" width="267">		  		<?php echo $rowPgw['PegawaiBtugas']?><br>
					(<?php echo $telOPgw?>/<?php echo $telHPPgw?>)<br>
	  		  <?php echo $emailPgw?>			  </td>
					<td class=" <?php echo $alt; ?>" width="266"><?php echo nl2br($rowPgw['Catatan'])?> </td>
					<?php if($isCalHek){?>
						<td class=" <?php echo $alt; ?>" width="65" align="center"><?php echo $maklumEmail;?></div></td>
					<?php }?>
					<?php if($isCalHek && ($_POST['KalEdit'])){?>
						<td class=" <?php echo $alt; ?>" width="65" align="center">
							<img src="../images/person.jpg" alt="Tukar Pegawai / Masukkan catatan" style="cursor:pointer" onClick="NewWindow('KalSub_Pegawai.php?id=<?php echo $idPgw;?>&agen=<?php echo $agen;?>','editPegawai',650,400,true)">
						</td>
					<?php }?>
				<?php }?>
			</tr>
			<?php 
		}
		$preDate	= $currDate;
		$preWeek	= $currWeek;
		$preDewan	= $currDewan;
		$x++;
		} 
		?>
	</table>
	<br>
	<?php 
	}
}
?>