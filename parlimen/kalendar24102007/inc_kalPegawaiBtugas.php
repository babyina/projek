<?php 

if(!$id) echo "";
else{
if($_GET['action']=='detailsKal' || $_GET['action']=='newdocKal'){
?><fieldset><legend>Pegawai Bertugas </legend>
<br>
<table width=100% class="listView" style="border-color:#C0C0C0" border="1" >
  <tr>
    <th>&nbsp;</th>
	<th>Hari </th>
	<th width="90">Tarikh </th>
    <th width="213">Agensi / Bahagian di Kementerian Kesihatan </th>
    <th width="207">Pegawai Bertugas</th>
    <th width="67">Sesi</th>
    <th width="383">Pertanyaan Lisan / Isu Yang dibangkitkan </th>
  </tr> 
  <?php 
  $sqlPgw	= "SELECT * FROM kal_pegawaitugas WHERE Kal_mesyuarat_id='$id' ORDER BY Tarikh ASC, Kal_pegawaiTugas_id ASC, Sesi ASC";
  $rsPgw	= mysql_query($sqlPgw) or die(mysql_error());
  $weekCounter	= 0;
  
  while($rowPgw=mysql_fetch_array($rsPgw)){
	$idPgw		= $rowPgw['Kal_pegawaiTugas_id'];
	$currWeek	= findWeek($rowPgw['Tarikh']);
	$currDate	= date("d-M-Y",strtotime($rowPgw['Tarikh']));
	$hari		= findHari($rowPgw['Tarikh']);
	$dplcateWeek = ($currWeek==$preWeek)? true:false;
	$duplicate	= ($currDate==$preDate)? true:false;
	switch($rowPgw['Agensi']){
		case 'KWP' : $agen='k';break;
		case 'DBKL' : $agen='d';break;
		case 'PERBADANAN PUTRAJAYA' : $agen='p';break;
	}
	
	if (!$dplcateWeek){
		$weekCounter++;
 		 ?>
		<tr>
			<td colspan="7"><img src="images/drop2.gif"><strong> Minggu <?php echo $weekCounter?> </strong></td>
		</tr>
  		<?php 
	}
	?>
	<?php if($rowPgw['Agensi']=='CUTI'){?> 
		<tr>
			<td></td>
			<td class="cuti"><?php echo (!$duplicate)? $hari:""?></td>
			<td class="cuti"><?php echo (!$duplicate)?$currDate:""?></td>
			<td colspan="4" class="cuti"><?php echo $rowPgw['Agensi'];?></td>
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
	<tr >
		<td>&nbsp;</td>
		<td><?php echo (!$duplicate)? $hari.'('.hari($currDate).')':""?></td>
		<td><?php echo (!$duplicate)?$currDate:""?></td>
		<td><?php echo $rowPgw['Agensi'];?></td>
		<td><?php echo $rowPgw['PegawaiBtugas']?><?php if($isCalHek && ($_POST['KalEdit'])){?> <a href="javascript:NewWindow('KalSub_Pegawai.php?id=<?php echo $idPgw;?>&agen=<?php echo $agen;?>','editPegawai',500,180,true)"><img src="images/bt_edit.png" width="10" height="10" border="0"></a><?php }?></td>
		<td><?php echo $rowPgw['Sesi']?></td>
		<td><?php echo nl2br($rowPgw['Catatan'])?><?php if(($isCalHek || $isAgensiBertugas) && ($_POST['KalEdit'])){?> <a href="javascript:NewWindow('KalSub_catatan.php?id=<?php echo $idPgw;?>','editCatatan',600,300,true)"><img src="images/bt_edit.png" width="10" height="10" border="0"></a><?php }?></td>
	</tr>
	<?php 
	}
	$preDate	= $currDate;
	$preWeek	= $currWeek;
	} 
	?>
</table>
<br>
</fieldset>

<br>
<?php 
}
}
?>