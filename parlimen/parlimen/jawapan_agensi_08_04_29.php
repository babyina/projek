<?php
session_start();


//---------------------------------------------------------------//
//--      List of agensi's answers    ---------------------------//
//----- ---------------------------------------------------------//
$qry = "SELECT agensi.nama,nama_pegawai,no_telefon,jawapan,tambahan,keterangan_tambahan, 
		parlimen_agensi.id AS id,parlimen_agensi.agensi_id,	parlimen_agensi.status, parlimen_agensi.status_pindaan,
		penyedia_nama,penyedia_jawatan,pengesah_nama,pengesah_jawatan,tkh_terima,penyedia_no_tel_pej,penyedia_no_hp,
		pengesah_no_tel_pej,pengesah_no_hp,disemak_oleh,penyemak_jawatan,penyemak_no_tel_pej,penyemak_no_hp
		FROM parlimen_agensi,agensi
		WHERE parlimen_agensi.parlimen_id = '$id' AND parlimen_agensi.agensi_id = agensi.id";
$result = mysql_query($qry,$conn);

while($row2 = mysql_fetch_array($result)){
	$tkh_terima = "";
	$status_pindaan = "";
	$isPegawai = checkACL($_SESSION['userid'],9,$row2['agensi_id'],$conn);	
	$agensi_id=$row2['agensi_id'];
	$jawapan_id = $row2['id']; //id jawpan_agensi
	$status_pindaan = $row2['status_pindaan'];
	$jawapan_agensi = $row2['jawapan']; 
	$status_agensi = $row2['status'];
	$mak_tamb = $row2['tambahan'];
	
	/*if(!empty($row2['tambahan']))
		$jawapan_agensi .= "<br><br><br><b>Maklumat Tambahan</b></br><br>".$row2['tambahan'];
	if(!empty($row2['keterangan_tambahan']))
		$jawapan_agensi .= "<br><br><br><b>Keterangan Tambahan</b></br><br>".$row2['keterangan_tambahan']; */
	if ($status_agensi==1)
		$tag = "Telah Dibaca";
	else
		$tag = "Belum Dibaca";
		
	if($row2['tkh_terima']<>"0000-00-00")
		$tkh_terima .= "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td colspan=\"3\"><font color=\"#336699\">Jawapan telah dihantar pada ".Reverse($row2['tkh_terima'])."</font><br /></td></tr>";	
	else
		$tkh_terima = "";
/*
	$penyedia = !empty($row2['penyedia_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disediakan oleh  :  ".$row2['penyedia_nama']."  (".($row2['penyedia_jawatan']).")</font><br /></td></tr>":"";
	$pengesah = !empty($row2['pengesah_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disahkan oleh &nbsp;&nbsp;:  ".$row2['pengesah_nama']."  (".($row2['pengesah_jawatan']).")</font><br /></td></tr>":"";
	$penyemak = !empty($row2['disemak_oleh'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disemak oleh  :  ".$row2['disemak_oleh']."  (".($row2['disemak_oleh']).")</font><br /></td></tr>":"";
*/
	$penyedia = !empty($row2['penyedia_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disediakan oleh  :  ".$row2['penyedia_nama']."  (".($row2['penyedia_jawatan']).") (".($row2['penyedia_no_tel_pej']).",".($row2['penyedia_no_hp']).")</font><br /></td></tr>":"";
	$penyemak = !empty($row2['disemak_oleh'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disemak oleh  :  ".$row2['disemak_oleh']."  (".($row2['disemak_oleh']).") (".($row2['penyemak_no_tel_pej']).",".($row2['penyemak_no_hp']).")</font><br /></td></tr>":"";
	$pengesah = !empty($row2['pengesah_nama'])?"<tr><td colspan=\"3\"> <font color=\"#336699\">Disahkan oleh &nbsp;&nbsp;: ".$row2['pengesah_nama']."  (".($row2['pengesah_jawatan']).") (".($row2['pengesah_no_tel_pej']).",".($row2['pengesah_no_hp']).")</font><br /></td></tr>":"";

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
	if(($isHEK || $isPengurusan || $isPengesahan) && $sys_acl <5)
		$view = 1;
	
	if($view == 1)
	{
	
		if($header)
			echo "<div><strong>&nbsp;&nbsp;&nbsp;JAWAPAN BAHAGIAN/AGENSI</strong></div><br />";
	?>
	
	<br />
	<fieldset class="<?php echo highlight($status==21||$status==22||$status==10) ?>"><legend><b><?php echo $row2['nama']." - ".$tag ?></b></legend>
	<div class="sub">
	   
		<table border=0 width="100%" cellpadding="2">
	 
	   <?php echo $tkh_terima.$penyedia.$pengesah; ?>
			
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		  </tr>


		  <tr>
		  	<td width=209>
			  Nama Pegawai Isi Jawapan </td>
		  	<td width=8>
			  :</td><td width="753">
			    <?php echo $row2['nama_pegawai'] ?></td>
			</tr>
			
			
		<?php 
		if(!empty($jawapan_agensi))
		{
		?>
		
			<tr>
			  <td>Jawapan</td>
			  <td>:</td>
			  <td colspan="2">
				<div class="scroll">
				<?php 
					echo $jawapan_agensi;
				?>
				</div>			  </td>
		  </tr>
		<?php 
		}
		if(!empty($row2['tambahan'])){ ?>
			<tr>
			  <td>Maklumat Tambahan </td>
			  <td>:</td>
			  <td><div class="scroll">
				<?php 
					echo $mak_tamb;
				?>
				</div></td>            
		  </tr> <?php }?>
		  
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
		  
		  
		  
			<tr><td width=209>Lampiran</td>
			  <td width=8>:</td>
			  <td>
				<?php //display the attachments if any				
				$qry = "SELECT * FROM parlimen_lampiran WHERE jawapan_id='$jawapan_id'";
				$res = mysql_query($qry,$conn);
				while($row3 = mysql_fetch_array($res)){
					$nama_fail = $row3['nama_fail']; 
					$path = "../parlimen/lampiran/$nama_fail";
					echo "<a href=\"\" onClick=\"window.open('$path','mywin');return(false);\">$nama_fail</a>&nbsp;&nbsp;<br>";
				}	     
				?>				</tr>			
			<?php
				//}
				if($status==10) // utk view catatan dr HEK - pindaan
				{
					$query = "select catatan from parlimen_agensi where id='$jawapan_id'";
					$re = mysql_query($query,$conn);
					$row4 = mysql_fetch_array($re);
					if(!empty($row4['catatan']))
					{
					?>			
					<tr><td width=209>Catatan</td><td width=8>:</td>
					<td bgcolor="FFFFFF"><?php echo $row4['catatan'] ?></td></tr>
				<?php 
					}
				} 
			?>			
		</table>	
			<?php
			$editable= ($_SESSION['nama']==$row2['nama_pegawai']);
			
			if(($status==21 || $status==22) && $isPegawai && empty($jawapan_agensi)){ 
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
				
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
				
				if(count($temp)==$count) //semua jawapan sudah dibaca
				{				
				$qry = "UPDATE parlimen SET status = 22 WHERE id='$id'";
				mysql_query($qry,$conn) or die(mysql_error());
				}
			
			}elseif($status==22 && $isPegawai && ($tkh_terima=="")){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			}
			elseif(($status==10) && $isPegawai && $editable && ($status_pindaan==0)){
				echo "<br><a href=\"\" onClick=\"edit_jawapan($jawapan_id,$status);return(false);\" >[ Kemaskini Jawapan ] </a>";
			}
	
		?>
	</div>
	</fieldset>
	<br />
<?php 
	$header = false;
	} //if

}//while

 ?>