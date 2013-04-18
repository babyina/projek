<?php
//echo "test";
$qry = "SELECT penyemak,penyemak2,status,pengurusan_catatan,pengesahan_catatan, 
        pengurusan_nama,pengesahan_nama,korperat_nama,korperat_jawatan,korperat_catatan,korperat_tarikh
		 from parlimen
			WHERE parlimen.id ='$id'" ;
			
	$result = mysql_query($qry,$conn) or die(mysql_error());  
	//echo $qry ;
	$row = mysql_fetch_array($result);
	$status_semak = $row['status'];
	$penyemak1 = $row['penyemak'];
	$penyemak2 = $row['penyemak2'];
	$penyemak3 = $row['korperat_jawatan'];
	//$catatan1 = $row['pengurusan_catatan'];
	$catatan2=$row['pengesahan_catatan'];
	$nama1 = $row['pengurusan_nama'];
	$nama2 = $row['pengesahan_nama'];
	$nama3 = $row['korperat_nama'];
	
	
if(($status_semak !=21) && ( $status_semak !=22) && ( $status_semak !=25) && ($status_semak !=1)){
	if (!empty($penyemak1))
	{
	$penyemak1 = $row['penyemak'];
	$nama1 = $row['pengurusan_nama'];
	$catatan1 = $row['pengurusan_catatan'];
	$namatag="Semakan Peringkat TKSP - ";
	if (($status_semak == 13) || ($status_semak == 15)) {
		$tagstatus = "Telah Semak /Hantar ke KSP";}
		else
	if($status_semak == 12){
		$tagstatus ="Telah Semak/ Pindaan diperlukan";}	
	else
	if($status_semak == 14){
		$tagstatus ="Pindaan telah diterima";}	
		
		else
	if($status_semak == 16){
		$tagstatus ="Telah Semak /Hantar Ke MKII/PTTK MK ";}	
	else 
	if($status_semak >16){
		$tagstatus ="Telah Semak ";}	
		else
		if ($status_semak == 4){
			$tagstatus ="belum Semak ";}
		
		if ($status_semak == 9){
			$tagstatus ="Telah Semak  ";}
	
	include("jawapan_statustksp_ksp.php");		
	
	}
	
	if (!empty($penyemak2))
	{
	$penyemak1 = $row['penyemak2'];
	$nama1 = $row['pengesahan_nama'];
	$catatan1=$row['pengesahan_catatan'];
	$namatag="Semakan KSP - ";
		
	if ($status_semak == 13){
		$tagstatus = "Belum Semak";}
		else
	if($status_semak == 17){
		$tagstatus ="Pindaan telah diterima";}	
	else
	if($status_semak == 15){
		$tagstatus ="Telah Semak/ Pindaan diperlukan";}	
		
		else
	if($status_semak == 16){
		$tagstatus ="Telah Semak /Hantar Ke MKII/PTTK MK";}	
	
	
	include("jawapan_statustksp_ksp.php");		
	
	
	}
	if(($status_semak == 16) || ($status_semak == 18) || ($status_semak == 19) || ($status_semak == 9))
	{
	if (!empty($penyemak3))
	{
	$penyemak1 = $row['korperat_jawatan'];
	$namatag="Semakan - ";
	if (!empty ($penyemak1))
	{
	
	$penyemak1 = $row['korperat_jawatan'];
	
	}
	else
	{
	$penyemak1 = "MK II/PTTK MK";
	}
	$nama1 = $row['korperat_nama'];
	//$nama1 = $row['korperat_nama'];
	//$nama1 = $penyemak1;
	$catatan1 = $row['korperat_catatan'];
	
	if($status_semak == 18){
		$tagstatus ="Pindaan diperlukan";}	
	else
	if($status_semak == 19){
		$tagstatus ="Pindaan diterima";}	 
		
		else
	if($status_semak == 16){
		$tagstatus ="Draf Jawapan Akhir Sedang dimasukkan";}	
	
	else
	{
	  $tagstatus ="Telah Semak Draf Jawapan SSJP";}
	include("jawapan_statustksp_ksp.php");		
	}
	}
	}
	?>
