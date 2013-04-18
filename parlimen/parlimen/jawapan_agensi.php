<?php
//session_start();
//echo "telah masuk";
$header = true;
//---------------------------------------------------------------//
//--      List of agensi's answers    ---------------------------//
//----- ---------------------------------------------------------//
$qry = "SELECT agensi.nama,nama_pegawai,no_telefon,jawapan,tambahan,keterangan_tambahan, 
		parlimen_agensi.id AS id,parlimen_agensi.agensi_id,	parlimen_agensi.status, parlimen_agensi.status_pindaan,
		penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan, tkh_terima,
		penyedia_no_tel_pej,penyedia_no_hp,pengesah_no_tel_pej,pengesah_no_hp,disemak_oleh,penyemak_jawatan,penyemak_no_tel_pej,
		penyemak_no_hp,parlimen.jns_soalan AS jns_soalan,parlimen.status As status1
		FROM parlimen_agensi,agensi,parlimen
		WHERE parlimen_agensi.parlimen_id = '$id' AND parlimen.id ='$id' AND parlimen_agensi.agensi_id = agensi.id";
		
	//echo $qry ;
$result = mysql_query($qry,$conn);
 //echo "sini lagi xxx";
while($row2 = mysql_fetch_array($result)){
 
	$tkh_terima = "";
	$status_pindaan = "";
	$isPegawai = checkACL($_SESSION['userid'],9,$row2['agensi_id'],$conn);	
	$isSub = checkACL($_SESSION['userid'],6,$row2['agensi_id'],$conn);
	$isPegawaiview = checkACL($_SESSION['userid'],2,$row2['agensi_id'],$conn);	
	$agensi_id=$row2['agensi_id'];
	$_SESSION['agensi_id'] = $row2['agensi_id'];	
	$jawapan_id = $row2['id']; //id jawpan_agensi
	$status_pindaan = $row2['status_pindaan'];
	
	$jawapan_agensi = $row2['jawapan']; 
	$jawapan_agensi=preg_replace('/<a name="OLE_LINK([0-9])">(.*?)<\/a>/i', '\\2',$jawapan_agensi);
	$status_agensi = $row2['status'];
	$mak_tamb = $row2['tambahan'];
	$mak_tamb =preg_replace('/<a name="OLE_LINK([0-9])">(.*?)<\/a>/i', '\\2',$mak_tamb);
	$jns_soalan = $row2['jns_soalan'];
	$status1 = $row2['status1'];
	//echo $status1;
	//echo 	$jns_soalan;
	//echo "idagen".$_SESSION['agensi_id'];
	/*if(!empty($row2['tambahan']))
		$jawapan_agensi .= "<br><br><br><b>Maklumat Tambahan</b></br><br>".$row2['tambahan'];
	if(!empty($row2['keterangan_tambahan']))
		$jawapan_agensi .= "<br><br><br><b>Keterangan Tambahan</b></br><br>".$row2['keterangan_tambahan']; */
	if ($status_agensi == 1){
		$tag = "Telah Dibaca";}
		else
	if($status_agensi == 2){
		$tag ="Telah Hantar";}	
	else
		$tag = "Belum Dibaca";
	 
   	
				
		
		
	if($row2['tkh_terima']<>"0000-00-00")
		$tkh_terima .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan=\"3\"><font color=\"#336699\">Jawapan telah dihantar pada ".Reverse($row2['tkh_terima'])."</font><br /></td></tr>";	
	else
		$tkh_terima = "";

	$penyedia = !empty($row2['penyedia_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disediakan oleh  :  ".$row2['penyedia_nama']."  (".($row2['penyedia_jawatan']).") (".($row2['penyedia_no_tel_pej']).",".($row2['penyedia_no_hp']).")</font><br /></td></tr>":"";
	$penyemak = !empty($row2['disemak_oleh'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disemak oleh  :  ".$row2['disemak_oleh']."  (".($row2['penyemak_jawatan']).") (".($row2['penyemak_no_tel_pej']).",".($row2['penyemak_no_hp']).")</font><br /></td></tr>":"";
	$pengesah = !empty($row2['pengesah_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Dihantar kepada &nbsp;&nbsp;: ".$row2['pengesah_nama']."  (".($row2['pengesah_jawatan']).") (".($row2['pengesah_no_tel_pej']).",".($row2['pengesah_no_hp']).")</font><br /></td></tr>":"";
	$count++;
	$div = "agensi".$count;
	$img_collapse = "img_collapse".$count;
	$state_per = "state".$count;
	?>
	<script language="javascript">
		var <?php echo $state_per ?> = 1;

	</script>


	<?php
	# pastikan hanya agensi yg terlibat nampak agensinya sahaja 
	//for Pegawai agensi
	#anybody(except pegawai agensi lain) with access <5 supposely can see
	
	  
	$view = 0;
	if($isPegawai)
		$view = 1;
	//if(($isHEK || $isPengurusan || $isPengesahan) && $sys_acl <5) asal pada 6 feb 2009
	if(($isHEK || $isPengurusan ||$isPegawaiview||$isAngPentadbiran|| $isPengesahan ||$isKSP) && $sys_acl <5)
		$view = 1;
	
	if($view == 1)
	{
	   //echo "sini lagi";
		if($header)
		
			echo "<div><strong>&nbsp;&nbsp;&nbsp;JAWAPAN BAHAGIAN/AGENSI</strong></div><br />";
	?>
	
	<br />
	<!--<fieldset class="<?php echo highlight($status==21||$status==22||$status==10) ?>"><legend><b><?php echo $row2['nama']." - ".$tag ?></b></legend>--> 
	<?php //asal pada 6 feb 2009 ?>
	<fieldset  style="width:auto "class="<?php echo highlight($status==21||$status==22||$status==10) ?>"><legend style="width:auto"><b><?php echo $row2['nama'] ?></b></legend>
	
	<div class="sub">
	   
		<table border=0 width="100%" cellpadding="2">
	 
	   <?php
	    if(!empty($jawapan_agensi))
		{
	    $q2 = "SELECT jns_soalan FROM parlimen WHERE id='$id'";	
		$r2 = mysql_query($q2,$conn);
		$rows2 = mysql_fetch_array($r2);
		$kod=$rows2['jns_soalan'];
		//echo "kod".$kod.$q2;
		if(!empty($kod))
		{
		$q = "SELECT butiran FROM konfigurasi WHERE kod='$kod'";	
		$r = mysql_query($q,$conn);
		//echo $q;
		$rows = mysql_fetch_array($r);
		$butiran=$rows['butiran'];
		$td1 = "<strong><font color=\"#FF0000\">".$butiran."</strong></b><br/>"; 
		echo $td1;
		}
		}
	
	echo $tkh_terima.$penyedia.$penyemak.$pengesah; ?>
			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>

         <?php 
		if(!empty($jawapan_agensi))
		{
		?>
		  <tr>
		  	<td width=209>
			  Nama Pegawai Isi Jawapan </td>
		  	<td width=8>
			  :</td><td width="753">
			    <?php echo $row2['nama_pegawai'] ?></td>
		  </tr>
			
			<?php }?>
		<?php 
		if($isPengurusan)
		{
		?>
        <tr>
			  <td>Jawapan</td>
			  <td>:</td>
			  <td colspan="2">
				<?php createRTF($sBasePath, 'jawapan',$jawapan_agensi);?>		  </td>
		  </tr>
        <?php
		}
		else{
		if(!empty($jawapan_agensi))
		{
		?>
		
			<tr>
			  <td>Jawapan</td>
			  <td>:</td>
			  <td colspan="2">
				<!--<div class="scroll">-->
				<?php createRTF2($sBasePath, 'jawapan',$jawapan_agensi);
				 
					//echo $jawapan_agensi;
				?>
				<!--</div>	-->		  </td>
		  </tr>
		<?php 
		}
		}
		if($isPengurusan)
		{?>
		<tr>
			  <td>Maklumat Tambahan</td>
			  <td>:</td>
			  <td colspan="2">
				<?php createRTF($sBasePath, 'mak_tamb',$mak_tamb);?>		  </td>
		  </tr><?php 
		}
		else{
		if(!empty($row2['tambahan'])){ ?>
			<tr>
			  <td>Maklumat Tambahan </td>
			  <td>:</td>
			  <td><!--<div class="scroll">-->
				<?php createRTF2($sBasePath, 'mak_tamb',$mak_tamb);
					//echo $mak_tamb;
				?>
				<!--</div>-->   </td>         
		  </tr> <?php }
		 }?>
		  
		  <?php if(!empty($row2['keterangan_tambahan'])){ ?>
			<tr>
			  <td>Keterangan Tambahan </td>
			  <td>:</td>
			  <td><div class="scroll">
				<?php 
					echo $row2['keterangan_tambahan'];
				?>
				</div></td>            
		  </tr> <?php }?>
		  
		  <?php 
		if(!empty($jawapan_agensi))
		{
		?>
		  
			<tr><td width=209>Lampiran</td>
			  <td width=8>:</td>
			  <td>
				<?php //display the attachments if any				
				$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id='$jawapan_id'";
				$res = mysql_query($qry,$conn);
				while($row3 = mysql_fetch_array($res)){
					$nama_fail = $row3['nama_fail']; 
					$nama_fail_label = $row3['nama_fail']; 
					$nama_fail =rawurlencode($nama_fail);
					
					
					$path = "../parlimen/lampiran/$nama_fail";
					echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail_label</a>&nbsp;&nbsp;<br>";
				}	     
				}?>				</tr>			
			<?php
				//}
				//echo   "status".$status;
				if($status==12 ||$status==15 ||$status==18 ) // utk view catatan dr HEK - pindaan
				{
					//$query = "select catatan from parlimen_agensi where id='$jawapan_id'";'$id' asal
					 if ($status==12)
					$query = "select pengurusan_catatan  as catatan,pengurusan_jawatan as jawatan  from parlimen where id='$id'";
					else if ($status==15)
					$query = "select pengesahan_catatan as catatan,pengesahan_jawatan as jawatan from parlimen where id='$id'";
					else
					$query = "select korperat_catatan as catatan,korperat_jawatan as jawatan  from parlimen where id='$id'";
					
					$re = mysql_query($query,$conn);
					//echo $query;
					$row4 = mysql_fetch_array($re);
					//if(!empty($row4['catatan']))
					//{
					?>			
					<!--<tr>
					<td width=209>Catatan <?php echo $row4['jawatan'] ?></td><td width=8>:</td> 
					<td bgcolor="FFFFFF"><?php echo $row4['catatan'] ?></td></tr>-->
				<?php 
					//}
					//else if (!empty($row4['pengesahan_catatan']))
					//{
					?>			
					
				<?php 
					//}
					
					 
				} 
			?>			
		</table>	
			<?php
			$editable= ($_SESSION['nama']==$row2['nama_pegawai']);
			
			if(($status==21 || $status==22)&& $isPegawai && empty($jawapan_agensi)){ 
				//echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
				
				//update status_agensi kpd 1
				$qry = "UPDATE parlimen_agensi SET status = 1 WHERE id='$jawapan_id'";
				mysql_query($qry,$conn) or die(mysql_error());
				
				//check adakah semua sudah dibaca, status==1 
				$qry = "SELECT status FROM parlimen_agensi WHERE parlimen_id='$id'";
				$res = mysql_query($qry,$conn) or die(mysql_error());
				$count = mysql_num_rows($res);
				while($rows = mysql_fetch_array($res)){
					$temp[] = $rows['status'];
				}		
				
				/*if(count($temp)==$count) //semua jawapan sudah dibaca 
				{				
				$qry = "UPDATE parlimen SET status = 23 WHERE id='$id'";
				mysql_query($qry,$conn) or die(mysql_error());
				}*/
			
			}
			//start from here for kemaskini jawapan pull in after jawapan_pengurusan on 14 jan 2010
			/*elseif($status==15 && $isPegawai){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			//}
			}elseif($status==18 && $isPegawai){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			}
			elseif($status==22&& $isPegawai){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			}
			
			elseif( $status== 23 && $isPegawai && ($tkh_terima=="") && ($status_agensi==1 || $status_agensi == 0)){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini bJawapan ] </a>";
			}
			//elseif(($status==10) && $isPegawai && $editable && ($status_pindaan==0)){
			elseif(($status==12) && $isPegawai && $editable && ($status_pindaan==0)){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			} */
	     //end here 14jan 2009
		?>
	</div>
	</fieldset>
	<br />
<?php 
	$header = false;
	} //if

}//while

 ?>